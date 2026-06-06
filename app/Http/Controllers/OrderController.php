<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function placeOrder()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect('/cart');
        }

        $totalPrice = 0;

        foreach ($cartItems as $item) {
            $totalPrice += $item->product->price * $item->quantity;
        }

        Order::create([
            'user_id' => Auth::id(),
            'total_price' => $totalPrice,
        ]);

        Cart::where('user_id', Auth::id())->delete();

        return redirect('/dashboard');
    }
}