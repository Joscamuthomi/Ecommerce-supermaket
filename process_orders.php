<?php
session_start();
include 'db_connection.php'; // Include your database connection

// Ensure that the staff is logged in (you can modify this check based on your authentication system)
if (!isset($_SESSION['staff_id'])) {
    header('Location: login.php');
    exit;
}

// Process order status update
if (isset($_POST['update_status'])) {
    $purchase_id = $_POST['purchase_id'];
    $status = $_POST['status'];

    // Update the order status in the database
    $update_query = "UPDATE purchases SET status = :status WHERE purchase_id = :purchase_id";
    $stmt = $conn->prepare($update_query);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':purchase_id', $purchase_id);
    
    if ($stmt->execute()) {
        $message = "Order status updated successfully!";
    } else {
        $message = "Failed to update order status.";
    }
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
    <title>Process Orders</title>
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

        .status-form select {
            padding: 5px;
            margin-right: 10px;
        }

        .status-form button {
            padding: 5px 10px;
            background-color: #28a745;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        .status-form button:hover {
            background-color: #218838;
        }

        .message {
            margin: 20px 0;
            font-weight: bold;
            color: #d9534f;
        }

        .date {
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>

<div class="orders-container">
    <h2>Process Customer Orders</h2>

    <?php if (isset($message)): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>

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

            <div class="order-item">
                <form method="POST" class="status-form">
                    <input type="hidden" name="purchase_id" value="<?php echo htmlspecialchars($order['purchase_id']); ?>">
                    <select name="status">
                        <option value="Pending" <?php echo ($order['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                        <option value="Processed" <?php echo ($order['status'] == 'Processed') ? 'selected' : ''; ?>>Processed</option>
                        <option value="Shipped" <?php echo ($order['status'] == 'Shipped') ? 'selected' : ''; ?>>Shipped</option>
                        <option value="Completed" <?php echo ($order['status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                    </select>
                    <button type="submit" name="update_status">Update Status</button>
                </form>
            </div>

            <hr>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No orders found in the system.</p>
    <?php endif; ?>

</div>

</body>
</html>

<?php $conn = null; // Close the database connection ?>
