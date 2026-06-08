<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechStore</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .premium-navbar {
            border-bottom: 1px solid rgba(13, 110, 253, 0.08);
            backdrop-filter: blur(12px);
        }

        .brand-badge {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-weight: 900;
            letter-spacing: -1px;
            box-shadow: 0 10px 24px rgba(13, 110, 253, 0.25);
        }

        .brand-text {
            line-height: 1.05;
        }

        .brand-subtitle {
            font-size: 0.72rem;
            color: #6c757d;
            letter-spacing: 0.5px;
        }

        .navbar .nav-link {
            font-weight: 600;
            color: #334155;
            position: relative;
        }

        .navbar .nav-link:hover {
            color: #0d6efd;
        }

        .navbar .nav-link::after {
            content: "";
            position: absolute;
            left: 0.5rem;
            right: 0.5rem;
            bottom: 3px;
            height: 2px;
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            transform: scaleX(0);
            transition: transform 0.2s ease;
            border-radius: 999px;
        }

        .navbar .nav-link:hover::after,
        .navbar .nav-link.active::after {
            transform: scaleX(1);
        }

        .nav-search {
            min-width: 260px;
        }

        .user-pill {
            background: #f1f5f9;
            color: #334155;
            border-radius: 999px;
            padding: 0.45rem 0.8rem;
            font-size: 0.85rem;
            font-weight: 700;
        }

        .hero-box {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            border-radius: 28px;
        }

        .category-card {
            border: 0;
            border-radius: 20px;
        }

        .product-img {
            height: 230px;
            object-fit: cover;
            border-top-left-radius: 18px;
            border-top-right-radius: 18px;
        }

        .product-card {
            border: 0;
            border-radius: 18px;
            overflow: hidden;
        }

        .product-title {
            min-height: 48px;
            font-weight: 700;
        }

        .product-description {
            min-height: 78px;
            color: #6c757d;
        }

        .price-tag {
            font-size: 1.35rem;
            font-weight: 800;
            color: #0d6efd;
        }

        .section-title {
            letter-spacing: -0.5px;
        }

        @media (max-width: 991px) {
            .nav-search {
                min-width: 100%;
            }

            .navbar-actions {
                width: 100%;
                justify-content: flex-start !important;
                margin-top: 1rem;
            }
        }
    </style>
</head>
<body>

<nav class="navbar bg-white shadow-sm sticky-top premium-navbar">
    <div class="container d-flex align-items-center flex-wrap gap-3">
        <a class="navbar-brand d-flex align-items-center gap-2 me-3" href="/">
            <span class="brand-badge">TS</span>

            <span class="brand-text">
                <span class="d-block fw-bold text-primary fs-4">
                    TechStore
                </span>

                <span class="d-block brand-subtitle">
                    Premium Electronics
                </span>
            </span>
        </a>

        <form method="GET" action="/" class="d-flex nav-search">
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Search products..."
                value="{{ $search ?? '' }}">

            <button type="submit" class="btn btn-outline-primary ms-2">
                Search
            </button>
        </form>

        <div class="d-flex align-items-center gap-2 flex-wrap ms-auto navbar-actions">
            <a class="nav-link active px-2" href="/">Home</a>
            <a class="nav-link px-2" href="#products">Products</a>
            <a class="nav-link px-2" href="#categories">Categories</a>
            <a class="nav-link px-2" href="#">Contact</a>

            @auth
                <span class="user-pill">
                    Hi, {{ auth()->user()->name }}
                </span>

                @if(auth()->user()->isAdmin())
                    <a class="btn btn-success" href="/products/create">
                        Add Product
                    </a>
                @endif
            @endauth

            <a class="btn btn-outline-primary" href="/cart">
                Cart ({{ $cartCount }})
            </a>

            @auth
                <a class="btn btn-outline-dark" href="/dashboard">
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

