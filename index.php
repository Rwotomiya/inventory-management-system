<?php
session_start(); // Start the session
require 'config.php';

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    // Display welcome message with username
    // echo "<h1>Welcome, " . htmlspecialchars($_SESSION['username']) . "</h1>";
} else {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            width: 80%;
            margin: auto;
        }

        h1 {
            margin-bottom: 20px;
        }

        .button-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
        }

        .btn {
            padding: 25px 5px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            text-align: center;
            display: inline-block;
            transition: background-color 0.3s;
            width: 150px; /* Set a fixed width to make buttons uniform */
        }

        .btn:hover {
            background-color: #0056b3;
        }

        /* Responsive Design for Smaller Screens */
        @media (max-width: 768px) {
            .button-container {
                flex-direction: column;
            }

            .btn {
                width: 100%; /* Full width on small screens */
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // Display welcome message with username
            if (isset($_SESSION['username'])) {
                echo "<h2>Hey " . htmlspecialchars($_SESSION['username']) . "</h2>";
            }
        ?>
        <h1>Welcome to the Inventory Management System</h1>
        
        <div class="button-container">
            <a href="products/products.php" class="btn">Manage Products</a>
            <a href="suppliers/suppliers.php" class="btn">Manage Suppliers</a>
            <a href="orders/orders.php" class="btn">Manage Orders</a>
            <a href="sales/sales.php" class="btn">Manage Sales</a>
            <a href="registration.php" class="btn">Register User</a>
            <a href="logout.php" class="btn">Logout</a>
        </div>
    </div>
</body>
</html>
