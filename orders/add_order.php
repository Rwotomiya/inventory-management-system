<?php
require '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data and check if it's set
    $product_id = isset($_POST['product_id']) ? trim($_POST['product_id']) : null;
    $supplier_id = isset($_POST['supplier_id']) ? trim($_POST['supplier_id']) : null;
    $quantity = isset($_POST['quantity']) ? trim($_POST['quantity']) : null;

    // Check if all fields are filled
    if ($product_id && $supplier_id && $quantity) {
        try {
            // Prepare and execute the SQL statement
            $stmt = $conn->prepare("INSERT INTO orders (product_id, supplier_id, quantity) VALUES (?, ?, ?)");
            $stmt->execute([$product_id, $supplier_id, $quantity]);

            // Redirect back to the orders page after success
            header('Location: orders.php');
            exit;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Please fill in all required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Order</title>
    <link rel="stylesheet" href="../styles.css"> <!-- Link to your CSS -->
    <style>
        /* Additional styles to match the other pages */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin: 20px 0;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Transparent background */
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin: 15px 0 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"] {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        button {
            padding: 10px 15px;
            border: none;
            background-color: #28a745; /* Primary button color */
            color: white;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
            
        }

        button:hover {
            background-color: #218838; /* Darker shade on hover */
        }

        .back-button {
            background-color: #007bff;
            margin-top: 10px;
        }

        .back-button:hover {
            background-color: #0056b3;
        }
        a {
            text-decoration: none;
            color: #333;
            display: inline-block;
            margin-top: 10px;
            text-align: center;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add New Order</h1>

        <form method="POST" action="">
            <label for="product_id">Product ID:</label>
            <input type="text" name="product_id" required>

            <label for="supplier_id">Supplier ID:</label>
            <input type="text" name="supplier_id" required>

            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" required>

            <button type="submit">Add Order</button>
        </form>

        <a href="orders.php">
            <button class="back-button">Back to Orders</button>
        </a>
    </div>
</body>
</html>
