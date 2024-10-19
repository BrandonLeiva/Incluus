<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");  // Redirigir al login si no ha iniciado sesión
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
</head>
<body>
    <h1>¡Hola, <?php echo htmlspecialchars($_SESSION['nombre']); ?>!</h1>
    <p>Bienvenido a tu dashboard.</p>
    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>
