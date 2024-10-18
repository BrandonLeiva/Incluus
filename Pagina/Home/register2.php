<?php
// Incluir la conexión a la base de datos
require '../database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir los datos del formulario
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validar que los campos no estén vacíos
    if (empty($username) || empty($email) || empty($password)) {
        echo "Por favor, completa todos los campos.";
        exit;
    }

    // Encriptar la contraseña para mayor seguridad
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    try {
        // Preparar la consulta SQL con marcadores nombrados
        $stmt = $conn->prepare(
            "INSERT INTO usuarios (username, email, password) VALUES (:username, :email, :password)"
        );

        // Asociar los valores a los marcadores
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        // Ejecutar la consulta y verificar el resultado
        if ($stmt->execute()) {
            echo "Registro exitoso. ¡Bienvenido, $username!";
        } else {
            echo "Error al registrar.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Cerrar la conexión (opcional, PDO lo hace automáticamente)
    $conn = null;
}
?>
