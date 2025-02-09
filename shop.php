<?php
include 'db_connection.php'; // Include the database connection file

// Fetch product categories from the database
$query = "SELECT DISTINCT category FROM products";
$stmt = $conn->prepare($query);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - Our Products</title>
    <style>
        /* General page styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f8f8f8;
        }

        /* Navbar styles */
        nav {
            background-color: #333;
            padding: 15px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 100%;
            z-index: 1000;
            height: 60px;
        }

        nav .logo {
            font-size: 24px;
            font-weight: bold;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            width: 80%;
        }

        nav ul li {
            margin-left: 20px;
            position: relative; /* Important for the dropdown menu */
        }

        nav ul li a {
            text-decoration: none;
            color: white;
            font-size: 18px;
            transition: color 0.3s;
        }

        nav ul li a:hover {
            color: #f0c14b;
        }

        /* Dropdown Menu */
        nav ul li:hover > .dropdown {
            display: block;
        }

        .dropdown {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #333;
            min-width: 180px;
            padding: 10px 0;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 999;
        }

        .dropdown a {
            color: white;
            padding: 8px 20px;
            display: block;
            text-decoration: none;
            font-size: 16px;
        }

        .dropdown a:hover {
            background-color: #f0c14b;
        }

        /* Mobile Menu */
        nav .toggle {
            display: none;
        }

        @media (max-width: 768px) {
            /* Center the toggle button */
            nav .toggle {
                display: block;
                cursor: pointer;
                font-size: 28px;
                color: white;
                margin-left: auto;
                margin-right: auto;
            }

            nav ul {
                display: none;
                flex-direction: column;
                background-color: #333;
                position: absolute;
                top: 60px;
                left: 0;
                width: 100%;
                padding: 10px;
                box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            }

            nav ul li {
                margin-left: 0;
                margin-top: 10px;
            }

            nav ul.show {
                display: flex;
                justify-content: flex-start; /* Align menu items to the left */
            }
        }

        /* Shop homepage image */
        .shop-banner {
            width: 100%;
            height: 100vh; /* Full screen height */
            background-image: url('products/shop home.jpeg'); /* Add your shop interior image URL here */
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative; /* Required to position categories and buttons over the image */
            text-align: center;
            color: white;
        }

        .shop-banner h1 {
            font-size: 48px;
            margin: 0;
            padding: 0;
            z-index: 10;
        }

        /* Categories section over the image */
        .categories-container {
            display: flex;
            justify-content: center;
            margin-top: 30px;
            position: absolute;
            bottom: 150px; /* Adjust position to be above the buttons */
            left: 0;
            right: 0;
            z-index: 10;
            width: 100%;
            padding: 0 20px;
            overflow: hidden; /* Hide overflowing categories */
        }

        .categories {
            display: flex;
            transition: transform 0.3s ease-in-out;
        }

        .category {
            background-color: rgba(255, 255, 255, 0.7);
            padding: 20px;
            margin: 10px;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 200px;
            transition: transform 0.3s;
        }

        .category:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .category h3 {
            margin: 0;
            font-size: 22px;
            color: #333;
        }

        .category p {
            color: #777;
            margin-top: 5px;
        }

        /* Button container positioned below categories */
        .button-container {
            position: absolute;
            bottom: 50px; /* Position the buttons just below the categories */
            left: 50%;
            transform: translateX(-50%);
            z-index: 15;
        }

        .button {
            background-color: #f0c14b;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            margin: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #b9a13d;
        }
        /* Footer Styling */
.footer {
    background-color: #333;
    color: white;
    padding: 40px 20px;
    text-align: center;
    font-size: 16px;
    position: relative;
    bottom: 0;
    width: 100%;
}

.footer .footer-content {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    margin-bottom: 20px;
}

.footer .footer-left,
.footer .footer-center,
.footer .footer-right {
    flex: 1;
    margin: 10px;
}

