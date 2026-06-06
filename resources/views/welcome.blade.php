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
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary fs-3" href="#">TechStore</a>
<div class="d-flex align-items-center ms-auto">

    <input
        type="text"
        class="form-control me-3"
        placeholder="Search products..."
        style="width: 250px;"
    >

    <a class="nav-link active me-3" href="#">Home</a>
<a class="nav-link me-3" href="#">Products</a>
<a class="nav-link me-3" href="#">Categories</a>
<a class="nav-link me-3" href="#">Contact</a>

    <a class="btn btn-outline-primary ms-3 me-2" href="#">
        Cart (0)
    </a>

    <a class="btn btn-primary" href="/login">
    Login
</a>

</div>
    </div>
</nav>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center min-vh-50">
            <div class="col-md-6">
                <p class="text-primary fw-bold">NEW ARRIVALS</p>
                <h1 class="display-4 fw-bold">Latest Electronics & Smart Devices</h1>
                <p class="lead">
                    Discover laptops, smartphones, headphones, gaming accessories and smart gadgets.
                </p>
                <a href="#" class="btn btn-primary btn-lg">Shop Now</a>
            </div>

            <div class="col-md-6 text-center">
                <div class="bg-primary text-white rounded p-5">
                    <h2 class="display-5 fw-bold">SALE</h2>
                    <p class="fs-4">Up to 50% Off</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-4">Categories</h2>

        <div class="row g-4">
            <div class="col-md-3">
                <div class="card text-center shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Laptops</h5>
                        <p class="card-text">Premium laptops and notebooks</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Smartphones</h5>
                        <p class="card-text">Latest mobile devices</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Gaming</h5>
                        <p class="card-text">Consoles and gaming gear</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Accessories</h5>
                        <p class="card-text">Headphones, keyboards and more</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Featured Products</h2>
        <p>Product Count: {{ $products->count() }}</p>

        <div class="row g-4">

            @foreach($products as $product)
                <div class="col-md-3">
                    <div class="card shadow-sm h-100">
                        <img src="{{ str_starts_with($product->image, 'http') ? $product->image : 'https://dummyimage.com/400x300/cccccc/000000&text=Product+Image' }}"
                             class="card-img-top product-img"
                             alt="{{ $product->name }}">

                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $product->name }}</h5>

                            <p class="text-primary fw-bold">
                                ${{ $product->price }}
                            </p>

                            <p class="card-text">
                                {{ $product->description }}
                            </p>

                            <button class="btn btn-primary">Add to Cart</button>
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
        <p class="mb-1">Your trusted electronics store for smart devices and accessories.</p>
        <p class="mb-0">© 2026 TechStore. All rights reserved.</p>
    </div>
</footer>
</body>
</html>