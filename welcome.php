<?php
session_start();
if (!isset($_SESSION['gebruikersnaam'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<body>
    <h2>Welkom, <?php echo $_SESSION['gebruikersnaam']; ?></h2>
    <p>Dit is een beveiligde pagina.</p>
    <a href="logout.php">Uitloggen</a>
</body>
</html>
