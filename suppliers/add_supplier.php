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
            $stmt = $conn->prepare("INSERT INTO suppliers (supplier_name, contact_info) VALUES (?, ?)");
            $stmt->execute([$name, $contact]);

            // Redirect back to the suppliers page after success
            header('Location: suppliers.php');
            exit;
        } catch (PDOException $e) {
            $error_message = "Error: " . $e->getMessage();
        }
    } else {
        $error_message = "Please fill in all required fields.";
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
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9); /* White with slight transparency */
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #28a745; /* Green button */
            color: white;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-bottom: 10px;
        }

        button:hover {
            background-color: #218838; /* Darker green on hover */
        }

        .back-button {
            background-color: #007bff;
            color: white;
            text-align: center;
            display: inline-block;
            padding: 10px 0;
            border-radius: 5px;
            text-decoration: none;
        }

        .back-button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add New Supplier</h1>
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="supplier_name">Name:</label>
            <input type="text" name="supplier_name" id="supplier_name" required>

            <label for="contact">Contact:</label>
            <input type="text" name="contact" id="contact" required>

            <button type="submit">Add Supplier</button>
        </form>
        <a href="suppliers.php" class="back-button">Back to Suppliers</a>
    </div>
</body>
</html>
