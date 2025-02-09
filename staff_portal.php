<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supermart Staff Portal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .navbar {
            background-color: #2c3e50;
            position: absolute;
            width: 100%;
            z-index: 10;
        }
        .navbar-brand, .nav-link {
            color: white !important;
        }
        .nav-link:hover {
            background-color: #34495e;
            border-radius: 5px;
        }
        .dropdown-menu {
            background-color: #34495e;
        }
        .dropdown-item {
            color: white !important;
        }
        .dropdown-item:hover {
            background-color: #1abc9c;
        }
        .hero {
            width: 100vw;
            height: 100vh;
            background: url('images/staff.home.jpeg') no-repeat center center/cover;
            position: relative;
        }
        .footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>


<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><span style="color:rgb(255, 0, 191); font-size:26px; text-shadow: 2px rgb(245, 7, 47);">Quick <br> Mart </span><Span>Staff Portal</Span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="#">Dashboard</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Order Management</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="view_orders.php">View Orders</a></li>
                        <li><a class="dropdown-item" href="process_orders.php">Process Orders</a></li>
                        <li><a class="dropdown-item" href="#">Track Deliveries</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Inventory</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="stock_overview.php">Stock Overview</a></li>
                        <li><a class="dropdown-item" href="add_product.php">Add New Products</a></li>
                        <li><a class="dropdown-item" href="update_products.php">Update Product Details</a></li>
                        <li><a class="dropdown-item" href="offer.php">record offers</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Customer Support</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">View Queries</a></li>
                        <li><a class="dropdown-item" href="#">Respond to Complaints</a></li>
                        <li><a class="dropdown-item" href="chat_live.php">Live Chat Support</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Sales & Reports</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Sales Analytics</a></li>
                        <li><a class="dropdown-item" href="#">Revenue Reports</a></li>
                        <li><a class="dropdown-item" href="#">Best-Selling Products</a></li>
                        <li><a class="dropdown-item" href="#">Staff Performance</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Suppliers</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">View Suppliers</a></li>
                        <li><a class="dropdown-item" href="#">Manage Vendor Orders</a></li>
                        <li><a class="dropdown-item" href="#">Update Supplier Info</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Staff Management</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">View Staff</a></li>
                        <li><a class="dropdown-item" href="#">Add New Staff</a></li>
                        <li><a class="dropdown-item" href="#">Assign Roles</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Profile</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Edit Profile</a></li>
                        <li><a class="dropdown-item" href="#">Change Password</a></li>
                        <li><a class="dropdown-item text-danger" href="#">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="hero"></div>

<footer class="footer">&copy; 2024 Quick Mart Staff Portal. All Rights Reserved.</footer>

</body>
</html>
