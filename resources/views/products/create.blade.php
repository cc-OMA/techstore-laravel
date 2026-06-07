<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card shadow-lg border-0">

                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Add New Product</h3>
                </div>

                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
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

                        <div class="mb-3">
                            <label class="form-label">Category</label>

                            <select name="category_id" class="form-select">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">
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
                                placeholder="Enter product name">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Price</label>

                            <input
                                type="text"
                                name="price"
                                class="form-control"
                                placeholder="Enter price">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Stock</label>

                            <input
                                type="number"
                                name="stock"
                                class="form-control"
                                placeholder="Enter stock quantity"
                                min="0">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Product Image</label>

                            <input
                                type="file"
                                name="image"
                                class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>

                            <textarea
                                name="description"
                                rows="4"
                                class="form-control"
                                placeholder="Product description"></textarea>
                        </div>

                        <div class="d-flex justify-content-between">

                            <a href="/admin/products" class="btn btn-secondary">
                                Back
                            </a>

                            <button type="submit" class="btn btn-primary">
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