<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Orders
        </h2>
    </x-slot>

    <style>
        .orders-hero {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            border-radius: 24px;
            color: white;
            overflow: hidden;
            position: relative;
            border: 0;
        }

        .orders-hero::before {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.12);
            right: -80px;
            top: -80px;
        }

        .orders-hero-content {
            position: relative;
            z-index: 2;
        }

        .orders-mini-card {
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.20);
            border-radius: 18px;
            padding: 16px;
            backdrop-filter: blur(8px);
        }

        .orders-table-card {
            border: 0;
            border-radius: 22px;
            overflow: hidden;
        }

        .orders-table {
            margin-bottom: 0;
        }

        .orders-table thead th {
            background: #111827;
            color: white;
            border: 0;
            padding: 14px;
        }

        .orders-table tbody td {
            padding: 14px;
            vertical-align: middle;
        }

        .orders-table tbody tr {
            transition: all 0.2s ease;
        }

        .orders-table tbody tr:hover {
            background: #f8fafc;
        }

        .order-id {
            font-weight: 800;
            color: #0d6efd;
        }

        .price-highlight {
            font-weight: 800;
            color: #198754;
        }

        .admin-section-title {
            letter-spacing: -0.5px;
        }
    </style>

    <div class="py-5">
        <div class="container">

            @if(session('success'))
                <div class="alert alert-success shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card orders-hero shadow-sm mb-5">
                <div class="card-body p-4 p-md-5 orders-hero-content">
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <p class="fw-bold mb-2 opacity-75">
                                ORDER MANAGEMENT
                            </p>

                            <h2 class="fw-bold mb-3">
                                Manage Customer Orders 📦
                            </h2>

                            <p class="lead mb-0 opacity-75">
                                Review order details, track order status, and manage customer purchases from one place.
                            </p>
                        </div>

                        <div class="col-md-5 mt-4 mt-md-0">
                            <div class="row g-3">
                                <div class="col-4">
                                    <div class="orders-mini-card text-center">
                                        <h4 class="fw-bold mb-1">{{ $orders->count() }}</h4>
                                        <small class="opacity-75">Orders</small>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="orders-mini-card text-center">
                                        <h4 class="fw-bold mb-1">
                                            {{ $orders->where('status', 'pending')->count() }}
                                        </h4>
                                        <small class="opacity-75">Pending</small>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="orders-mini-card text-center">
                                        <h4 class="fw-bold mb-1">
                                            {{ $orders->where('status', 'completed')->count() }}
                                        </h4>
                                        <small class="opacity-75">Completed</small>
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
                    <h3 class="fw-bold admin-section-title mb-0">All Orders</h3>
                </div>

                <a href="/dashboard" class="btn btn-secondary">
                    Back to Dashboard
                </a>
            </div>

            @if($orders->count() == 0)
                <div class="alert alert-info shadow-sm">
                    No orders found.
                </div>
            @else
                <div class="card shadow-sm orders-table-card">
                    <div class="card-body p-0">

                        <table class="table orders-table align-middle">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                    <th>Order Date</th>
                                    <th>Details</th>
                                    <th>Update Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>
                                            <span class="order-id">
                                                #{{ $order->id }}
                                            </span>
                                        </td>

                                        <td class="fw-semibold">
                                            {{ $order->user->name ?? 'Unknown User' }}
                                        </td>

                                        <td>
                                            {{ $order->user->email ?? 'No Email' }}
                                        </td>

                                        <td>
                                            <span class="price-highlight">
                                                ${{ number_format($order->total_price, 2) }}
                                            </span>
                                        </td>

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

                                        <td>
                                            {{ $order->created_at->format('d M Y H:i') }}
                                        </td>

                                        <td>
                                            <a
                                                href="/orders/{{ $order->id }}"
                                                class="btn btn-outline-info btn-sm">
                                                View Details
                                            </a>
                                        </td>

                                        <td>
                                            <form method="POST" action="/admin/orders/{{ $order->id }}">
                                                @csrf
                                                @method('PUT')

                                                <div class="d-flex gap-2">
                                                    <select name="status" class="form-select form-select-sm">
                                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                                            Pending
                                                        </option>

                                                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>
                                                            Completed
                                                        </option>

                                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                                            Cancelled
                                                        </option>
                                                    </select>

                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                        Update
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>

                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>