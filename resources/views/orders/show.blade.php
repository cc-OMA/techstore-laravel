<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Order Details
        </h2>
    </x-slot>

    <style>
        .order-detail-hero {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            border-radius: 24px;
            color: white;
            overflow: hidden;
            position: relative;
            border: 0;
        }

        .order-detail-hero::before {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.12);
            right: -80px;
            top: -80px;
        }

        .order-detail-content {
            position: relative;
            z-index: 2;
        }

        .order-mini-card {
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.20);
            border-radius: 18px;
            padding: 16px;
            backdrop-filter: blur(8px);
        }

        .detail-card {
            border: 0;
            border-radius: 22px;
            overflow: hidden;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
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

        .info-row {
            background: #f8fafc;
            border-radius: 16px;
            padding: 14px 16px;
            margin-bottom: 12px;
        }

        .info-label {
            font-weight: 800;
            color: #334155;
            margin-bottom: 4px;
        }

        .info-value {
            color: #475569;
            margin-bottom: 0;
        }

        .price-highlight {
            font-weight: 900;
            color: #198754;
        }

        .order-table {
            margin-bottom: 0;
        }

        .order-table thead th {
            background: #111827;
            color: white;
            border: 0;
            padding: 14px;
        }

        .order-table tbody td {
            padding: 14px;
            vertical-align: middle;
        }

        .order-table tbody tr {
            transition: all 0.2s ease;
        }

        .order-table tbody tr:hover {
            background: #f8fafc;
        }

        .order-product-img {
            width: 78px;
            height: 78px;
            object-fit: cover;
            border-radius: 16px;
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.12);
        }

        .order-id {
            color: #0d6efd;
            font-weight: 900;
        }
    </style>

    <div class="py-5">
        <div class="container">

            <div class="card order-detail-hero shadow-sm mb-5">
                <div class="card-body p-4 p-md-5 order-detail-content">
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <p class="fw-bold mb-2 opacity-75">
                                ORDER DETAILS
                            </p>

                            <h2 class="fw-bold mb-3">
                                Order <span class="opacity-75">#{{ $order->id }}</span> 📦
                            </h2>

                            <p class="lead mb-0 opacity-75">
                                Review customer information, ordered products, payment total and order status.
                            </p>
                        </div>

                        <div class="col-md-5 mt-4 mt-md-0">
                            <div class="row g-3">
                                <div class="col-4">
                                    <div class="order-mini-card text-center">
                                        <h4 class="fw-bold mb-1">
                                            {{ $order->items->count() }}
                                        </h4>
                                        <small class="opacity-75">Items</small>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="order-mini-card text-center">
                                        <h4 class="fw-bold mb-1">
                                            ${{ number_format($order->total_price, 0) }}
                                        </h4>
                                        <small class="opacity-75">Total</small>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="order-mini-card text-center">
                                        @if($order->status == 'pending')
                                            <h4 class="fw-bold mb-1">⏳</h4>
                                            <small class="opacity-75">Pending</small>
                                        @elseif($order->status == 'completed')
                                            <h4 class="fw-bold mb-1">✅</h4>
                                            <small class="opacity-75">Completed</small>
                                        @elseif($order->status == 'cancelled')
                                            <h4 class="fw-bold mb-1">❌</h4>
                                            <small class="opacity-75">Cancelled</small>
                                        @else
                                            <h4 class="fw-bold mb-1">📋</h4>
                                            <small class="opacity-75">{{ $order->status }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <p class="text-primary fw-bold mb-1">ORDER MANAGEMENT</p>
                    <h3 class="fw-bold mb-0">
                        <span class="order-id">#{{ $order->id }}</span> Details
                    </h3>
                </div>

                @if(auth()->user()->isAdmin())
                    <a href="/admin/orders" class="btn btn-secondary">
                        Back to Admin Orders
                    </a>
                @else
                    <a href="/orders" class="btn btn-secondary">
                        Back to My Orders
                    </a>
                @endif
            </div>

            <div class="card shadow-sm detail-card mb-5">
                <div class="card-body p-4">
                    <div class="section-header">
                        <span class="section-icon">👤</span>

                        <div>
                            <h4 class="fw-bold mb-0">
                                Customer & Order Summary
                            </h4>

                            <small class="text-muted">
                                Basic information about this order
                            </small>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-row">
                                <div class="info-label">User</div>
                                <p class="info-value">
                                    {{ $order->user->name ?? 'Unknown User' }}
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-row">
                                <div class="info-label">Email</div>
                                <p class="info-value">
                                    {{ $order->user->email ?? 'No Email' }}
                                </p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="info-row">
                                <div class="info-label">Total Price</div>
                                <p class="info-value price-highlight">
                                    ${{ number_format($order->total_price, 2) }}
                                </p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="info-row">
                                <div class="info-label">Status</div>
                                <p class="info-value">
                                    @if($order->status == 'pending')
                                        <span class="badge bg-warning text-dark">
                                            Pending
                                        </span>
                                    @elseif($order->status == 'completed')
                                        <span class="badge bg-success">
                                            Completed
                                        </span>
                                    @elseif($order->status == 'cancelled')
                                        <span class="badge bg-danger">
                                            Cancelled
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            {{ $order->status }}
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="info-row">
                                <div class="info-label">Order Date</div>
                                <p class="info-value">
                                    {{ $order->created_at->format('d M Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm detail-card">
                <div class="card-body p-0">

                    <div class="p-4">
                        <div class="section-header mb-0">
                            <span class="section-icon">🛍️</span>

                            <div>
                                <h4 class="fw-bold mb-0">
                                    Ordered Products
                                </h4>

                                <small class="text-muted">
                                    Products included in this order
                                </small>
                            </div>
                        </div>
                    </div>

                    @if($order->items->count() == 0)

                        <div class="px-4 pb-4">
                            <div class="alert alert-warning mb-0">
                                Product details are not available for this order because it was created before order item tracking was added.
                            </div>
                        </div>

                    @else

                        <table class="table order-table align-middle">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            @if($item->product && $item->product->image)
                                                <img
                                                    src="{{ str_starts_with($item->product->image, 'http') ? $item->product->image : asset('storage/' . $item->product->image) }}"
                                                    alt="{{ $item->product->name }}"
                                                    class="order-product-img">
                                            @else
                                                <span class="text-muted">
                                                    No Image
                                                </span>
                                            @endif
                                        </td>

                                        <td class="fw-semibold">
                                            {{ $item->product->name ?? 'Deleted Product' }}
                                        </td>

                                        <td>
                                            <span class="badge bg-primary">
                                                {{ $item->quantity }}
                                            </span>
                                        </td>

                                        <td class="price-highlight">
                                            ${{ number_format($item->price, 2) }}
                                        </td>

                                        <td class="price-highlight">
                                            ${{ number_format($item->price * $item->quantity, 2) }}
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