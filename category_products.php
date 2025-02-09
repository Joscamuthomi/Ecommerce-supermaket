<?php
include 'db_connection.php'; // Include the database connection file
session_start();

// Check if a category is selected
if (isset($_GET['category'])) {
    $category = $_GET['category'];

    // Fetch products based on the selected category
    $query = "SELECT * FROM products WHERE category = :category";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':category', $category);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "No category selected.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products in <?php echo htmlspecialchars($category); ?> Category</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }

        nav {
            background-color: #333;
            padding: 15px;
            color: white;
            text-align: center;
        }

        .category-title {
            text-align: center;
            padding: 20px;
        }

        .product-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 40px 20px;
        }

        .product {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            position: relative;
        }

        .product img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .product h3 {
            font-size: 24px;
            color: #333;
            margin: 10px 0;
        }

        .product p {
            font-size: 16px;
            color: #777;
        }

        .product .price {
            font-size: 20px;
            color: #28a745;
            margin-top: 10px;
            cursor: pointer;
            font-weight: bold;
            border: 2px solid #28a745;
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .product .price:hover {
            background-color: #28a745;
            color: white;
        }

        .add-to-cart {
            display: none;
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .add-to-cart:hover {
            background-color: #0056b3;
        }

        .selected {
            background-color: #d4edda;
        }

        .footer {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

<nav>
    <h1>QuickMart</h1>
</nav>

<div class="category-title">
    <h1>Products in <?php echo htmlspecialchars($category); ?> Category</h1>
</div>

<div class="product-container">
    <?php if ($products): ?>
        <?php foreach ($products as $product): ?>
            <div class="product">
                <img src="data:image/jpeg;base64,<?php echo base64_encode($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <p class="price" onclick="toggleSelection(this, '<?php echo htmlspecialchars($product['product_name']); ?>', <?php echo $product['price']; ?>)">
                    $<?php echo number_format($product['price'], 2); ?>
                </p>
                <button class="add-to-cart" onclick="addToCart('<?php echo htmlspecialchars($product['product_name']); ?>', <?php echo $product['price']; ?>)">Add to Cart</button>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No products found in this category.</p>
    <?php endif; ?>
</div>

<div class="footer">
    <p>&copy; 2025 QuickMart. All rights reserved.</p>
</div>

<script>
    function toggleSelection(priceElement, productName, productPrice) {
        let productDiv = priceElement.closest('.product');
        let button = productDiv.querySelector('.add-to-cart');

        if (productDiv.classList.contains('selected')) {
            productDiv.classList.remove('selected');
            button.style.display = 'none';
        } else {
            productDiv.classList.add('selected');
            button.style.display = 'block';
        }
    }

    function addToCart(productName, productPrice) {
        fetch('cart.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: new URLSearchParams({ action: 'add', name: productName, price: productPrice })
        })
        .then(response => response.json())
        .then(data => alert(data.message))
        .catch(error => console.error('Error:', error));
    }
</script>

</body>
</html>
