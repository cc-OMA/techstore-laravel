<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .product-detail-wrapper {
            min-height: 100vh;
        }

        .detail-card {
            border: 0;
            border-radius: 28px;
            overflow: hidden;
        }

        .detail-image {
            height: 560px;
            object-fit: cover;
            width: 100%;
        }

        .detail-info {
            padding: 3rem;
        }

        .category-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: #eef2ff;
            color: #0d6efd;
            border-radius: 999px;
            padding: 0.5rem 0.9rem;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .price-display {
            font-size: 2.3rem;
            font-weight: 900;
            color: #0d6efd;
            letter-spacing: -1px;
        }

        .description-box {
            background: #f8fafc;
            border-radius: 20px;
            padding: 1.25rem;
            color: #475569;
            line-height: 1.7;
        }

        .stock-box {
            border-radius: 18px;
            padding: 1rem;
            background: #ffffff;
            border: 1px solid #e5e7eb;
        }

        .detail-action-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        @media (max-width: 767px) {
            .detail-image {
                height: 360px;
            }

            .detail-info {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>

<div class="product-detail-wrapper py-5">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="/" class="btn btn-outline-secondary">
                ← Back to Products
            </a>

            <span class="badge bg-primary fs-6">
                Product Details
            </span>
        </div>

        <div class="card shadow-sm detail-card">
            <div class="row g-0">

                <div class="col-md-6">
                    <img
                        src="{{ str_starts_with($product->image, 'products/') ? asset('storage/' . $product->image) : (str_starts_with($product->image, 'http') ? $product->image : 'https://dummyimage.com/600x400/cccccc/000000&text=Product+Image') }}"
                        class="detail-image"
                        alt="{{ $product->name }}">
                </div>

                <div class="col-md-6">
                    <div class="detail-info">

                        <span class="category-pill mb-3">
                            🏷️ {{ $product->category->name ?? 'No Category' }}
                        </span>

                        <h1 class="fw-bold mb-3">
                            {{ $product->name }}
                        </h1>

                        <div class="price-display mb-4">
                            ${{ number_format($product->price, 2) }}
                        </div>

                        <div class="stock-box mb-4">
                            @if($product->stock > 0)
                                <span class="badge bg-success fs-6">
                                    In Stock
                                </span>

                                <span class="ms-2 text-muted">
                                    {{ $product->stock }} units available
                                </span>
                            @else
                                <span class="badge bg-danger fs-6">
                                    Out of Stock
                                </span>

                                <span class="ms-2 text-muted">
                                    This product is currently unavailable
                                </span>
                            @endif
                        </div>

                        <h5 class="fw-bold mb-3">
                            Product Description
                        </h5>

                        <div class="description-box mb-4">
                            {{ $product->description }}
                        </div>

                        <div class="detail-action-bar">
                            @if($product->stock > 0)
                                <form method="POST" action="/cart/add/{{ $product->id }}">
                                    @csrf

                                    <button type="submit" class="btn btn-primary btn-lg px-4">
                                        Add to Cart
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-secondary btn-lg px-4" disabled>
                                    Out of Stock
                                </button>
                            @endif

                            @auth
                                @if(auth()->user()->isAdmin())
                                    <a href="/products/{{ $product->id }}/edit" class="btn btn-warning btn-lg px-4">
                                        Edit Product
                                    </a>

                                    <form method="POST" action="/products/{{ $product->id }}">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-outline-danger btn-lg px-4">
                                            Delete Product
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

</body>
</html>