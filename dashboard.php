<?php
// dashboard.php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

echo "Welcome, " . $_SESSION['username'] . "!";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 300px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Dashboard</h2>
    <p>Welcome to your dashboard, <?php echo $_SESSION['username']; ?>!</p>
    <a href="logout.php">Logout</a>
</div>
</body>
</html>
