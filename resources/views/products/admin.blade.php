<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manage Products
        </h2>
    </x-slot>

    <style>
        .products-hero {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            border-radius: 24px;
            color: white;
            overflow: hidden;
            position: relative;
            border: 0;
        }

        .products-hero::before {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.12);
            right: -80px;
            top: -80px;
        }

        .products-hero-content {
            position: relative;
            z-index: 2;
        }

        .products-mini-card {
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.20);
            border-radius: 18px;
            padding: 16px;
            backdrop-filter: blur(8px);
        }

        .products-table-card {
            border: 0;
            border-radius: 22px;
            overflow: hidden;
        }

        .products-table {
            margin-bottom: 0;
        }

        .products-table thead th {
            background: #111827;
            color: white;
            border: 0;
            padding: 14px;
        }

        .products-table tbody td {
            padding: 14px;
            vertical-align: middle;
        }

        .products-table tbody tr {
            transition: all 0.2s ease;
        }

        .products-table tbody tr:hover {
            background: #f8fafc;
        }

        .product-admin-img {
            width: 82px;
            height: 82px;
            object-fit: cover;
            border-radius: 16px;
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.12);
        }

        .product-id {
            font-weight: 800;
            color: #0d6efd;
        }

        .price-highlight {
            font-weight: 800;
            color: #198754;
        }

        .section-title {
            letter-spacing: -0.5px;
        }

        .empty-products-card {
            border: 0;
            border-radius: 24px;
        }

        .admin-search-card {
            background: #ffffff;
            border: 0;
            border-radius: 20px;
            padding: 18px;
        }
    </style>

    <div class="py-5">
        <div class="container">

            @if(session('success'))
                <div class="alert alert-success shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card products-hero shadow-sm mb-5">
                <div class="card-body p-4 p-md-5 products-hero-content">
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <p class="fw-bold mb-2 opacity-75">
                                PRODUCT MANAGEMENT
                            </p>

                            <h2 class="fw-bold mb-3">
                                Manage Store Products 🛍️
                            </h2>

                            <p class="lead mb-0 opacity-75">
                                Add, edit, organize and monitor your products, categories, prices and stock levels.
                            </p>
                        </div>

                        <div class="col-md-5 mt-4 mt-md-0">
                            <div class="row g-3">
                                <div class="col-4">
                                    <div class="products-mini-card text-center">
                                        <h4 class="fw-bold mb-1">{{ $products->count() }}</h4>
                                        <small class="opacity-75">Products</small>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="products-mini-card text-center">
                                        <h4 class="fw-bold mb-1">
                                            {{ $products->where('stock', '<=', 5)->where('stock', '>', 0)->count() }}
                                        </h4>
                                        <small class="opacity-75">Low Stock</small>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="products-mini-card text-center">
                                        <h4 class="fw-bold mb-1">
                                            {{ $products->where('stock', 0)->count() }}
                                        </h4>
                                        <small class="opacity-75">Out</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <div>
                    <p class="text-primary fw-bold mb-1">ADMIN PANEL</p>
                    <h3 class="fw-bold section-title mb-0">
                        Product Management
                    </h3>
                </div>

                <a href="/products/create" class="btn btn-success">
                    Add New Product
                </a>
            </div>

            <div class="admin-search-card shadow-sm mb-4">
                <form method="GET" action="/admin/products" class="d-flex gap-2 flex-wrap">
                    <input
                        type="text"
                        name="search"
                        class="form-control flex-grow-1"
                        placeholder="Search products..."
                        value="{{ $search ?? '' }}">

                    <button type="submit" class="btn btn-primary">
                        Search
                    </button>

                    <a href="/admin/products" class="btn btn-outline-secondary">
                        Reset
                    </a>

                    <a href="/dashboard" class="btn btn-secondary">
                        Back to Dashboard
                    </a>
                </form>
            </div>

            @if(!empty($search))
                <div class="alert alert-info shadow-sm">
                    Search results for: <strong>{{ $search }}</strong>
                </div>
            @endif

            @if($products->count() == 0)

                <div class="card shadow-sm empty-products-card">
                    <div class="card-body text-center p-5">
                        <h3 class="fw-bold mb-3">
                            No products found
                        </h3>

                        <p class="text-muted mb-4">
                            Try a different search term or add a new product.
                        </p>

                        <a href="/products/create" class="btn btn-primary btn-lg">
                            Add Product
                        </a>
                    </div>
                </div>

            @else

                <div class="card shadow-sm products-table-card">
                    <div class="card-body p-0">

                        <table class="table products-table align-middle">

                            <thead>
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
                                            <span class="product-id">
                                                #{{ $product->id }}
                                            </span>
                                        </td>

                                        <td>
                                            <img
                                                src="{{ str_starts_with($product->image, 'products/') ? asset('storage/' . $product->image) : (str_starts_with($product->image, 'http') ? $product->image : 'https://dummyimage.com/120x120/cccccc/000000&text=No+Image') }}"
                                                class="product-admin-img"
                                                alt="{{ $product->name }}">
                                        </td>

                                        <td class="fw-semibold">
                                            {{ $product->name }}
                                        </td>

                                        <td>
                                            <span class="badge bg-primary">
                                                {{ $product->category->name ?? 'No Category' }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="price-highlight">
                                                ${{ number_format($product->price, 2) }}
                                            </span>
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
                                            <div class="d-flex gap-2 flex-wrap">
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
                                                        class="btn btn-outline-danger btn-sm">
                                                        Delete
                                                    </button>

                                                </form>
                                            </div>
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