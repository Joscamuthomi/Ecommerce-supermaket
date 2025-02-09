<?php
session_start();
include 'db_connection.php'; // Include your database connection

// Ensure that the staff is logged in (you can modify this check based on your authentication system)
if (!isset($_SESSION['staff_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch all orders from the purchases table
$query = "SELECT * FROM purchases ORDER BY purchase_date DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if there are any orders
if (empty($orders)) {
    $orders = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Customer Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            padding: 20px;
            text-align: center;
        }

        .orders-container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            background: #f1f1f1;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
        }

        .order-item span {
            font-size: 14px;
        }

        .total {
            font-weight: bold;
            margin-top: 10px;
            font-size: 16px;
        }

        .payment-method {
            font-size: 14px;
            color: #555;
        }

        .date {
            font-size: 14px;
            color: #777;
        }

        .no-orders {
            color: #d9534f;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="orders-container">
    <h2>Customer Orders</h2>

    <?php if (!empty($orders)): ?>
        <?php foreach ($orders as $order): ?>
            <div class="order-item">
                <span><strong>Purchase ID:</strong> <?php echo htmlspecialchars($order['purchase_id']); ?></span>
                <span><strong>User ID:</strong> <?php echo htmlspecialchars($order['user_id']); ?></span>
                <span><strong>Product ID:</strong> <?php echo htmlspecialchars($order['product_id']); ?></span>
                <span><strong>Quantity:</strong> <?php echo htmlspecialchars($order['quantity']); ?></span>
                <span><strong>Total Price:</strong> $<?php echo number_format($order['total_price'], 2); ?></span>
            </div>
            <div class="order-item">
                <span><strong>Payment Method:</strong> <?php echo htmlspecialchars($order['payment_method']); ?></span>
                <span><strong>Extraction Point:</strong> <?php echo htmlspecialchars($order['extraction_point']); ?></span>
                <span><strong>Order Date:</strong> <?php echo date("F j, Y, g:i a", strtotime($order['purchase_date'])); ?></span>
            </div>
            <hr>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="no-orders">No orders found in the system.</p>
    <?php endif; ?>

</div>

</body>
</html>

<?php $conn = null; // Close the database connection ?>
