<?php

require "../../database.php";
session_start();  // Iniciar la sesión para obtener el estado del usuario

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    // Si no está logueado, redirigir al login
    header("Location: ../home/login-register.php");
    exit;
}

// Si se envía la solicitud de cambio de rol
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = (int) $_SESSION['user_id'];  // Asegurarse de que el ID sea un número entero
    $newRole = '0';  // Establecer el nuevo rol como una cadena '0'

    // Actualizar el campo 'rol' en la base de datos
    $stmt = $conn->prepare("UPDATE usuario SET rol = 0 WHERE id_usuario = ?");
    $stmt->execute([
        'rol' => $rol
    ]);

    if ($stmt->execute()) {
        echo "Rol actualizado con éxito.";
        // Redirigir a una página de éxito o dashboard
        header("Location: ../home/dashboard.php");
        exit;
    } else {
        echo "Error al actualizar el rol.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Pago exitoso</h1>
    <button type="submit">Continuar</button>
</body>
</html>