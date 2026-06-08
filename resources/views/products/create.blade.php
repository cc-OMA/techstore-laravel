<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .form-hero {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            border-radius: 24px;
            color: white;
            overflow: hidden;
            position: relative;
        }

        .form-hero::after {
            content: "";
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.12);
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
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
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
                Add New Product 🛍️
            </h1>

            <p class="lead mb-0 opacity-75">
                Create a new store item with category, price, stock, image and product description.
            </p>
        </div>
    </div>

    <div class="row justify-content-center">

        <div class="col-lg-9">

            <div class="card shadow-sm product-form-card">

                <div class="card-body p-4 p-md-5">

                    <div class="mb-4">
                        <p class="text-primary fw-bold mb-1">
                            NEW PRODUCT
                        </p>

                        <h3 class="fw-bold form-section-title mb-0">
                            Product Information
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
                          action="/products"
                          enctype="multipart/form-data">

                        @csrf

                        <div class="row g-4">

                            <div class="col-md-6">
                                <label class="form-label">Category</label>

                                <select name="category_id" class="form-select">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Product Name</label>

                                <input
                                    type="text"
                                    name="name"
                                    class="form-control"
                                    placeholder="Enter product name">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Price</label>

                                <input
                                    type="text"
                                    name="price"
                                    class="form-control"
                                    placeholder="Enter price">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Stock</label>

                                <input
                                    type="number"
                                    name="stock"
                                    class="form-control"
                                    placeholder="Enter stock quantity"
                                    min="0">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Product Image</label>

                                <input
                                    type="file"
                                    name="image"
                                    class="form-control">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Description</label>

                                <textarea
                                    name="description"
                                    rows="5"
                                    class="form-control"
                                    placeholder="Write a clear product description"></textarea>
                            </div>

                        </div>

                        <div class="helper-card mt-4">
                            <strong>Tip:</strong>
                            Use high-quality product images and a clear description to make your product page look more professional.
                        </div>

                        <div class="d-flex justify-content-between flex-wrap gap-2 mt-4">

                            <a href="/admin/products" class="btn btn-outline-secondary btn-lg">
                                Back
                            </a>

                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                Add Product
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