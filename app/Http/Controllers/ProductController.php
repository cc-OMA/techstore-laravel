<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('welcome', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $request->image,
            'description' => $request->description,
        ]);

        return redirect('/');
    }
}
