<?php
session_start();
include 'db_connection.php'; // Include your database connection

// Ensure that the staff is logged in (you can modify this check based on your authentication system)
if (!isset($_SESSION['staff_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch products grouped by category
$query = "SELECT * FROM products ORDER BY category ASC";
$stmt = $conn->prepare($query);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if there are any products
if (empty($products)) {
    $products = [];
}

// Group products by category
$products_by_category = [];
foreach ($products as $product) {
    $products_by_category[$product['category']][] = $product;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Overview</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            padding: 20px;
            text-align: center;
        }

        .stock-container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        .category-section {
            margin: 30px 0;
        }

        .category-header {
            font-size: 20px;
            font-weight: bold;
            background-color: #28a745;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-align: left;
        }

        .product-item {
            display: flex;
            justify-content: space-between;
            background: #f1f1f1;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
        }

        .product-info {
            flex: 1;
            padding: 0 10px;
        }

        .product-info h4 {
            margin: 5px 0;
        }

        .product-price,
        .product-quantity {
            font-size: 14px;
        }

        .product-image img {
            width: 100px;
            height: auto;
            border-radius: 5px;
        }

        .empty-message {
            margin-top: 20px;
            color: #d9534f;
        }
    </style>
</head>
<body>

<div class="stock-container">
    <h2>Stock Overview</h2>

    <?php if (!empty($products_by_category)): ?>
        <?php foreach ($products_by_category as $category => $category_products): ?>
            <div class="category-section">
                <div class="category-header">
                    <?php echo htmlspecialchars($category); ?>
                </div>

                <?php foreach ($category_products as $product): ?>
                    <div class="product-item">
                        <div class="product-info">
                            <h4><?php echo htmlspecialchars($product['product_name']); ?></h4>
                            <p class="product-price"><strong>Price:</strong> $<?php echo number_format($product['price'], 2); ?></p>
                            <p class="product-quantity"><strong>Stock Quantity:</strong> <?php echo htmlspecialchars($product['stock_quantity']); ?></p>
                            <p class="product-description"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                        </div>

                        <div class="product-image">
                            <?php if (!empty($product['image_url'])): ?>
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($product['image_url']); ?>" alt="Product Image">
                            <?php else: ?>
                                <p>No Image Available</p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="empty-message">No products available in the system.</p>
    <?php endif; ?>
</div>

</body>
</html>

<?php $conn = null; // Close the database connection ?>
