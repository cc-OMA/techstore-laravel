<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechStore</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .product-img {
            height: 220px;
            object-fit: cover;
        }

        .product-card {
            transition: 0.3s;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary fs-3" href="/">TechStore</a>

        <div class="d-flex align-items-center ms-auto">
            <form method="GET" action="/" class="d-flex me-3">
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Search products..."
                    value="{{ $search ?? '' }}"
                    style="width: 250px;">

                <button type="submit" class="btn btn-outline-primary ms-2">
                    Search
                </button>
            </form>

            <a class="nav-link active me-3" href="/">Home</a>
            <a class="nav-link me-3" href="#products">Products</a>
            <a class="nav-link me-3" href="#categories">Categories</a>
            <a class="nav-link me-3" href="#">Contact</a>

            @auth
                <a class="btn btn-success ms-3 me-2" href="/products/create">
                    Add Product
                </a>
            @endauth

            <a class="btn btn-outline-primary me-2" href="/cart">
                Cart ({{ $cartCount }})
            </a>

            @auth
                <a class="btn btn-outline-dark me-2" href="/dashboard">
                    Dashboard
                </a>

                <form method="POST" action="/logout" class="d-inline">
                    @csrf

                    <button type="submit" class="btn btn-danger">
                        Logout
                    </button>
                </form>
            @else
                <a class="btn btn-primary" href="/login">
                    Login
                </a>
            @endauth
        </div>
    </div>
</nav>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center min-vh-50">
            <div class="col-md-6">
                <p class="text-primary fw-bold">NEW ARRIVALS</p>

                <h1 class="display-4 fw-bold">
                    Latest Electronics & Smart Devices
                </h1>

                <p class="lead">
                    Discover laptops, smartphones, headphones, gaming accessories and smart gadgets.
                </p>

                <a href="#products" class="btn btn-primary btn-lg">
                    Shop Now
                </a>
            </div>

            <div class="col-md-6 text-center">
                <div class="bg-primary text-white rounded p-5 shadow">
                    <h2 class="display-5 fw-bold">SALE</h2>
                    <p class="fs-4 mb-0">Up to 50% Off</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5" id="categories">
    <div class="container">
        <h2 class="text-center fw-bold mb-4">Categories</h2>

        <div class="row g-4">
            <div class="col-md-3">
                <a href="/category/1" class="text-decoration-none text-dark">
                    <div class="card text-center shadow-sm h-100 product-card">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Laptops</h5>
                            <p class="card-text">Premium laptops and notebooks</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="/category/2" class="text-decoration-none text-dark">
                    <div class="card text-center shadow-sm h-100 product-card">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Smartphones</h5>
                            <p class="card-text">Latest mobile devices</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="/category/3" class="text-decoration-none text-dark">
                    <div class="card text-center shadow-sm h-100 product-card">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Gaming</h5>
                            <p class="card-text">Consoles and gaming gear</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="/category/4" class="text-decoration-none text-dark">
                    <div class="card text-center shadow-sm h-100 product-card">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Accessories</h5>
                            <p class="card-text">Headphones, keyboards and more</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light" id="products">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Featured Products</h2>

            <span class="badge bg-primary fs-6">
                {{ $products->count() }} Products
            </span>
        </div>

        @if(!empty($search))
            <div class="alert alert-info">
                Search results for: <strong>{{ $search }}</strong>
            </div>
        @endif

        <div class="row g-4">
            @foreach($products as $product)
                <div class="col-md-3">
                    <div class="card shadow-sm h-100 product-card">
                        <a href="/products/{{ $product->id }}">
                            <img
                                src="{{ str_starts_with($product->image, 'products/') ? asset('storage/' . $product->image) : (str_starts_with($product->image, 'http') ? $product->image : 'https://dummyimage.com/400x300/cccccc/000000&text=Product+Image') }}"
                                class="card-img-top product-img"
                                alt="{{ $product->name }}">
                        </a>

                        <div class="card-body text-center d-flex flex-column">
                            <h5 class="card-title">
                                <a
                                    href="/products/{{ $product->id }}"
                                    class="text-decoration-none text-dark">
                                    {{ $product->name }}
                                </a>
                            </h5>

                            <p class="text-primary fw-bold fs-5">
                                ${{ $product->price }}
                            </p>

                            <p class="card-text small flex-grow-1">
                                {{ $product->description }}
                            </p>

                            <a href="/products/{{ $product->id }}" class="btn btn-outline-primary mb-2">
                                View Details
                            </a>

                            @auth
                                <a href="/products/{{ $product->id }}/edit" class="btn btn-warning mb-2">
                                    Edit
                                </a>
                            @endauth

                            <form method="POST" action="/cart/add/{{ $product->id }}" class="mb-2">
                                @csrf

                                <button type="submit" class="btn btn-primary w-100">
                                    Add to Cart
                                </button>
                            </form>

                            @auth
                                <form method="POST" action="/products/{{ $product->id }}">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger w-100">
                                        Delete
                                    </button>
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>

<footer class="bg-dark text-white text-center py-4">
    <div class="container">
        <h5 class="fw-bold">TechStore</h5>
        <p class="mb-1">
            Your trusted electronics store for smart devices and accessories.
        </p>
        <p class="mb-0">© 2026 TechStore. All rights reserved.</p>
    </div>
</footer>

</body>
</html>