<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
</head>
<body>

    <h1>Edit Product</h1>

    <form method="POST" action="/products/{{ $product->id }}">
        @csrf
        @method('PUT')

        <label>Product Name</label>
        <br>
        <input type="text" name="name" value="{{ $product->name }}">
        <br><br>

        <label>Price</label>
        <br>
        <input type="text" name="price" value="{{ $product->price }}">
        <br><br>

        <label>Description</label>
        <br>
        <textarea name="description">{{ $product->description }}</textarea>
        <br><br>

        <button type="submit">
            Update Product
        </button>

    </form>

</body>
</html>
