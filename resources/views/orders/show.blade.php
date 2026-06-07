<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Order Details
        </h2>
    </x-slot>

    <div class="py-5 bg-light">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold mb-0">
                    Order #{{ $order->id }}
                </h3>

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

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">

                    <p>
                        <strong>User:</strong>
                        {{ $order->user->name ?? 'Unknown User' }}
                    </p>

                    <p>
                        <strong>Email:</strong>
                        {{ $order->user->email ?? 'No Email' }}
                    </p>

                    <p>
                        <strong>Total Price:</strong>
                        ${{ number_format($order->total_price, 2) }}
                    </p>

                    <p>
                        <strong>Status:</strong>

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

                    <p class="mb-0">
                        <strong>Order Date:</strong>
                        {{ $order->created_at->format('d M Y H:i') }}
                    </p>

                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <h4 class="fw-bold mb-4">
                        Ordered Products
                    </h4>

                    @if($order->items->count() == 0)

                        <div class="alert alert-info">
                            No products found for this order.
                        </div>

                    @else

                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
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
                                            {{ $item->product->name ?? 'Deleted Product' }}
                                        </td>

                                        <td>
                                            {{ $item->quantity }}
                                        </td>

                                        <td>
                                            ${{ number_format($item->price, 2) }}
                                        </td>

                                        <td>
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