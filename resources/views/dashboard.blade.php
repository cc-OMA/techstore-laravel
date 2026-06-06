<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-5 bg-light">
        <div class="container">

            <h3 class="fw-bold mb-4">TechStore Overview</h3>

            <div class="row g-4">

                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h5 class="card-title text-primary fw-bold">
                                Total Products
                            </h5>

                            <h2 class="fw-bold">
                                {{ $productCount }}
                            </h2>

                            <p class="text-muted mb-0">
                                Products available in store
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h5 class="card-title text-success fw-bold">
                                Total Categories
                            </h5>

                            <h2 class="fw-bold">
                                {{ $categoryCount }}
                            </h2>

                            <p class="text-muted mb-0">
                                Product categories
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h5 class="card-title text-warning fw-bold">
                                Cart Items
                            </h5>

                            <h2 class="fw-bold">
                                {{ $cartItemCount }}
                            </h2>

                            <p class="text-muted mb-0">
                                Total items added to carts
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h5 class="card-title text-danger fw-bold">
                                Total Orders
                            </h5>

                            <h2 class="fw-bold">
                                {{ $orderCount }}
                            </h2>

                            <p class="text-muted mb-0">
                                Orders placed by users
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-5">
                <a href="/" class="btn btn-primary">
                    Back to Store
                </a>

                <a href="/products/create" class="btn btn-success ms-2">
                    Add Product
                </a>
            </div>

        </div>
    </div>
</x-app-layout>