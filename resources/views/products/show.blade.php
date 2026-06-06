<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">

<div class="container py-5">

    <a href="/" class="btn btn-secondary mb-4">
        ← Back to Products
    </a>

    <div class="card shadow border-0">
        <div class="row g-0">

            <div class="col-md-6">
                <img
                    src="{{ str_starts_with($product->image, 'products/') ? asset('storage/' . $product->image) : (str_starts_with($product->image, 'http') ? $product->image : 'https://dummyimage.com/600x400/cccccc/000000&text=Product+Image') }}"
                    class="img-fluid rounded-start w-100"
                    style="height: 500px; object-fit: cover;"
                    alt="{{ $product->name }}">
            </div>

            <div class="col-md-6">
                <div class="card-body p-4">

                    <h1 class="fw-bold mb-3">
                        {{ $product->name }}
                    </h1>

                    <h3 class="text-primary mb-4">
                        ${{ $product->price }}
                    </h3>

                    <p class="mb-4">
                        {{ $product->description }}
                    </p>

                    <p class="mb-4">
                        <strong>Category:</strong>
                        {{ $product->category->name ?? 'No Category' }}
                    </p>

                    <form method="POST" action="/cart/add/{{ $product->id }}">
                        @csrf

                        <button type="submit" class="btn btn-primary btn-lg">
                            Add to Cart
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

</body>
</html>