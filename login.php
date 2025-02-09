<?php
include 'db_connection.php';  // Include your database connection

// Start the session
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Query to find the user by username
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $conn->prepare($query);

        // Bind the username parameter
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);

        // Execute the query
        $stmt->execute();

        // Check if the user exists
        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            // Verify the password using password_verify
            if (password_verify($password, $user['password'])) {
                // Store user data in session
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_id'] = $user['id'];

                // Redirect to the shop page
                header("Location: shop.php");
                exit; // Ensure no further code is executed after the redirect
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No user found with that username.";
        }
    } catch (PDOException $e) {
        // Handle any potential errors
        echo "Error: " . $e->getMessage();
    }
}
?>
