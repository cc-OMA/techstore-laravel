<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Orders
        </h2>
    </x-slot>

    <div class="py-5 bg-light">
        <div class="container">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <h3 class="fw-bold mb-4">All Orders</h3>

            <a href="/dashboard" class="btn btn-secondary mb-4">
                Back to Dashboard
            </a>

            @if($orders->count() == 0)
                <div class="alert alert-info">
                    No orders found.
                </div>
            @else
                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-dark">
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
                                        <td>#{{ $order->id }}</td>

                                        <td>
                                            {{ $order->user->name ?? 'Unknown User' }}
                                        </td>

                                        <td>
                                            {{ $order->user->email ?? 'No Email' }}
                                        </td>

                                        <td>
                                            ${{ number_format($order->total_price, 2) }}
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
                                                class="btn btn-info btn-sm">
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