<?php
// db_connection.php
$servername = "localhost";
$username = "root";  // Use your database username
$password = "";      // Use your database password (empty for XAMPP default)
$dbname = "quickmart"; // Your database name

// Create connection
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
