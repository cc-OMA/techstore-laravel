<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect('/products/' . $product->id)
            ->with('success', 'Review added successfully.');
    }
}