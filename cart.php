<?php
session_start();
include('db_connection.php'); // Include the database connection file

// Test connection (PDO version)
if (!$conn) {
    die('Database connection failed!');
}

// Handle item addition via AJAX
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $product = [
        'name' => $_POST['name'],
        'price' => $_POST['price']
    ];
    $_SESSION['cart'][] = $product;
    echo json_encode(["status" => "success", "message" => "Item added to cart"]);
    exit;
}

// Handle checkout
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['checkout'])) {
    $paymentMethod = $_POST['payment_method'];
    $paymentDetails = $_POST['payment_details'];
    $deliveryLocation = $_POST['delivery_location'];

    // Ensure user is logged in (for this example, we'll set a static user id)
    $userId = 1; // This should be the actual logged-in user ID

    if (!empty($_SESSION['cart'])) {
        // Insert purchase data into the purchases table
        foreach ($_SESSION['cart'] as $item) {
            // Prepare the query using PDO
            $stmt = $conn->prepare("INSERT INTO purchases (user_id, product_id, quantity, total_price, payment_method, extraction_point) VALUES (?, ?, ?, ?, ?, ?)");

            // You will need to use the correct values here. For now, let's assume each item in the cart corresponds to a single product with an ID of 1.
            // Replace this with actual product ID from your session/cart
            $productId = 1; // Placeholder for product_id
            $quantity = 1; // Assuming quantity of 1 for each item in the cart
            $totalPrice = $item['price']; // Total price is the price of the item in the cart

            // Bind the parameters
            $stmt->bindParam(1, $userId, PDO::PARAM_INT);
            $stmt->bindParam(2, $productId, PDO::PARAM_INT);
            $stmt->bindParam(3, $quantity, PDO::PARAM_INT);
            $stmt->bindParam(4, $totalPrice, PDO::PARAM_STR);
            $stmt->bindParam(5, $paymentMethod, PDO::PARAM_STR);
            $stmt->bindParam(6, $deliveryLocation, PDO::PARAM_STR);

            // Execute the query
            $stmt->execute();
        }

        // Clear cart after purchase
        $_SESSION['cart'] = [];
        $successMessage = "Payment successful using $paymentMethod! Delivery will be made to: $deliveryLocation.";
    } else {
        $errorMessage = "Your cart is empty.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        /* Overall Layout */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .cart-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .cart-container h2 {
            text-align: center;
            font-size: 32px;
            color: #333;
            margin-bottom: 20px;
        }

        /* Success Message */
        .success {
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
            padding: 18px;
            border-radius: 10px;
            font-size: 18px;
            text-align: center;
            margin-bottom: 30px;
        }

        /* Error Message */
        .error {
            background-color: #f2dede;
            color: #a94442;
            border: 1px solid #ebccd1;
            padding: 18px;
            border-radius: 10px;
            font-size: 18px;
            text-align: center;
            margin-bottom: 30px;
        }

        /* Cart Item List */
        #cart-items {
            margin-bottom: 30px;
        }

        /* Individual Cart Item */
        .cart-item {
            display: flex;
            justify-content: space-between;
            padding: 18px;
            border-bottom: 1px solid #ddd;
            font-size: 18px;
        }

        .cart-item .item-name {
            font-weight: 500;
            color: #333;
        }

        .cart-item .item-price {
            color: #007bff;
            font-weight: 600;
        }

        /* Cart Totals */
        .total {
            display: flex;
            justify-content: space-between;
            padding: 20px 0;
            font-size: 22px;
            font-weight: 600;
            border-top: 2px solid #ddd;
            margin-top: 20px;
        }

        .total .label {
            color: #333;
        }

        .total .amount {
            color: #28a745;
        }

        /* Checkout Section */
        .checkout {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 30px;
        }

        .checkout label {
            font-size: 18px;
            color: #333;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .checkout select, .checkout input, .checkout textarea {
            width: 100%;
            padding: 12px 18px;
            font-size: 16px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: border-color 0.3s ease;
        }

        .checkout select:focus, .checkout input:focus, .checkout textarea:focus {
            border-color: #007bff;
        }

        .checkout button {
            background-color: #007bff;
            color: white;
            padding: 16px 25px;
            font-size: 20px;
            border: none;
            border-radius: 8px;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .checkout button:hover {
            background-color: #0056b3;
        }

        /* Responsive Adjustments */
        @media screen and (max-width: 768px) {
            .cart-container {
                padding: 30px;
            }

            .cart-container h2 {
                font-size: 28px;
            }

            .cart-item {
                font-size: 16px;
                padding: 12px;
            }

            .checkout button {
                font-size: 18px;
                padding: 14px 20px;
            }

            .total {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>

<div class="cart-container">
    <h2>Your Shopping Cart</h2>

    <?php if (isset($successMessage)) echo "<p class='success'>$successMessage</p>"; ?>
    <?php if (isset($errorMessage)) echo "<p class='error'>$errorMessage</p>"; ?>

    <div id="cart-items">
        <?php 
        $total = 0;
        if (!empty($_SESSION['cart'])): 
            foreach ($_SESSION['cart'] as $item): 
                $total += $item['price']; 
        ?>
                <div class="cart-item">
                    <span class="item-name"><?php echo htmlspecialchars($item['name']); ?></span>
                    <span class="item-price">$<?php echo number_format($item['price'], 2); ?></span>
                </div>
        <?php endforeach; ?>
        
        <p class="total">Total: $<?php echo number_format($total, 2); ?></p>

        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>

    <?php if (!empty($_SESSION['cart'])): ?>
        <form method="POST" class="checkout">
            <h3>Payment Details</h3>
            <label for="payment_method">Select Payment Method:</label>
            <select name="payment_method" id="payment_method" required>
                <option value="Mpesa">Mpesa</option>
                <option value="Credit Card">Credit Card</option>
            </select>

            <label for="payment_details">Enter Mpesa No. / Card Details:</label>
            <input type="text" name="payment_details" id="payment_details" required placeholder="e.g., 0712345678 or 4111-1111-1111-1111">

            <h3>Delivery Location</h3>
            <label for="delivery_location">Pin Your Location:</label>
            <textarea name="delivery_location" id="delivery_location" required placeholder="Enter delivery address or landmark"></textarea>

            <button type="submit" name="checkout">Buy Now</button>
        </form>
    <?php endif; ?>
</div>

<script>
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
