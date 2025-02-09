<?php
session_start();
include 'db_connection.php'; // Include your database connection

// Ensure that the staff is logged in
if (!isset($_SESSION['staff_id'])) {
    header('Location: login.php');
    exit;
}

// Initialize product variable
$product = null;

// Check if product ID is passed via GET method and is numeric
if (isset($_GET['product_id']) && is_numeric($_GET['product_id'])) {
    $product_id = (int) $_GET['product_id']; // Cast to integer

    // Fetch the product details from the database
    $query = "SELECT * FROM products WHERE product_id = :product_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // If product doesn't exist, redirect to stock overview
    if (!$product) {
        header('Location: stock_overview.php');
        exit;
    }
} else {
    // Redirect if product_id is not set or invalid
    header('Location: stock_overview.php');
    exit;
}

// Handle the form submission for updating product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $product) {
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];

    // Handle image upload (optional)
    if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == 0) {
        $image_data = file_get_contents($_FILES['image_url']['tmp_name']);
    } else {
        $image_data = $product['image_url']; // Keep existing image if no new image is uploaded
    }

    // Update the product in the database
    $update_query = "UPDATE products SET 
                        product_name = :product_name, 
                        category = :category, 
                        description = :description, 
                        price = :price, 
                        stock_quantity = :stock_quantity, 
                        image_url = :image_url 
                    WHERE product_id = :product_id";
    
    $stmt = $conn->prepare($update_query);
    $stmt->bindParam(':product_name', $product_name);
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':stock_quantity', $stock_quantity);
    $stmt->bindParam(':image_url', $image_data, PDO::PARAM_LOB); // Bind image as binary data
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header('Location: stock_overview.php'); // Redirect to stock overview page on success
        exit;
    } else {
        $error_message = "Failed to update product.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <style>
        /* Your CSS styles here */
    </style>
</head>
<body>

<div class="update-container">
    <h2>Update Product Details</h2>

    <?php if (isset($error_message)): ?>
        <p class="error-message"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <?php if ($product): ?>
        <form action="update_product.php?product_id=<?php echo $product['product_id']; ?>" method="POST" enctype="multipart/form-data">
            <label for="product_name">Product Name</label>
            <input type="text" name="product_name" id="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>

            <label for="category">Category</label>
            <input type="text" name="category" id="category" value="<?php echo htmlspecialchars($product['category']); ?>" required>

            <label for="description">Description</label>
            <textarea name="description" id="description" rows="4" required><?php echo htmlspecialchars($product['description']); ?></textarea>

            <label for="price">Price ($)</label>
            <input type="number" name="price" id="price" step="0.01" value="<?php echo htmlspecialchars($product['price']); ?>" required>

            <label for="stock_quantity">Stock Quantity</label>
            <input type="number" name="stock_quantity" id="stock_quantity" value="<?php echo htmlspecialchars($product['stock_quantity']); ?>" required>

            <label for="image_url">Product Image (optional)</label>
            <input type="file" name="image_url" id="image_url">

            <button type="submit">Update Product</button>
        </form>
    <?php else: ?>
        <p class="error-message">Product not found.</p>
    <?php endif; ?>
</div>

</body>
</html>

<?php $conn = null; // Close the database connection ?>
