<?php
include 'db_connection.php'; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];

    // Handle image upload
    if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == 0) {
        $image = $_FILES['image_url']['tmp_name'];
        $image_data = file_get_contents($image); // Convert image to binary data
    } else {
        $image_data = NULL; // If no image is uploaded
    }

    // Prepare SQL query to insert the product into the database
    $query = "INSERT INTO products (product_name, category, description, price, stock_quantity, image_url) 
              VALUES (:product_name, :category, :description, :price, :stock_quantity, :image_url)";
    $stmt = $conn->prepare($query);

    // Bind parameters using bindParam()
    $stmt->bindParam(':product_name', $product_name);
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':stock_quantity', $stock_quantity, PDO::PARAM_INT);
    $stmt->bindParam(':image_url', $image_data, PDO::PARAM_LOB); // Binds binary data for the image

    // Execute query
    if ($stmt->execute()) {
        echo "Product added successfully!";
    } else {
        echo "Error adding product: " . $stmt->errorInfo()[2];
    }

    // Close the connection (optional with PDO, but good practice)
    $stmt = null;
    $conn = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }

        .form-container {
            width: 50%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .form-container label {
            font-size: 16px;
            color: #333;
            display: block;
            margin: 10px 0 5px;
        }

        .form-container input, .form-container textarea, .form-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #5cb85c;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #4cae4c;
        }

        .form-container input[type="file"] {
            padding: 5px;
        }
    </style>
</head>
<body>

<h1>Add New Product</h1>

<div class="form-container">
    <form method="POST" enctype="multipart/form-data">
        <label for="product_name">Product Name:</label>
        <input type="text" name="product_name" id="product_name" required>

        <label for="category">Category:</label>
        <select name="category" id="category" required>
            <option value="">Select a Category</option>
            <option value="Electronics">Electronics</option>
            <option value="Fashion">Fashion</option>
            <option value="Groceries">Groceries</option>
            <option value="Home Appliances">Home Appliances</option>
            <option value="Beauty">Beauty</option>
            <option value="Sports">Sports</option>
            <option value="Funiture">faniture</option>
            <option value="Cars">Cars</option>
        </select>

        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea>

        <label for="price">Price:</label>
        <input type="number" name="price" id="price" step="0.01" required>

        <label for="stock_quantity">Stock Quantity:</label>
        <input type="number" name="stock_quantity" id="stock_quantity" required>

        <label for="image_url">Product Image:</label>
        <input type="file" name="image_url" id="image_url" accept="image/*">

        <button type="submit">Add Product</button>
    </form>
</div>

</body>
</html>
