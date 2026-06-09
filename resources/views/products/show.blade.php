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

        .review-card {
            border: 0;
            border-radius: 24px;
        }

        .review-item {
            background: #f8fafc;
            border-radius: 18px;
            padding: 1rem;
        }

        .rating-stars {
            color: #ffc107;
            font-size: 1.2rem;
        }

        .review-form-card {
            border: 0;
            border-radius: 24px;
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

        @if(session('success'))
            <div class="alert alert-success shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger shadow-sm">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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

                        <div class="mb-3">
                            <span class="rating-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($averageRating && $i <= round($averageRating))
                                        ★
                                    @else
                                        ☆
                                    @endif
                                @endfor
                            </span>

                            <span class="text-muted ms-2">
                                @if($reviewCount > 0)
                                    {{ number_format($averageRating, 1) }} / 5 based on {{ $reviewCount }} reviews
                                @else
                                    No reviews yet
                                @endif
                            </span>
                        </div>

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

        <div class="row g-4 mt-4">

            <div class="col-md-5">
                <div class="card shadow-sm review-form-card h-100">
                    <div class="card-body p-4">
                        <h3 class="fw-bold mb-3">
                            Write a Review ⭐
                        </h3>

                        @auth
                            <form method="POST" action="/products/{{ $product->id }}/reviews">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Rating
                                    </label>

                                    <select name="rating" class="form-select" required>
                                        <option value="">Select rating</option>
                                        <option value="5">5 Stars - Excellent</option>
                                        <option value="4">4 Stars - Very Good</option>
                                        <option value="3">3 Stars - Good</option>
                                        <option value="2">2 Stars - Fair</option>
                                        <option value="1">1 Star - Poor</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Comment
                                    </label>

                                    <textarea
                                        name="comment"
                                        class="form-control"
                                        rows="5"
                                        placeholder="Share your thoughts about this product..."
                                        required></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg">
                                    Submit Review
                                </button>
                            </form>
                        @else
                            <div class="alert alert-info mb-0">
                                Please <a href="/login">login</a> to write a review.
                            </div>
                        @endauth
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="card shadow-sm review-card h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="fw-bold mb-0">
                                Customer Reviews
                            </h3>

                            <span class="badge bg-primary fs-6">
                                {{ $reviewCount }} Reviews
                            </span>
                        </div>

                        @if($product->reviews->count() == 0)
                            <div class="alert alert-info mb-0">
                                No reviews yet. Be the first to review this product.
                            </div>
                        @else
                            <div class="d-flex flex-column gap-3">
                                @foreach($product->reviews->sortByDesc('created_at') as $review)
                                    <div class="review-item">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="fw-bold mb-1">
                                                    {{ $review->user->name ?? 'Unknown User' }}
                                                </h6>

                                                <small class="text-muted">
                                                    {{ $review->created_at->format('d M Y H:i') }}
                                                </small>
                                            </div>

                                            <span class="rating-stars">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        ★
                                                    @else
                                                        ☆
                                                    @endif
                                                @endfor
                                            </span>
                                        </div>

                                        <p class="mb-0 text-muted">
                                            {{ $review->comment }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

</body>
</html>