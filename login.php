<?php
// Start the session
session_start();

// Include the database configuration file
require 'config.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the username from the POST data
    $username = $_POST['username'];
    // Retrieve the password from the POST data
    $password = $_POST['password'];

    // Prepare a statement to check if the user exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    // Execute the prepared statement with the username
    $stmt->execute([$username]);
    // Fetch the user data
    $user = $stmt->fetch();

    // Check if the user exists
    if ($user) {
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Start a session and store the user's ID and name
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Redirect to index.php after login
            header("Location: index.php");
            exit;
        } else {
            // Output an error message if password verification fails
            echo "Password verification failed.";
        }
    } else {
        // Output an error message if the user is not found
        echo "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
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

        input[type="text"], input[type="password"] {
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
            background-color: #28a745; /* Button color */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #218838; /* Darker button color on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <!-- Display an error message if there is an invalid username or password -->
        <?php if (isset($_GET['error'])): ?>
            <p style="color: red;">Invalid username or password!</p>
        <?php endif; ?>
        <!-- Login form -->
        <form action="login.php" method="POST">
            <!-- Username input field -->
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required><br>
            <!-- Password input field -->
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br>
            <!-- Submit button -->
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
