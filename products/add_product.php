<?php
require '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Correct variable name usage
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];  // Change stock_quantity to stock

    // Correct variable used in the execute statement
    $stmt = $conn->prepare("INSERT INTO products (product_name, price, stock_quantity) VALUES (?, ?, ?)");
    $stmt->execute([$product_name, $price, $stock]);  // Use $stock instead of $stock_quantity

    header('Location: products.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            margin-left:0;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            padding: 10px 20px;
            border: none;
            background-color: #28a745;
            color: white;
            cursor: pointer;
            border-radius: 8px;
            margin: 10px 0;
            align-items: center;
        }

        button:hover {
            background-color: #218838;
        }

        .back-button {
            background-color: #007bff;
            margin-top: 10px;
            text-align: center;
        }

        .back-button:hover {
            background-color: #0056b3;
        }

        @media (max-width: 768px) {
            .form-container {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Add New Product</h1>

        <form method="POST" action="">
            <b><label for="product_name">Name:</label></b>
            <input type="text" name="product_name" id="product_name" required>

            <b><label for="price">Price:</label></b>
            <input type="number" step="0.01" name="price" id="price" required>

            <b><label for="stock">Stock:</label></b>
            <input type="number" name="stock" id="stock_quantity" required> <!-- Fixed name to "stock" -->

            <button align="center" type="submit">Add Product</button>
        </form>

        <a href="products.php">
            <button align="center" class="back-button">Back to Products</button>
        </a>
    </div>
</body>
</html>
