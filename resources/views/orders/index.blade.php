<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Order History
        </h2>
    </x-slot>

    <div class="py-5 bg-light">
        <div class="container">

            <h3 class="fw-bold mb-4">My Orders</h3>

            <a href="/dashboard" class="btn btn-secondary mb-4">
                Back to Dashboard
            </a>

            @if($orders->count() == 0)
                <div class="alert alert-info">
                    You have no orders yet.
                </div>
            @else
                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        <table class="table table-bordered table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Total Price</th>
                                    <th>Order Date</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>${{ number_format($order->total_price, 2) }}</td>
                                        <td>{{ $order->created_at->format('d M Y H:i') }}</td>
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