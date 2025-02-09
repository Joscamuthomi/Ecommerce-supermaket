<?php
// Include database connection file
include 'db_connection.php';

// Fetch the selected category from the URL
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : null;

if ($selectedCategory) {
    // Fetch products from the selected category
    $query = "SELECT * FROM products WHERE category = :category";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':category', $selectedCategory);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $products = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($selectedCategory); ?> - Our Products</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 0 auto;
        }
        nav {
            background-color: #333;
            padding: 10px;
            color: white;
        }
        nav .logo {
            font-size: 24px;
            font-weight: bold;
            float: left;
        }
        nav .toggle {
            display: none;
        }
        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            overflow: hidden;
        }
        nav ul li {
            display: inline-block;
            margin: 0 15px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
        }
        .category-title {
            text-align: center;
            padding: 50px 0;
            background-color: #fff;
            margin-bottom: 30px;
        }
        .category-title h1 {
            font-size: 36px;
            color: #333;
        }
        .product-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        .product-item {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .product-item img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            max-height: 200px;
            object-fit: cover;
        }
        .product-item h3 {
            font-size: 20px;
            color: #333;
            margin: 15px 0;
        }
        .product-item p {
            color: #777;
            font-size: 16px;
            margin-bottom: 10px;
        }
        .product-item .price {
            font-size: 18px;
            color: #27ae60;
            font-weight: bold;
        }
        .footer {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
            margin-top: 50px;
        }
        .footer p {
            margin: 0;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav>
    <div class="logo">QuickMart</div>
    <ul>
        <li><a href="shop.php">Products</a></li>
        <li><a href="cart.php">Cart</a></li>
        <li><a href="offers.php">Offers</a></li>
    </ul>
</nav>

<!-- Category Title Section -->
<div class="category-title">
    <h1>Products in "<?php echo htmlspecialchars($selectedCategory); ?>"</h1>
</div>

<!-- Product List Section -->
<div class="product-list">
    <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
            <div class="product-item">
                <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <div class="price">$<?php echo number_format($product['price'], 2); ?></div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No products available in this category.</p>
    <?php endif; ?>
</div>

<!-- Footer Section -->
<div class="footer">
    <p>&copy; 2025 QuickMart. All rights reserved.</p>
</div>

</body>
</html>
