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

        .filter-card {
            border: 0;
            border-radius: 20px;
            background: #ffffff;
        }

        .contact-card {
            border: 0;
            border-radius: 24px;
            overflow: hidden;
        }

        .contact-info-box {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            color: #ffffff;
            border-radius: 24px;
            height: 100%;
        }

        .contact-icon-box {
            width: 46px;
            height: 46px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.16);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
        }

        .premium-footer {
            background: #0f172a;
            color: #ffffff;
            position: relative;
        }

        .premium-footer::before {
            content: "";
            display: block;
            height: 4px;
            background: linear-gradient(135deg, #0d6efd, #6610f2);
        }

        .footer-brand-badge {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
        }

        .footer-link {
            color: #cbd5e1;
            text-decoration: none;
        }

        .footer-link:hover {
            color: #ffffff;
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
            <a class="nav-link px-2" href="#contact">Contact</a>

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
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h2 class="fw-bold mb-0 section-title">
                @if(isset($selectedCategory))
                    {{ $selectedCategory->name }} Products
                @elseif(!empty($search))
                    Search Results
                @else
                    Featured Products
                @endif
            </h2>

            <span class="badge bg-primary fs-6">
                {{ method_exists($products, 'total') ? $products->total() : $products->count() }} Products
            </span>
        </div>

        <div class="card shadow-sm filter-card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ isset($selectedCategory) ? '/category/' . $selectedCategory->id : '/' }}" class="row g-3 align-items-end">
                    @if(!empty($search))
                        <input type="hidden" name="search" value="{{ $search }}">
                    @endif

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Sort Products</label>

                        <select name="sort" class="form-select">
                            <option value="newest" {{ ($sort ?? 'newest') == 'newest' ? 'selected' : '' }}>
                                Newest
                            </option>

                            <option value="price_low_high" {{ ($sort ?? '') == 'price_low_high' ? 'selected' : '' }}>
                                Price: Low to High
                            </option>

                            <option value="price_high_low" {{ ($sort ?? '') == 'price_high_low' ? 'selected' : '' }}>
                                Price: High to Low
                            </option>
                        </select>
                    </div>

                    <div class="col-md-8 d-flex gap-2 flex-wrap">
                        <button type="submit" class="btn btn-primary">
                            Apply Sort
                        </button>

                        <a href="{{ isset($selectedCategory) ? '/category/' . $selectedCategory->id : '/' }}" class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        @if(!empty($search))
            <div class="alert alert-info">
                Search results for: <strong>{{ $search }}</strong>
            </div>
        @endif

        @if(isset($selectedCategory))
            <div class="alert alert-primary">
                Showing products in category: <strong>{{ $selectedCategory->name }}</strong>
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

        @if(method_exists($products, 'links'))
            <div class="mt-5 d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        @endif

    </div>
</section>

<section class="py-5 bg-light" id="contact">
    <div class="container">
        <div class="text-center mb-5">
            <p class="text-primary fw-bold mb-2">CONTACT US</p>

            <h2 class="fw-bold section-title">
                Get in Touch
            </h2>

            <p class="text-muted mb-0">
                Have a question about products, orders or support? Reach out to TechStore.
            </p>
        </div>

        <div class="row g-4 align-items-stretch">
            <div class="col-md-5">
                <div class="contact-info-box shadow-sm p-4 p-md-5">
                    <h3 class="fw-bold mb-4">
                        Contact Information
                    </h3>

                    <div class="d-flex gap-3 mb-4">
                        <span class="contact-icon-box">📍</span>

                        <div>
                            <h6 class="fw-bold mb-1">Location</h6>
                            <p class="mb-0 opacity-75">Istanbul, Türkiye</p>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mb-4">
                        <span class="contact-icon-box">📧</span>

                        <div>
                            <h6 class="fw-bold mb-1">Email</h6>
                            <p class="mb-0 opacity-75">support@techstore.com</p>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mb-4">
                        <span class="contact-icon-box">🛒</span>

                        <div>
                            <h6 class="fw-bold mb-1">Support</h6>
                            <p class="mb-0 opacity-75">Secure online shopping support</p>
                        </div>
                    </div>

                    <p class="mb-0 opacity-75">
                        Our team is ready to help with product questions, order tracking and store support.
                    </p>
                </div>
            </div>

            <div class="col-md-7">
                <div class="card shadow-sm contact-card h-100">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="fw-bold mb-3">
                            Send a Message
                        </h3>

                        <p class="text-muted mb-4">
                            This contact form is currently for design/demo purposes.
                        </p>

                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Name</label>
                                    <input type="text" class="form-control" placeholder="Your name">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Email</label>
                                    <input type="email" class="form-control" placeholder="your@email.com">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Subject</label>
                                    <input type="text" class="form-control" placeholder="Message subject">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Message</label>
                                    <textarea class="form-control" rows="5" placeholder="Write your message..."></textarea>
                                </div>
                            </div>

                            <button type="button" class="btn btn-primary btn-lg mt-4">
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="premium-footer mt-5">
    <div class="container py-5">
        <div class="row g-4">

            <div class="col-md-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="footer-brand-badge">TS</span>

                    <div>
                        <h5 class="fw-bold mb-0">TechStore</h5>
                        <small class="text-secondary">Premium Electronics</small>
                    </div>
                </div>

                <p class="text-secondary mb-0">
                    Your trusted electronics store for smartphones, laptops,
                    gaming devices and premium accessories.
                </p>
            </div>

            <div class="col-md-4">
                <h6 class="fw-bold mb-3">Quick Links</h6>

                <div class="d-flex flex-column gap-2">
                    <a href="/" class="footer-link">Home</a>
                    <a href="#products" class="footer-link">Products</a>
                    <a href="#categories" class="footer-link">Categories</a>
                    <a href="/cart" class="footer-link">Cart</a>
                    <a href="#contact" class="footer-link">Contact</a>
                </div>
            </div>

            <div class="col-md-4">
                <h6 class="fw-bold mb-3">Contact Info</h6>

                <p class="text-secondary mb-2">📍 Istanbul, Türkiye</p>
                <p class="text-secondary mb-2">📧 support@techstore.com</p>
                <p class="text-secondary mb-0">🛒 Secure online shopping</p>
            </div>

        </div>

        <hr class="border-secondary my-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <p class="text-secondary mb-0">
                © 2026 TechStore. All rights reserved.
            </p>

            <p class="text-secondary mb-0">
                Built with Laravel
            </p>
        </div>
    </div>
</footer>

</body>
</html>