<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
</head>
<body>

    <h1>Add Product</h1>

    <form method="POST" action="/products" enctype="multipart/form-data">
        @csrf

        <label>Product Name</label>
        <br>
        <input type="text" name="name">
        <br><br>

        <label>Price</label>
        <br>
        <input type="text" name="price">
        <br><br>

        <label>Image</label>
        <br>
        <input type="file" name="image">
        <br><br>

        <label>Description</label>
        <br>
        <textarea name="description"></textarea>
        <br><br>

        <button type="submit">
            Add Product
        </button>
    </form>

</body>
</html>