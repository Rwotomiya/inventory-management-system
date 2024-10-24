<?php
require '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data and check if it's set
    $name = isset($_POST['supplier_name']) ? trim($_POST['supplier_name']) : null;
    $contact = isset($_POST['contact']) ? trim($_POST['contact']) : null;  // Changed 'contact_info' to 'contact'

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
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Please fill in all required fields.";
    }
}
?>


<form method="POST" action="">
    <b><label for="supplier_name">Name:</label></b>
    <input type="text" name="supplier_name" id="supplier_name" required>

    <b><label for="contact">Contact:</label></b>
    <input type="text" name="contact" id="contact" required> <!-- Ensure this matches 'contact' in PHP -->

    <button type="submit">Add Supplier</button>
</form>
