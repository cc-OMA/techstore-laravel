<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        if ($search) {
            $products = Product::where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->get();
        } else {
            $products = Product::all();
        }

        if (Auth::check()) {
            $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
        } else {
            $cartCount = 0;
        }

        return view('welcome', compact('products', 'cartCount', 'search'));
    }

    public function adminProducts(Request $request)
    {
        $search = $request->search;

        if ($search) {
            $products = Product::with('category')
                ->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->latest()
                ->get();
        } else {
            $products = Product::with('category')
                ->latest()
                ->get();
        }

        return view('products.admin', compact('products', 'search'));
    }

    public function categoryProducts(Category $category)
    {
        $products = Product::where('category_id', $category->id)->get();

        if (Auth::check()) {
            $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
        } else {
            $cartCount = 0;
        }

        $search = null;
        $selectedCategory = $category;

        return view('welcome', compact('products', 'cartCount', 'search', 'selectedCategory'));
    }

    public function cart()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $cartItems = Cart::where('user_id', Auth::id())->get();

        $totalPrice = 0;

        foreach ($cartItems as $item) {
            $totalPrice += $item->product->price * $item->quantity;
        }

        return view('cart', compact('cartItems', 'totalPrice'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image',
            'description' => 'required',
        ]);

        $imagePath = $request->file('image')->store('products', 'public');

        Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'description' => $request->description,
        ]);

        return redirect('/admin/products')
            ->with('success', 'Product added successfully.');
    }

    public function show(Product $product)
    {
        if (Auth::check()) {
            $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
        } else {
            $cartCount = 0;
        }

        return view('products.show', compact('product', 'cartCount'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image',
            'description' => 'required',
        ]);

        $imagePath = $product->image;

        if ($request->hasFile('image')) {
            if ($product->image && str_starts_with($product->image, 'products/')) {
                Storage::disk('public')->delete($product->image);
            }

            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'description' => $request->description,
        ]);

        return redirect('/admin/products')
            ->with('success', 'Product updated successfully.');
    }

    public function addToCart(Product $product)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        return redirect('/')
            ->with('success', 'Product added to cart.');
    }

    public function removeFromCart(Cart $cart)
    {
        if (!Auth::check() || $cart->user_id !== Auth::id()) {
            return redirect('/cart');
        }

        if ($cart->quantity > 1) {
            $cart->decrement('quantity');
        } else {
            $cart->delete();
        }

        return redirect('/cart')
            ->with('success', 'Cart updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->image && str_starts_with($product->image, 'products/')) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect('/admin/products')
            ->with('success', 'Product deleted successfully.');
    }
}