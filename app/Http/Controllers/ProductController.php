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
        $sort = $request->sort;

        $products = Product::query();

        if ($search) {
            $products->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if ($sort == 'price_low_high') {
            $products->orderBy('price', 'asc');
        } elseif ($sort == 'price_high_low') {
            $products->orderBy('price', 'desc');
        } elseif ($sort == 'newest') {
            $products->latest();
        } else {
            $products->latest();
        }

        $products = $products->paginate(8)->withQueryString();

        if (Auth::check()) {
            $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
        } else {
            $cartCount = 0;
        }

        return view('welcome', compact('products', 'cartCount', 'search', 'sort'));
    }

    public function adminProducts(Request $request)
    {
        $search = $request->search;

        $products = Product::with('category');

        if ($search) {
            $products->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $products = $products->latest()->get();

        return view('products.admin', compact('products', 'search'));
    }

    public function categoryProducts(Request $request, Category $category)
    {
        $sort = $request->sort;

        $products = Product::where('category_id', $category->id);

        if ($sort == 'price_low_high') {
            $products->orderBy('price', 'asc');
        } elseif ($sort == 'price_high_low') {
            $products->orderBy('price', 'desc');
        } elseif ($sort == 'newest') {
            $products->latest();
        } else {
            $products->latest();
        }

        $products = $products->paginate(8)->withQueryString();

        if (Auth::check()) {
            $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
        } else {
            $cartCount = 0;
        }

        $search = null;
        $selectedCategory = $category;

        return view('welcome', compact('products', 'cartCount', 'search', 'selectedCategory', 'sort'));
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
        $product->load(['category', 'reviews.user']);

        if (Auth::check()) {
            $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
        } else {
            $cartCount = 0;
        }

        $averageRating = $product->reviews->avg('rating');
        $reviewCount = $product->reviews->count();

        return view('products.show', compact(
            'product',
            'cartCount',
            'averageRating',
            'reviewCount'
        ));
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