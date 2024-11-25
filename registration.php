<?php
// Include the database configuration file
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit;
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    try {
        // Check for duplicate username or email
        $checkStmt = $conn->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
        $checkStmt->bindParam(':username', $username);
        $checkStmt->bindParam(':email', $email);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            echo "<script>alert('Username or email already exists! Please choose another.'); window.history.back();</script>";
            exit;
        }

        // Insert the user into the database
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful!'); window.location.href = 'login.php';</script>";
        } else {
            echo "Registration failed: " . $stmt->errorInfo()[2];
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;  /* Horizontally centers the content */
            align-items: center;      /* Vertically centers the content */
            background-color: #f4f4f4; /* Light background color */
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            box-sizing: border-box;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff; /* Button color */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3; /* Darker button color on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form action="registration.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required><br>
            
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required><br>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" id="confirm_password" required><br>

            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