<section class="py-5">
    <div class="container">
        <div class="row align-items-center min-vh-50">
            <div class="col-md-6">
                <p class="text-primary fw-bold mb-2">NEW ARRIVALS</p>

                <h1 class="display-4 fw-bold">
                    Latest Electronics & Smart Devices
                </h1>

                <p class="lead text-muted">
                    Discover laptops, smartphones, headphones, gaming accessories and smart gadgets.
                </p>

                <a href="#products" class="btn btn-primary btn-lg px-4">
                    Shop Now
                </a>
            </div>

            <div class="col-md-6 text-center mt-4 mt-md-0">
                <div class="hero-box text-white p-5 shadow">
                    <h2 class="display-5 fw-bold">SALE</h2>
                    <p class="fs-4 mb-0">Up to 50% Off</p>
                    <p class="mt-3 mb-0 opacity-75">
                        Premium tech deals are waiting for you.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5" id="categories">
    <div class="container">
        <h2 class="text-center fw-bold mb-4 section-title">Categories</h2>

        <div class="row g-4">
            <div class="col-md-3">
                <a href="/category/1" class="text-decoration-none text-dark">
                    <div class="card text-center shadow-sm h-100 category-card">
                        <div class="card-body py-4">
                            <h5 class="card-title fw-bold">Laptops</h5>
                            <p class="card-text text-muted mb-0">Premium laptops and notebooks</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="/category/2" class="text-decoration-none text-dark">
                    <div class="card text-center shadow-sm h-100 category-card">
                        <div class="card-body py-4">
                            <h5 class="card-title fw-bold">Smartphones</h5>
                            <p class="card-text text-muted mb-0">Latest mobile devices</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="/category/3" class="text-decoration-none text-dark">
                    <div class="card text-center shadow-sm h-100 category-card">
                        <div class="card-body py-4">
                            <h5 class="card-title fw-bold">Gaming</h5>
                            <p class="card-text text-muted mb-0">Consoles and gaming gear</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="/category/4" class="text-decoration-none text-dark">
                    <div class="card text-center shadow-sm h-100 category-card">
                        <div class="card-body py-4">
                            <h5 class="card-title fw-bold">Accessories</h5>
                            <p class="card-text text-muted mb-0">Headphones, keyboards and more</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="py-5" id="products">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0 section-title">Featured Products</h2>

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

                        <div class="card-body d-flex flex-column p-4">
                            <h5 class="card-title product-title">
                                <a
                                    href="/products/{{ $product->id }}"
                                    class="text-decoration-none text-dark">
                                    {{ $product->name }}
                                </a>
                            </h5>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="price-tag">
                                    ${{ $product->price }}
                                </span>

                                @if($product->stock > 0)
                                    <span class="badge bg-success">
                                        {{ $product->stock }} in stock
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        Out of Stock
                                    </span>
                                @endif
                            </div>

                            <p class="card-text small product-description flex-grow-1">
                                {{ Str::limit($product->description, 115) }}
                            </p>

                            <a href="/products/{{ $product->id }}" class="btn btn-outline-primary w-100 mb-2">
                                View Details
                            </a>

                            @auth
                                @if(auth()->user()->isAdmin())
                                    <a href="/products/{{ $product->id }}/edit" class="btn btn-warning w-100 mb-2">
                                        Edit Product
                                    </a>
                                @endif
                            @endauth

                            @if($product->stock > 0)
                                <form method="POST" action="/cart/add/{{ $product->id }}" class="mb-2">
                                    @csrf

                                    <button type="submit" class="btn btn-primary w-100">
                                        Add to Cart
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-secondary w-100 mb-2" disabled>
                                    Out of Stock
                                </button>
                            @endif

                            @auth
                                @if(auth()->user()->isAdmin())
                                    <form method="POST" action="/products/{{ $product->id }}">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-outline-danger w-100">
                                            Delete Product
                                        </button>
                                    </form>
                                @endif
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