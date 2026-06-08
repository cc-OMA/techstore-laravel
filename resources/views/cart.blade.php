<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .cart-img {
            width: 140px;
            height: 110px;
            object-fit: cover;
            border-radius: 16px;
        }

        .cart-header {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            border-radius: 24px;
            color: white;
            overflow: hidden;
            position: relative;
        }

        .cart-header::after {
            content: "";
            position: absolute;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.12);
            right: -60px;
            top: -70px;
        }

        .cart-header-content {
            position: relative;
            z-index: 2;
        }

        .cart-item-card {
            border: 0;
            border-radius: 20px;
            transition: 0.25s;
        }

        .cart-item-card:hover {
            transform: translateY(-3px);
        }

        .total-card {
            border: 0;
            border-radius: 24px;
            background: linear-gradient(135deg, #198754, #20c997);
            color: white;
        }

        .price-text {
            font-size: 1.4rem;
            font-weight: 800;
            color: #0d6efd;
        }

        .empty-cart-card {
            border: 0;
            border-radius: 24px;
        }
    </style>
</head>
<body>

<div class="container py-5">

    <div class="cart-header shadow-sm p-5 mb-4">
        <div class="cart-header-content d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <p class="fw-bold opacity-75 mb-2">
                    YOUR CART
                </p>

                <h1 class="fw-bold mb-2">
                    Shopping Cart 🛒
                </h1>

                <p class="mb-0 opacity-75">
                    Review your selected products before placing your order.
                </p>
            </div>

            <div class="text-end">
                <h3 class="fw-bold mb-0">
                    {{ $cartItems->count() }}
                </h3>

                <small>
                    Items in cart
                </small>
            </div>
        </div>
    </div>

    <a href="/" class="btn btn-outline-primary mb-4">
        ← Continue Shopping
    </a>

    @if($cartItems->count() == 0)

        <div class="card shadow-sm empty-cart-card">
            <div class="card-body text-center p-5">
                <h3 class="fw-bold mb-3">
                    Your cart is empty
                </h3>

                <p class="text-muted mb-4">
                    Looks like you haven't added any products yet.
                </p>

                <a href="/" class="btn btn-primary btn-lg">
                    Start Shopping
                </a>
            </div>
        </div>

    @else

        @foreach($cartItems as $item)
            <div class="card shadow-sm cart-item-card mb-3">
                <div class="card-body d-flex align-items-center gap-4 flex-wrap">
                    <img
                        src="{{ str_starts_with($item->product->image, 'products/') ? asset('storage/' . $item->product->image) : (str_starts_with($item->product->image, 'http') ? $item->product->image : 'https://dummyimage.com/400x300/cccccc/000000&text=Product+Image') }}"
                        class="cart-img"
                        alt="{{ $item->product->name }}">

                    <div class="flex-grow-1">
                        <h5 class="fw-bold mb-2">
                            {{ $item->product->name }}
                        </h5>

                        <p class="price-text mb-2">
                            ${{ number_format($item->product->price, 2) }}
                        </p>

                        <span class="badge bg-primary">
                            Quantity: {{ $item->quantity }}
                        </span>

                        <span class="badge bg-success ms-2">
                            Subtotal: ${{ number_format($item->product->price * $item->quantity, 2) }}
                        </span>
                    </div>

                    <div>
                        <form method="POST" action="/cart/{{ $item->id }}">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-outline-danger">
                                Remove
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="card shadow-sm total-card mt-4">
            <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h2 class="fw-bold mb-1">
                        Total: ${{ number_format($totalPrice, 2) }}
                    </h2>

                    <p class="mb-0 opacity-75">
                        Ready to place your order
                    </p>
                </div>

                <form method="POST" action="/order/place">
                    @csrf

                    <button type="submit" class="btn btn-light btn-lg fw-bold">
                        Place Order
                    </button>
                </form>
            </div>
        </div>

    @endif

</div>

</body>
</html>