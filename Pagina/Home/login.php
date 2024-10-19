<?php
// Incluir la conexión a la base de datos
require '../database.php';
session_start();  // Iniciar la sesión para guardar el estado del usuario

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir los datos del formulario
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validar que los campos no estén vacíos
    if (empty($email) || empty($password)) {
        echo "Por favor, completa todos los campos.";
        exit;
    }

    try {
        // Preparar la consulta SQL para obtener el usuario
        $stmt = $conn->prepare("SELECT id_usuario, nombre, password FROM usuario WHERE correo = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Verificar si se encontró el usuario
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            // Guardar información del usuario en la sesión
            $_SESSION['user_id'] = $user['id_usuario'];
            $_SESSION['nombre'] = $user['nombre'];

            // Redirigir a la página de bienvenida
            header("Location: welcome.php");
            exit();
        } else {
            echo "Email o contraseña incorrectos.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Cerrar la conexión
    $conn = null;
}
?>