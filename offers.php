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
        footer{
            background-color: #333;
            color: #f8f8f8;
            justify-content: center;
            font-size: 15px;
            font-family: sans-serif;
            height: 50px;
            border-radius: 5px;
            
        }
    </style>
</head>
<body>

<!-- Main Offers Section -->
<div class="container">
    <h2 class="text-center my-5">Current Special Offers</h2>
    <div class="row">
        <?php foreach ($offers as $offer): ?>
            <div class="col-md-4 mb-4">
                <div class="offer-card">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($offer['image']); ?>" alt="Offer Image">
                    <div class="offer-content">
                        <h3 class="offer-title"><?php echo htmlspecialchars($offer['title']); ?></h3>
                        <p class="offer-description"><?php echo nl2br(htmlspecialchars($offer['description'])); ?></p>
                        <p class="offer-discount"><?php echo $offer['discount_percentage']; ?>% OFF</p>
                        <div class="offer-dates">
                            <p>Start Date: <?php echo date('F j, Y', strtotime($offer['start_date'])); ?></p>
                            <p>End Date: <?php echo date('F j, Y', strtotime($offer['end_date'])); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

 <footer>
    <h3>Web design mastery @2025. all rights reserved</h3>

 </footer>
  
</body>
</hhtm >