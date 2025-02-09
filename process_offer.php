<?php
include 'db_connection.php'; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $discount_percentage = $_POST['discount_percentage'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
    } else {
        // If no image, set it as NULL
        $image = NULL;
    }

    // Prepare and execute the insert query
    $query = "INSERT INTO offers (title, description, discount_percentage, image, active, start_date, end_date) 
              VALUES (:title, :description, :discount_percentage, :image, 1, :start_date, :end_date)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':discount_percentage', $discount_percentage);
    $stmt->bindParam(':image', $image, PDO::PARAM_LOB); // Store image as LOB (Large Object)
    $stmt->bindParam(':start_date', $start_date);
    $stmt->bindParam(':end_date', $end_date);

    if ($stmt->execute()) {
        echo "<script>alert('Offer submitted successfully!'); window.location.href='offer.php';</script>";
    } else {
        echo "<script>alert('Error submitting offer. Please try again.'); window.location.href='offer.php';</script>";
    }
}
?>
