<?php
// Incluir la conexión a la base de datos
require '../database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir los datos del formulario
    $rut = trim($_POST['rut']);
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $edad = trim($_POST['edad']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validar que los campos no estén vacíos
    if (empty($rut) || empty($nombre) || empty($apellido)|| empty($edad)|| empty($email)|| empty($password)) {
        echo "Por favor, completa todos los campos.";
        exit;
    }

    // Encriptar la contraseña para mayor seguridad
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    try {
        // Preparar la consulta SQL con marcadores nombrados
        $stmt = $conn->prepare(
            "INSERT INTO usuario (rut, nombre, apellido, edad, correo, rol, password) VALUES (:rut, :nombre, :apellido, :edad ,:email,1 , :password)"
        );

        // Asociar los valores a los marcadores
        $stmt->bindParam(':rut', $rut);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':edad', $edad);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        // Ejecutar la consulta y verificar el resultado
        if ($stmt->execute()) {
           // echo "Registro exitoso. ¡Bienvenido, $nombre!";
            header("Location: ../perfil/perfil.php");
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
