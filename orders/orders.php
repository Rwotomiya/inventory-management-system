<?php
require '../config.php';

// Initialize the search variable
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Prepare the base SQL query
$query = "SELECT orders.id, products.product_name AS product, suppliers.supplier_name AS supplier, orders.quantity, orders.order_date
          FROM orders
          JOIN products ON orders.product_id = products.id
          JOIN suppliers ON orders.supplier_id = suppliers.id";

// Add a search condition if the search term is provided
if ($search) {
    $query .= " WHERE products.product_name LIKE :search 
                OR suppliers.supplier_name LIKE :search 
                OR orders.quantity LIKE :search
                OR orders.order_date LIKE :search";
}

$stmt = $conn->prepare($query);

// Bind the search parameter if it exists
if ($search) {
    $stmt->bindValue(':search', '%' . $search . '%');
}

$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <!-- <link rel="stylesheet" href="../styles.css"> Link to your CSS -->
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
            padding: 5px 15px;
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
        <a href="../index.php">Dashboard</a> > <a href="orders.php">Orders</a>
    </div>
    <h1>Orders</h1>
    

    <!-- Search Form -->
    <form align="center" method="GET" action="orders.php">
        <input type="text" name="search" placeholder="Search by product, supplier, quantity, or date..." class="search-bar" value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="btn">Search</button>
    </form>

    <div align="center">
        <a href="add_order.php" class="adder">Add New Order</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Product</th>
                <th>Supplier</th>
                <th>Quantity</th>
                <th>Order Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($orders)): ?>
                <tr>
                    <td colspan="5">No orders found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['id']) ?></td>
                        <td><?= htmlspecialchars($order['product']) ?></td>
                        <td><?= htmlspecialchars($order['supplier']) ?></td>
                        <td><?= htmlspecialchars($order['quantity']) ?></td>
                        <td><?= htmlspecialchars($order['order_date']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
