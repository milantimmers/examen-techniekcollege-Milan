<?php
// register.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash het wachtwoord
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Database verbinding
    $conn = new mysqli('localhost', 'root', '', 'userdb');

    // Controleer de verbinding
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Controleer of de gebruikersnaam al bestaat
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Username already taken.";
    } else {
        // SQL statement voorbereiden
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute()) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
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
    <h2>Register</h2>
    <form method="post" action="">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" value="Register">
    </form>
</div>
</body>
</html>
