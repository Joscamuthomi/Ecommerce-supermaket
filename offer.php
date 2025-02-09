<?php
include 'db_connection.php'; // Include the database connection file

// Fetch offers from the database
$query = "SELECT * FROM offers WHERE active = 1 ORDER BY start_date DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$offers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Special Offers - QuickMart</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f8f8;
        }
        .offer-card {
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .offer-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        .offer-card img {
            border-radius: 10px 10px 0 0;
            object-fit: cover;
            height: 250px;
            width: 100%;
        }
        .offer-content {
            padding: 15px;
        }
        .offer-title {
            font-size: 22px;
            font-weight: bold;
            color: #333;
        }
        .offer-description {
            font-size: 14px;
            color: #777;
            margin: 10px 0;
        }
        .offer-discount {
            font-size: 18px;
            font-weight: bold;
            color: #e74c3c;
        }
        .offer-dates {
            font-size: 12px;
            color: #aaa;
            margin-top: 10px;
        }
        .container {
            margin-top: 30px;
        }
        /* Styling for the offer form */
        .offer-form {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .offer-form input, .offer-form select, .offer-form textarea {
            margin-bottom: 15px;
        }
        .offer-form button {
            background-color: #3498db;
            color: white;
            font-weight: bold;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .offer-form button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>


<!-- Add Offer Form Section -->
<div class="container my-5">
    <h3 class="text-center mb-4">Add a New Offer</h3>
    <div class="offer-form">
        <form action="process_offer.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Offer Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Offer Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="discount_percentage" class="form-label">Discount Percentage</label>
                <input type="number" class="form-control" id="discount_percentage" name="discount_percentage" min="1" max="100" required>
            </div>
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Offer Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit Offer</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
