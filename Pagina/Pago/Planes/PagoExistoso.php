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
    $newRole = 0;  // Establecer el nuevo rol como 0 (numérico)

    try {
        // Preparar la consulta de actualización
        $stmt = $conn->prepare("UPDATE usuario SET rol = :rol WHERE id_usuario = :id");
        $stmt->bindParam(':rol', $newRole, PDO::PARAM_INT);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Rol actualizado con éxito.";
            // Redirigir a una página de éxito o dashboard
            header("Location: ../../perfil/perfil.php");
            exit;
        } else {
            echo "Error al actualizar el rol.";
        }
    } catch (PDOException $e) {
        // Manejo de errores
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago exitoso</title>
</head>
<body>
    <h1>Pago exitoso</h1>

    <!-- Formulario para enviar la solicitud de cambio de rol -->
    <form method="POST" action="">
        <button type="submit">Continuar</button>
    </form>
</body>
</html>
