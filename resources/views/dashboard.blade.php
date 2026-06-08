<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <style>
        .dashboard-title {
            letter-spacing: -0.5px;
        }

        .welcome-card {
            border: 0;
            border-radius: 26px;
            color: #ffffff;
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            overflow: hidden;
            position: relative;
        }

        .welcome-card::before {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.12);
            right: -70px;
            top: -80px;
        }

        .welcome-card::after {
            content: "";
            position: absolute;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.10);
            left: 45%;
            bottom: -70px;
        }

        .welcome-content {
            position: relative;
            z-index: 2;
        }

        .welcome-mini-card {
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.20);
            border-radius: 18px;
            padding: 16px;
            backdrop-filter: blur(8px);
        }

        .stat-card {
            border: 0;
            border-radius: 22px;
            overflow: hidden;
            color: #ffffff;
            position: relative;
        }

        .stat-card::after {
            content: "";
            position: absolute;
            width: 130px;
            height: 130px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.16);
            right: -35px;
            top: -35px;
        }

        .stat-card .card-body {
            position: relative;
            z-index: 2;
        }

        .stat-card h5 {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .stat-card h2 {
            font-size: 2.2rem;
        }

        .stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.18);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.45rem;
            margin-bottom: 12px;
            backdrop-filter: blur(6px);
        }

        .gradient-blue {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
        }

        .gradient-green {
            background: linear-gradient(135deg, #198754, #20c997);
        }

        .gradient-orange {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
        }

        .gradient-red {
            background: linear-gradient(135deg, #dc3545, #b02a37);
        }

        .gradient-dark {
            background: linear-gradient(135deg, #212529, #495057);
        }

        .dashboard-action-bar {
            background: #ffffff;
            border-radius: 20px;
            padding: 18px;
        }

        .dashboard-section-card {
            border: 0;
            border-radius: 22px;
            overflow: hidden;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .section-heading {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-icon {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: #eef2ff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .premium-table {
            margin-bottom: 0;
        }

        .premium-table thead th {
            background: #111827;
            color: #ffffff;
            border: 0;
            padding: 14px;
        }

        .premium-table tbody td {
            padding: 14px;
            vertical-align: middle;
        }

        .premium-table tbody tr {
            transition: all 0.2s ease;
        }

        .premium-table tbody tr:hover {
            background: #f8fafc;
        }
    </style>

    <div class="py-5">
        <div class="container">

            @if(session('success'))
                <div class="alert alert-success shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card welcome-card shadow-sm mb-5">
                <div class="card-body p-4 p-md-5 welcome-content">
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <p class="fw-bold mb-2 opacity-75">
                                WELCOME BACK
                            </p>

                            <h2 class="fw-bold mb-3">
                                Welcome Back, {{ auth()->user()->name }} 👋
                            </h2>

                            <p class="lead mb-0 opacity-75">
                                Manage products, orders, inventory and sales performance from one powerful dashboard.
                            </p>
                        </div>

                        <div class="col-md-5 mt-4 mt-md-0">
                            <div class="row g-3">
                                <div class="col-4">
                                    <div class="welcome-mini-card text-center">
                                        <h4 class="fw-bold mb-1">{{ $productCount }}</h4>
                                        <small class="opacity-75">Products</small>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="welcome-mini-card text-center">
                                        <h4 class="fw-bold mb-1">{{ $orderCount }}</h4>
                                        <small class="opacity-75">Orders</small>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="welcome-mini-card text-center">
                                        <h4 class="fw-bold mb-1">${{ number_format($totalRevenue, 2) }}</h4>
                                        <small class="opacity-75">Revenue</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <p class="text-primary fw-bold mb-1">ADMIN PANEL</p>
                    <h3 class="fw-bold dashboard-title mb-0">TechStore Overview</h3>
                </div>

                <span class="badge bg-primary fs-6">
                    Live Dashboard
                </span>
            </div>

            <div class="row g-4">

                <div class="col-md-3">
                    <div class="card shadow-sm stat-card gradient-blue h-100">
                        <div class="card-body text-center">
                            <div class="stat-icon">📦</div>
                            <h5 class="fw-bold">Total Products</h5>
                            <h2 class="fw-bold">{{ $productCount }}</h2>
                            <p class="mb-0 opacity-75">Products available in store</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm stat-card gradient-green h-100">
                        <div class="card-body text-center">
                            <div class="stat-icon">🗂️</div>
                            <h5 class="fw-bold">Total Categories</h5>
                            <h2 class="fw-bold">{{ $categoryCount }}</h2>
                            <p class="mb-0 opacity-75">Product categories</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm stat-card gradient-orange h-100">
                        <div class="card-body text-center">
                            <div class="stat-icon">🛒</div>
                            <h5 class="fw-bold">Cart Items</h5>
                            <h2 class="fw-bold">{{ $cartItemCount }}</h2>
                            <p class="mb-0 opacity-75">Total items added to carts</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm stat-card gradient-red h-100">
                        <div class="card-body text-center">
                            <div class="stat-icon">📋</div>
                            <h5 class="fw-bold">Total Orders</h5>
                            <h2 class="fw-bold">{{ $orderCount }}</h2>
                            <p class="mb-0 opacity-75">Orders placed by users</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row g-4 mt-1">

                <div class="col-md-3">
                    <div class="card shadow-sm stat-card gradient-green h-100">
                        <div class="card-body text-center">
                            <div class="stat-icon">💰</div>
                            <h5 class="fw-bold">Total Revenue</h5>
                            <h2 class="fw-bold">${{ number_format($totalRevenue, 2) }}</h2>
                            <p class="mb-0 opacity-75">Revenue from completed orders</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm stat-card gradient-orange h-100">
                        <div class="card-body text-center">
                            <div class="stat-icon">⏳</div>
                            <h5 class="fw-bold">Pending Orders</h5>
                            <h2 class="fw-bold">{{ $pendingOrders }}</h2>
                            <p class="mb-0 opacity-75">Waiting for processing</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm stat-card gradient-blue h-100">
                        <div class="card-body text-center">
                            <div class="stat-icon">✅</div>
                            <h5 class="fw-bold">Completed Orders</h5>
                            <h2 class="fw-bold">{{ $completedOrders }}</h2>
                            <p class="mb-0 opacity-75">Successfully completed</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm stat-card gradient-red h-100">
                        <div class="card-body text-center">
                            <div class="stat-icon">❌</div>
                            <h5 class="fw-bold">Cancelled Orders</h5>
                            <h2 class="fw-bold">{{ $cancelledOrders }}</h2>
                            <p class="mb-0 opacity-75">Cancelled by admin</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row g-4 mt-1">

                <div class="col-md-6">
                    <div class="card shadow-sm stat-card gradient-orange h-100">
                        <div class="card-body text-center">
                            <div class="stat-icon">⚠️</div>
                            <h5 class="fw-bold">Low Stock Products</h5>
                            <h2 class="fw-bold">{{ $lowStockProducts }}</h2>
                            <p class="mb-0 opacity-75">Products with 1 to 5 items left</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm stat-card gradient-dark h-100">
                        <div class="card-body text-center">
                            <div class="stat-icon">🚫</div>
                            <h5 class="fw-bold">Out of Stock Products</h5>
                            <h2 class="fw-bold">{{ $outOfStockProducts }}</h2>
                            <p class="mb-0 opacity-75">Products unavailable for purchase</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="dashboard-action-bar shadow-sm mt-5 d-flex flex-wrap gap-2">
                <a href="/" class="btn btn-primary">Back to Store</a>
                <a href="/products/create" class="btn btn-success">Add Product</a>
                <a href="/admin/products" class="btn btn-warning">Manage Products</a>
                <a href="/admin/orders" class="btn btn-dark">Manage Orders</a>
            </div>

            <div class="card shadow-sm dashboard-section-card mt-5">
                <div class="card-body">
                    <div class="section-header">
                        <div class="section-heading">
                            <span class="section-icon">⚠️</span>
                            <div>
                                <h4 class="fw-bold mb-0">Low Stock Alert</h4>
                                <small class="text-muted">Products that need inventory attention</small>
                            </div>
                        </div>
                    </div>

                    @if($lowStockList->count() == 0)
                        <div class="alert alert-success">
                            All products have enough stock.
                        </div>
                    @else
                        <table class="table premium-table align-middle">
                            <thead>
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
                                        <td class="fw-semibold">{{ $product->name }}</td>
                                        <td>{{ $product->category->name ?? 'No Category' }}</td>
                                        <td>
                                            <span class="badge bg-warning text-dark">
                                                {{ $product->stock }} left
                                            </span>
                                        </td>
                                        <td>
                                            <a href="/products/{{ $product->id }}/edit" class="btn btn-warning btn-sm">
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

            <div class="card shadow-sm dashboard-section-card mt-5">
                <div class="card-body">
                    <div class="section-header">
                        <div class="section-heading">
                            <span class="section-icon">📋</span>
                            <div>
                                <h4 class="fw-bold mb-0">Recent Orders</h4>
                                <small class="text-muted">Latest customer order activity</small>
                            </div>
                        </div>
                    </div>

                    @if($recentOrders->count() == 0)
                        <div class="alert alert-info">
                            No recent orders found.
                        </div>
                    @else
                        <table class="table premium-table align-middle">
                            <thead>
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
                                        <td class="fw-semibold">#{{ $order->id }}</td>
                                        <td>{{ $order->user->name ?? 'Unknown User' }}</td>
                                        <td class="fw-semibold">${{ number_format($order->total_price, 2) }}</td>
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

            <div class="card shadow-sm dashboard-section-card mt-5">
                <div class="card-body">
                    <div class="section-header">
                        <div class="section-heading">
                            <span class="section-icon">🔥</span>
                            <div>
                                <h4 class="fw-bold mb-0">Top Selling Products</h4>
                                <small class="text-muted">Best performing products by quantity sold</small>
                            </div>
                        </div>
                    </div>

                    @if($topSellingProducts->count() == 0)
                        <div class="alert alert-info">
                            No sales data found yet.
                        </div>
                    @else
                        <table class="table premium-table align-middle">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Total Sold</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($topSellingProducts as $item)
                                    <tr>
                                        <td class="fw-semibold">{{ $item->product->name ?? 'Deleted Product' }}</td>
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