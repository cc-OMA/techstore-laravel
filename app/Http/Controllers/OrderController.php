<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $order->load('user', 'items.product');

        return view('orders.show', compact('order'));
    }

    public function adminIndex()
    {
        $orders = Order::with('user')
            ->latest()
            ->get();

        return view('orders.admin', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $order->update([
            'status' => $request->status,
        ]);

        return redirect('/admin/orders')
            ->with('success', 'Order status updated successfully.');
    }

    public function placeOrder()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect('/cart');
        }

        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return redirect('/cart')
                    ->with('success', 'Some products do not have enough stock.');
            }
        }

        $totalPrice = 0;

        foreach ($cartItems as $item) {
            $totalPrice += $item->product->price * $item->quantity;
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);

            $item->product->decrement('stock', $item->quantity);
        }

        Cart::where('user_id', Auth::id())->delete();

        return redirect('/dashboard')
            ->with('success', 'Order placed successfully.');
    }
}