<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;

Route::get('/', [ProductController::class, 'index']);

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin/products', [ProductController::class, 'adminProducts']);

    Route::get('/products/create', [ProductController::class, 'create']);
    Route::post('/products', [ProductController::class, 'store']);

    Route::get('/products/{product}/edit', [ProductController::class, 'edit']);
    Route::put('/products/{product}', [ProductController::class, 'update']);

    Route::delete('/products/{product}', [ProductController::class, 'destroy']);

    Route::get('/admin/orders', [OrderController::class, 'adminIndex']);
    Route::put('/admin/orders/{order}', [OrderController::class, 'updateStatus']);
});

Route::middleware('auth')->group(function () {
    Route::post('/order/place', [OrderController::class, 'placeOrder']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);
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

    $totalRevenue = Order::where('status', 'completed')->sum('total_price');
    $pendingOrders = Order::where('status', 'pending')->count();
    $completedOrders = Order::where('status', 'completed')->count();
    $cancelledOrders = Order::where('status', 'cancelled')->count();

    $lowStockProducts = Product::where('stock', '>', 0)
        ->where('stock', '<=', 5)
        ->count();

    $outOfStockProducts = Product::where('stock', 0)
        ->count();

    $lowStockList = Product::where('stock', '>', 0)
        ->where('stock', '<=', 5)
        ->orderBy('stock')
        ->take(5)
        ->get();

    $recentOrders = Order::with('user')
        ->latest()
        ->take(5)
        ->get();

    $topSellingProducts = OrderItem::selectRaw('product_id, SUM(quantity) as total_sold')
        ->with('product')
        ->groupBy('product_id')
        ->orderByDesc('total_sold')
        ->take(5)
        ->get();

    return view('dashboard', compact(
        'productCount',
        'categoryCount',
        'cartItemCount',
        'orderCount',
        'totalRevenue',
        'pendingOrders',
        'completedOrders',
        'cancelledOrders',
        'lowStockProducts',
        'outOfStockProducts',
        'lowStockList',
        'recentOrders',
        'topSellingProducts'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';