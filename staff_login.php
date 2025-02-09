<?php
// Start the session
session_start();

// Include the database connection file
include('db_connection.php'); // Ensure this file returns a valid PDO object in $conn

// Check if the form is submitted
if (isset($_POST['login'])) {
    // Sanitize user input
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Prepare the SQL query
        $query = "SELECT * FROM staff WHERE username = :username";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        // Fetch user data
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify the password
            if (password_verify($password, $row['password'])) {
                // Set session variables
                $_SESSION['staff_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['role'] = $row['role'];

                // Redirect to staff portal
                header("Location: staff_portal.php");
                exit();
            } else {
                $error_message = "Invalid password!";
            }
        } else {
            $error_message = "Username does not exist!";
        }
    } catch (PDOException $e) {
        $error_message = "Database error: " . $e->getMessage();
    }
}

// No need to close PDO connection manually, it closes automatically
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login</title>
    <style>
        /* General styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f7fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #2c3e50;
        }

        /* Input styles */
        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            color: #333;
        }

        input:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
        }

        /* Button styles */
        button.login-btn {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button.login-btn:hover {
            background-color: #2980b9;
        }

        /* Error message styles */
        .error-message {
            color: #e74c3c;
            background-color: #fbe3e4;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            font-size: 14px;
            display: inline-block;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Staff Login</h2>
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" name="login" class="login-btn">Login</button>
        </form>
    </div>
</body>
</html>
