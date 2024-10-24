<?php
require '../config.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';

// Fetch products with search functionality
$query = "SELECT * FROM products WHERE product_name LIKE ?";
$stmt = $conn->prepare($query);
$stmt->execute(['%' . $search . '%']);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Management</title>
    <style>
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

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        a {
            text-decoration: none;
            color: #333;
        }

        .adder {
            margin: 10px auto;
            padding: 8px 15px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            display: inline-block;
        }

        .adder:hover {
            background-color: #218838;
        }

        button {
            padding: 8px 15px;
            border: none;
            background-color: #28a745;
            color: white;
            cursor: pointer;
            border-radius: 8px;
            margin-left: 60px;
        }

        .btn {
            padding: 8px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 15px;
            margin: 10px;
            text-align: center;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .search-bar {
            border-radius: 15px;
            padding: 8px 5px;
            width: 300px;
        }

        .breadcrums {
            margin: 10px;
        }

        .breadcrums a {
            color: #0056b3;
            text-decoration: underline;
            margin-right: 10px;
        }

        @media (max-width: 768px) {
            table {
                width: 100%;
            }

            .btn, .adder {
                width: 100%;
                text-align: center;
            }

            .search-bar {
                width: 80%;
            }
        }
    </style>
</head>
<body>
    <div class="breadcrums">
        <a href="../index.php">Dashboard</a>> <a href="products.php">Products</a>
    </div>

    <h1>Products</h1>

    <form method="GET" align="center" action="products.php">
        <input type="text" name="search" placeholder="Search products..." class="search-bar" value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="btn">Search</button>
    </form>

    <div align="center">
        <a href="add_product.php" class="adder">Add Product</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= $product['id'] ?></td>
                        <td><?= $product['product_name'] ?></td>
                        <td><?= $product['price'] ?></td>
                        <td><?= $product['stock_quantity'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No products found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