.footer .footer-left h3 {
    font-size: 24px;
    margin-bottom: 10px;
}

.footer .footer-center h4,
.footer .footer-right h4 {
    font-size: 20px;
    margin-bottom: 10px;
}

.footer .social-links {
    display: flex;
    justify-content: space-around;
}

.footer .social-link {
    text-decoration: none;
    color: white;
    margin: 0 10px;
    font-size: 18px;
    transition: color 0.3s ease;
}

.footer .social-link:hover {
    color: #f0c14b;
}

.footer p {
    margin: 5px 0;
    font-size: 14px;
}

@media (max-width: 768px) {
    .footer-content {
        flex-direction: column;
        text-align: center;
    }

    .footer-left,
    .footer-center,
    .footer-right {
        margin-bottom: 20px;
    }

    .footer .social-links {
        flex-direction: column;
    }
}


    </style>
</head>
<body>
<!-- Navbar -->
<nav>
    <div class="logo">QuickMart</div>
    <div class="toggle" onclick="toggleMenu()">☰</div>
    <ul>
        <li><a href="shop.php">Home</a></li>
        <li><a href="shop.php">Products</a>
            <!-- Dropdown for product categories -->
            <div class="dropdown">
                <?php foreach ($categories as $category): ?>
                    <a href="category_products.php?category=<?php echo urlencode($category['category']); ?>"><?php echo htmlspecialchars($category['category']); ?></a>
                <?php endforeach; ?>
            </div>
        </li>
        <li><a href="cart.php">Cart</a></li>
        <li><a href="offers.php">Offers</a></li>
    </ul>
</nav>

<!-- Shop Banner Section -->
<div class="shop-banner">
    <h1 style="color: blue; font-family:'Times New Roman', Times, serif;">Welcome to QuickMart Shop</h1>

    <!-- Categories Section -->
    <div class="categories-container">
        <div class="categories" id="categoryList">
            <?php foreach ($categories as $category): ?>
                <div class="category">
                    <h3><?php echo htmlspecialchars($category['category']); ?></h3>
                    <p>Explore our wide range of products</p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Buttons Below Categories -->
    <div class="button-container">
        <button class="button" id="prevBtn" onclick="moveCategories(-1)">Previous</button>
        <button class="button" id="nextBtn" onclick="moveCategories(1)">Next</button>
    </div>
</div>
<!-- Footer Section -->
<footer class="footer">
    <div class="footer-content">
        <div class="footer-left">
            <h3>QuickMart</h3>
            <p>Your one-stop shop for all things quick and convenient.</p>
            <p>&copy; 2025 QuickMart. All rights reserved.</p>
        </div>
        <div class="footer-center">
            <h4>Contact Us</h4>
            <p>Email: support@quickmart.com</p>
            <p>Phone: +123 456 7890</p>
        </div>
        <div class="footer-right">
            <h4>Follow Us</h4>
            <div class="social-links">
                <a href="#" class="social-link">Facebook</a>
                <a href="#" class="social-link">Instagram</a>
                <a href="#" class="social-link">Twitter</a>
            </div>
        </div>
    </div>
</footer>


<script>
    // Toggle menu for mobile devices
    function toggleMenu() {
        const navLinks = document.querySelector('nav ul');
        navLinks.classList.toggle('show');
    }

    let currentPosition = 0;

    function moveCategories(direction) {
        const categories = document.getElementById('categoryList');
        const totalCategories = categories.children.length;
        const visibleCount = 3; // Adjust how many categories are shown at a time
        const categoryWidth = categories.children[0].offsetWidth + 20; // 20px for margin

        // Calculate the new position
        currentPosition += direction;

        if (currentPosition < 0) {
            currentPosition = 0;
        } else if (currentPosition > totalCategories - visibleCount) {
            currentPosition = totalCategories - visibleCount;
        }

        // Move categories
        categories.style.transform = `translateX(-${categoryWidth * currentPosition}px)`;
    }
</script>

</body>
</html>
