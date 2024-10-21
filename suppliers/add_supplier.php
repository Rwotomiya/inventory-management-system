<?php
require '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data and check if it's set
    $name = isset($_POST['supplier_name']) ? trim($_POST['supplier_name']) : null;
    $contact = isset($_POST['contact']) ? trim($_POST['contact']) : null;

    // Check if both fields are filled
    if ($name && $contact) {
        try {
            // Prepare and execute the SQL statement
            $stmt = $conn->prepare("INSERT INTO suppliers (supplier_name, contact) VALUES (?, ?)");
            $stmt->execute([$name, $contact]);

            // Redirect back to the suppliers page after success
            header('Location: suppliers.php');
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
    <title>Add Supplier</title>
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
            background-color: rgba(255, 255, 255, 0.8); /* White background with 80% opacity */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            /* text-align: center; */
        }


        label {
            display: block;
            margin-bottom: 8px;
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
        }

        button:hover {
            background-color: #218838;
        }

        .back-button {
            background-color: #007bff;
            margin-top: 10px;
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
        <h1>Add New Supplier</h1>

        <form method="POST" action="">
            <b><label for="supplier_name">Name:</label></b>
            <input type="text" name="supplier_name" id="supplier_name" required>

            <b><label for="contact">Contact:</label></b>
            <input type="text" name="contact" id="contact" required>

            <button type="submit">Add Supplier</button>
        </form>

        <a href="suppliers.php">
            <button class="back-button">Back to Suppliers</button>
        </a>
    </div>
</body>
</html>
