<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .cart-img {
            width: 120px;
            height: 90px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <h1 class="mb-4">Shopping Cart</h1>

    <p>Cart Item Count: {{ $cartItems->count() }}</p>

    <a href="/" class="btn btn-primary mb-4">
        Back to Home
    </a>

    @if($cartItems->count() == 0)

        <div class="alert alert-info">
            Your cart is empty.
        </div>

    @else

        @foreach($cartItems as $item)
            <div class="card mb-3">
                <div class="card-body d-flex align-items-center gap-3">
                    <img src="{{ str_starts_with($item->product->image, 'products/') ? asset('storage/' . $item->product->image) : (str_starts_with($item->product->image, 'http') ? $item->product->image : 'https://dummyimage.com/400x300/cccccc/000000&text=Product+Image') }}"
                         class="cart-img rounded"
                         alt="{{ $item->product->name }}">

                    <div>
                        <h5>{{ $item->product->name }}</h5>

                        <p class="text-primary fw-bold">
                            ${{ $item->product->price }}
                        </p>

                        <p>
                            Quantity: {{ $item->quantity }}
                        </p>

                        <form method="POST" action="/cart/{{ $item->id }}">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">
                                Remove
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="card mt-4">
            <div class="card-body">
                <h3>
                    Total Price: ${{ number_format($totalPrice, 2) }}
                </h3>

                <form method="POST" action="/order/place" class="mt-3">
                    @csrf

                    <button type="submit" class="btn btn-success btn-lg">
                        Place Order
                    </button>
                </form>
            </div>
        </div>

    @endif

</div>

</body>
</html>