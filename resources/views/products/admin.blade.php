<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manage Products
        </h2>
    </x-slot>

    <div class="py-5 bg-light">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h3 class="fw-bold mb-0">
                    Product Management
                </h3>

                <div class="d-flex">

                    <form method="GET" action="/admin/products" class="d-flex me-3">

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search products..."
                            value="{{ $search ?? '' }}">

                        <button
                            type="submit"
                            class="btn btn-primary ms-2">
                            Search
                        </button>

                    </form>

                    <a href="/products/create" class="btn btn-success">
                        Add New Product
                    </a>

                </div>

            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(!empty($search))
                <div class="alert alert-info">
                    Search results for: <strong>{{ $search }}</strong>
                </div>
            @endif

            @if($products->count() == 0)

                <div class="alert alert-info">
                    No products found.
                </div>

            @else

                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        <table class="table table-bordered table-hover align-middle">

                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($products as $product)

                                    <tr>

                                        <td>
                                            {{ $product->id }}
                                        </td>

                                        <td>
                                            <img
                                                src="{{ str_starts_with($product->image, 'products/') ? asset('storage/' . $product->image) : (str_starts_with($product->image, 'http') ? $product->image : 'https://dummyimage.com/120x120/cccccc/000000&text=No+Image') }}"
                                                style="
                                                    width: 80px;
                                                    height: 80px;
                                                    object-fit: cover;
                                                    border-radius: 8px;
                                                "
                                                alt="{{ $product->name }}">
                                        </td>

                                        <td>
                                            {{ $product->name }}
                                        </td>

                                        <td>
                                            {{ $product->category->name ?? 'No Category' }}
                                        </td>

                                        <td>
                                            ${{ number_format($product->price, 2) }}
                                        </td>

                                        <td>
                                            @if($product->stock == 0)
                                                <span class="badge bg-danger">
                                                    Out of Stock
                                                </span>
                                            @elseif($product->stock <= 5)
                                                <span class="badge bg-warning text-dark">
                                                    Low Stock: {{ $product->stock }}
                                                </span>
                                            @else
                                                <span class="badge bg-success">
                                                    In Stock: {{ $product->stock }}
                                                </span>
                                            @endif
                                        </td>

                                        <td>

                                            <a
                                                href="/products/{{ $product->id }}/edit"
                                                class="btn btn-warning btn-sm">
                                                Edit
                                            </a>

                                            <form
                                                method="POST"
                                                action="/products/{{ $product->id }}"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this product?');">

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-danger btn-sm">
                                                    Delete
                                                </button>

                                            </form>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>
                </div>

            @endif

            <div class="mt-4">

                <a href="/dashboard" class="btn btn-secondary">
                    Back to Dashboard
                </a>

            </div>

        </div>
    </div>
</x-app-layout>