<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $cartCount = Cart::sum('quantity');

        return view('welcome', compact('products', 'cartCount'));
    }

    public function cart()
    {
        $cartItems = Cart::all();

        $totalPrice = 0;

        foreach ($cartItems as $item) {
            $totalPrice += $item->product->price * $item->quantity;
        }

        return view('cart', compact('cartItems', 'totalPrice'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $imagePath = $request->file('image')->store('products', 'public');

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $imagePath,
            'description' => $request->description,
        ]);

        return redirect('/');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        return redirect('/');
    }

    public function addToCart(Product $product)
    {
        $cartItem = Cart::where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            Cart::create([
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        return redirect('/');
    }

    public function removeFromCart(Cart $cart)
    {
        if ($cart->quantity > 1) {
            $cart->decrement('quantity');
        } else {
            $cart->delete();
        }

        return redirect('/cart');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect('/');
    }
}