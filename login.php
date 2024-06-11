<?php
// login.php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Database verbinding
        $conn = new mysqli('localhost', 'root', '', 'userdb');

        // Controleer de verbinding
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL statement voorbereiden
        $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            // Wachtwoord controleren
            if (password_verify($password, $hashed_password)) {
                $_SESSION['username'] = $username;
                echo "Login successful! Welcome, " . $username;
                // Redirect naar de dashboardpagina
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No user found with that username.";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Please fill both username and password fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 300px;
            margin: 0 auto;
        }
        input[type=text], input[type=password] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 10px 0;
        }
        input[type=submit] {
            width: 100%;
            padding: 10px;
            background-color: green;
            color: white;
            border: none;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <form method="post" action="">
        Gebruikersnaam: <input type="text" name="username" required><br>
        Wachtwoord: <input type="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>
</div>
</body>
</html>
