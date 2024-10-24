<?php
include '../config.php'; // Include your database configuration

// Initialize variables
$product_id = "";
$supplier_id = "";
$quantity = 0;
$errors = [];

// Fetch existing products
try {
    $products = $conn->query("SELECT id, product_name, price FROM products")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching products: " . $e->getMessage();
}

// Fetch existing suppliers
try {
    $suppliers = $conn->query("SELECT id, supplier_name FROM suppliers")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching suppliers: " . $e->getMessage();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs
    $product_id = intval($_POST['product_id']);
    $supplier_id = intval($_POST['supplier_id']);
    $quantity = intval($_POST['quantity']);

    // Fetch the selected product's price
    $stmt = $conn->prepare("SELECT price FROM products WHERE id = :product_id");
    $stmt->bindParam(':product_id', $product_id);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $total_price = $quantity * floatval($product['price']);
    } else {
        $errors[] = "Selected product not found.";
    }

    // Validate inputs
    if (empty($product_id) || empty($supplier_id) || $quantity <= 0) {
        $errors[] = "Please fill in all fields with valid data.";
    }

    // If no errors, insert into database
    if (count($errors) == 0) {
        try {
            $stmt = $conn->prepare("INSERT INTO sales (product_id, supplier_id, quantity) VALUES (:product_id, :supplier_id, :quantity)");
            $stmt->bindParam(':product_id', $product_id);
            $stmt->bindParam(':supplier_id', $supplier_id);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->execute();

            // Redirect to sales page after successful insertion
            header("Location: sales.php");
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background: rgba(255, 255, 255, 0.9); /* Semi-transparent background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .error {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        select, input[type="number"], input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            padding: 10px 15px;
            background-color: #28a745; /* Button color */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #218838; /* Darker button color on hover */
        }

        .back-button {
            background-color: #007bff;
            margin-top: 10px;
        }

        .back-button:hover {
            background-color: #0056b3;
        }

        .btn {
            text-decoration: none;
            color: white;
            background-color: #007bff; /* Back button color */
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            display: inline-block;
            margin-top: 15px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3; /* Darker back button color on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Sale</h2>
        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form action="add_sale.php" method="POST">
            <label for="product_id">Product:</label>
            <select name="product_id" id="product_id" required>
                <option value="">Select a product</option>
                <?php foreach ($products as $product): ?>
                    <option value="<?php echo $product['id']; ?>"><?php echo $product['product_name']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="supplier_id">Supplier:</label>
            <select name="supplier_id" id="supplier_id" required>
                <option value="">Select a supplier</option>
                <?php foreach ($suppliers as $supplier): ?>
                    <option value="<?php echo $supplier['id']; ?>"><?php echo $supplier['supplier_name']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" required min="1">

            <button type="submit">Add Sale</button>
        </form>
        <a href="sales.php">
            <button class="back-button">Back to Sales</button>
        </a>
    </div>
</body>
</html>

