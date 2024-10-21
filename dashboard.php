<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first!'); window.location.href = 'login.php';</script>";
    exit;
}

echo "<h1>Welcome to your Dashboard, " . $_SESSION['username'] . "!</h1>";
?>

<a href="logout.php">Logout</a>
