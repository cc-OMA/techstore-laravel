<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-5 bg-light">
        <div class="container">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <h3 class="fw-bold mb-4">TechStore Overview</h3>

            <div class="row g-4">

                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h5 class="card-title text-primary fw-bold">Total Products</h5>
                            <h2 class="fw-bold">{{ $productCount }}</h2>
                            <p class="text-muted mb-0">Products available in store</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h5 class="card-title text-success fw-bold">Total Categories</h5>
                            <h2 class="fw-bold">{{ $categoryCount }}</h2>
                            <p class="text-muted mb-0">Product categories</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h5 class="card-title text-warning fw-bold">Cart Items</h5>
                            <h2 class="fw-bold">{{ $cartItemCount }}</h2>
                            <p class="text-muted mb-0">Total items added to carts</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h5 class="card-title text-danger fw-bold">Total Orders</h5>
                            <h2 class="fw-bold">{{ $orderCount }}</h2>
                            <p class="text-muted mb-0">Orders placed by users</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row g-4 mt-1">

                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h5 class="card-title text-success fw-bold">Total Revenue</h5>
                            <h2 class="fw-bold">${{ number_format($totalRevenue, 2) }}</h2>
                            <p class="text-muted mb-0">Revenue from completed orders</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h5 class="card-title text-warning fw-bold">Pending Orders</h5>
                            <h2 class="fw-bold">{{ $pendingOrders }}</h2>
                            <p class="text-muted mb-0">Waiting for processing</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h5 class="card-title text-success fw-bold">Completed Orders</h5>
                            <h2 class="fw-bold">{{ $completedOrders }}</h2>
                            <p class="text-muted mb-0">Successfully completed</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h5 class="card-title text-danger fw-bold">Cancelled Orders</h5>
                            <h2 class="fw-bold">{{ $cancelledOrders }}</h2>
                            <p class="text-muted mb-0">Cancelled by admin</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row g-4 mt-1">

                <div class="col-md-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h5 class="card-title text-warning fw-bold">Low Stock Products</h5>
                            <h2 class="fw-bold">{{ $lowStockProducts }}</h2>
                            <p class="text-muted mb-0">Products with 1 to 5 items left</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h5 class="card-title text-danger fw-bold">Out of Stock Products</h5>
                            <h2 class="fw-bold">{{ $outOfStockProducts }}</h2>
                            <p class="text-muted mb-0">Products unavailable for purchase</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-5">
                <a href="/" class="btn btn-primary">Back to Store</a>
                <a href="/products/create" class="btn btn-success ms-2">Add Product</a>
                <a href="/admin/products" class="btn btn-warning ms-2">Manage Products</a>
                <a href="/admin/orders" class="btn btn-dark ms-2">Manage Orders</a>
            </div>

            <div class="card shadow-sm border-0 mt-5">
                <div class="card-body">
                    <h4 class="fw-bold mb-4">Low Stock Alert</h4>

                    @if($lowStockList->count() == 0)
                        <div class="alert alert-success">
                            All products have enough stock.
                        </div>
                    @else
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Current Stock</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($lowStockList as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>

                                        <td>
                                            {{ $product->category->name ?? 'No Category' }}
                                        </td>

                                        <td>
                                            <span class="badge bg-warning text-dark">
                                                {{ $product->stock }} left
                                            </span>
                                        </td>

                                        <td>
                                            <a
                                                href="/products/{{ $product->id }}/edit"
                                                class="btn btn-warning btn-sm">
                                                Update Stock
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm border-0 mt-5">
                <div class="card-body">
                    <h4 class="fw-bold mb-4">Recent Orders</h4>

                    @if($recentOrders->count() == 0)
                        <div class="alert alert-info">
                            No recent orders found.
                        </div>
                    @else
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Order ID</th>
                                    <th>User</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($recentOrders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->user->name ?? 'Unknown User' }}</td>
                                        <td>${{ number_format($order->total_price, 2) }}</td>

                                        <td>
                                            @if($order->status == 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif($order->status == 'completed')
                                                <span class="badge bg-success">Completed</span>
                                            @elseif($order->status == 'cancelled')
                                                <span class="badge bg-danger">Cancelled</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $order->status }}</span>
                                            @endif
                                        </td>

                                        <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm border-0 mt-5">
                <div class="card-body">
                    <h4 class="fw-bold mb-4">Top Selling Products</h4>

                    @if($topSellingProducts->count() == 0)
                        <div class="alert alert-info">
                            No sales data found yet.
                        </div>
                    @else
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Product</th>
                                    <th>Total Sold</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($topSellingProducts as $item)
                                    <tr>
                                        <td>
                                            {{ $item->product->name ?? 'Deleted Product' }}
                                        </td>

                                        <td>
                                            <span class="badge bg-success">
                                                {{ $item->total_sold }} sold
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>