<?php
require '../config.php';

// Check if a search term is set and create the SQL query accordingly
$search = isset($_GET['search']) ? $_GET['search'] : '';
$query = "SELECT sales.id, products.product_name AS product, sales.quantity, sales.sale_date, suppliers.supplier_name AS supplier
          FROM sales
          JOIN products ON sales.product_id = products.id
          JOIN suppliers ON sales.supplier_id = suppliers.id"; // Join the suppliers table

// If a search term is provided, modify the query to filter by product name
if (!empty($search)) {
    $query .= " WHERE products.product_name LIKE :search";
    $stmt = $conn->prepare($query);
    $stmt->execute(['search' => "%$search%"]);
} else {
    $stmt = $conn->query($query);
}

$sales = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Management</title>
    <link rel="stylesheet" href="../styles.css">
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
        <a href="../index.php">Dashboard</a> > <a href="sales.php">Sales</a>
    </div>
    <h1>Sales</h1>

    <!-- Search Form -->
    <form method="GET" align="center" action="sales.php">
        <input type="text" name="search" placeholder="Search sales by product..." class="search-bar" value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="btn">Search</button>
    </form>

    <div align="center">
        <a href="add_sale.php" class="adder">Add New Sale</a>
    </div>

    <table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Product</th>
            <th>Supplier</th> <!-- Added Supplier column header -->
            <th>Quantity</th>
            <th>Sale Date</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($sales) > 0): ?>
            <?php foreach ($sales as $sale): ?>
                <tr>
                    <td><?= $sale['id'] ?></td>
                    <td><?= $sale['product'] ?></td>
                    <td><?= $sale['supplier'] ?></td> <!-- Added Supplier column data -->
                    <td><?= $sale['quantity'] ?></td>
                    <td><?= $sale['sale_date'] ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">No sales found for "<?= htmlspecialchars($search) ?>"</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
</body>
</html>
