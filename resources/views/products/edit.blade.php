<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .form-hero {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
            border-radius: 24px;
            color: #ffffff;
            overflow: hidden;
            position: relative;
        }

        .form-hero::after {
            content: "";
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.16);
            right: -70px;
            top: -80px;
        }

        .form-hero-content {
            position: relative;
            z-index: 2;
        }

        .product-form-card {
            border: 0;
            border-radius: 24px;
            overflow: hidden;
        }

        .form-label {
            font-weight: 700;
            color: #334155;
        }

        .form-control,
        .form-select {
            border-radius: 14px;
            padding: 0.75rem 1rem;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 0.2rem rgba(253, 126, 20, 0.18);
        }

        .form-section-title {
            letter-spacing: -0.5px;
        }

        .helper-card {
            background: #f8fafc;
            border-radius: 20px;
            padding: 1.25rem;
            border: 1px solid #e5e7eb;
        }

        .current-image-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            padding: 1rem;
        }

        .current-product-img {
            width: 100%;
            max-height: 280px;
            object-fit: cover;
            border-radius: 18px;
        }

        .product-preview-title {
            color: #0f172a;
        }

        .price-preview {
            color: #198754;
            font-weight: 800;
            font-size: 1.35rem;
        }
    </style>
</head>
<body>

<div class="container py-5">

    <div class="form-hero shadow-sm p-4 p-md-5 mb-5">
        <div class="form-hero-content">
            <p class="fw-bold opacity-75 mb-2">
                PRODUCT MANAGEMENT
            </p>

            <h1 class="fw-bold mb-3">
                Edit Product ✏️
            </h1>

            <p class="lead mb-0 opacity-75">
                Update product information, pricing, stock, category, image and description.
            </p>
        </div>
    </div>

    <div class="row justify-content-center">

        <div class="col-lg-10">

            <div class="card shadow-sm product-form-card">

                <div class="card-body p-4 p-md-5">

                    <div class="mb-4">
                        <p class="text-warning fw-bold mb-1">
                            UPDATE PRODUCT
                        </p>

                        <h3 class="fw-bold form-section-title mb-0">
                            {{ $product->name }}
                        </h3>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger shadow-sm">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST"
                          action="/products/{{ $product->id }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">

                            <div class="col-md-5">
                                <label class="form-label">Current Image</label>

                                <div class="current-image-card">
                                    <img
                                        src="{{ str_starts_with($product->image, 'products/') ? asset('storage/' . $product->image) : (str_starts_with($product->image, 'http') ? $product->image : 'https://dummyimage.com/400x300/cccccc/000000&text=Product+Image') }}"
                                        class="current-product-img mb-3"
                                        alt="{{ $product->name }}">

                                    <h5 class="fw-bold product-preview-title mb-1">
                                        {{ $product->name }}
                                    </h5>

                                    <p class="price-preview mb-2">
                                        ${{ number_format($product->price, 2) }}
                                    </p>

                                    @if($product->stock > 0)
                                        <span class="badge bg-success">
                                            In Stock: {{ $product->stock }}
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            Out of Stock
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-7">

                                <div class="mb-3">
                                    <label class="form-label">Category</label>

                                    <select name="category_id" class="form-select">
                                        @foreach($categories as $category)
                                            <option
                                                value="{{ $category->id }}"
                                                {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Product Name</label>

                                    <input
                                        type="text"
                                        name="name"
                                        class="form-control"
                                        value="{{ old('name', $product->name) }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Price</label>

                                    <input
                                        type="text"
                                        name="price"
                                        class="form-control"
                                        value="{{ old('price', $product->price) }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Stock</label>

                                    <input
                                        type="number"
                                        name="stock"
                                        class="form-control"
                                        min="0"
                                        value="{{ old('stock', $product->stock) }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">New Image</label>

                                    <input
                                        type="file"
                                        name="image"
                                        class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Description</label>

                                    <textarea
                                        name="description"
                                        rows="5"
                                        class="form-control">{{ old('description', $product->description) }}</textarea>
                                </div>

                            </div>

                        </div>

                        <div class="helper-card mt-4">
                            <strong>Tip:</strong>
                            Updating stock and product images regularly keeps the store accurate and professional.
                        </div>

                        <div class="d-flex justify-content-between flex-wrap gap-2 mt-4">
                            <a href="/admin/products" class="btn btn-outline-secondary btn-lg">
                                Back
                            </a>

                            <button type="submit" class="btn btn-warning btn-lg px-4">
                                Update Product
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>