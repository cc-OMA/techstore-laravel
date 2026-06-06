<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Order;

Route::get('/', [ProductController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/products/create', [ProductController::class, 'create']);
    Route::post('/products', [ProductController::class, 'store']);

    Route::get('/products/{product}/edit', [ProductController::class, 'edit']);
    Route::put('/products/{product}', [ProductController::class, 'update']);

    Route::delete('/products/{product}', [ProductController::class, 'destroy']);

    Route::post('/order/place', [OrderController::class, 'placeOrder']);
    Route::get('/orders', [OrderController::class, 'index']);
});

Route::get('/products/{product}', [ProductController::class, 'show']);

Route::post('/cart/add/{product}', [ProductController::class, 'addToCart']);
Route::get('/cart', [ProductController::class, 'cart']);
Route::delete('/cart/{cart}', [ProductController::class, 'removeFromCart']);

Route::get('/category/{category}', [ProductController::class, 'categoryProducts']);

Route::get('/dashboard', function () {
    $productCount = Product::count();
    $categoryCount = Category::count();
    $cartItemCount = Cart::sum('quantity');
    $orderCount = Order::count();

    return view('dashboard', compact(
        'productCount',
        'categoryCount',
        'cartItemCount',
        'orderCount'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';