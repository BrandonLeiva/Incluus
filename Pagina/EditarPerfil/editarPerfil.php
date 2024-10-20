<?php
// Incluir la conexión a la base de datos
require '../database.php';
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

try {
    // Obtener los datos actuales del usuario
    $stmt = $conn->prepare("SELECT nombre, apellido, correo, edad FROM usuario WHERE id_usuario = :id");
    $stmt->bindParam(':id', $_SESSION['user_id']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "No se encontraron los datos del usuario.";
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Procesar el formulario cuando se envíe
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $correo = trim($_POST['correo']);
    $edad = trim($_POST['edad']);

    // Validar los campos
    if (empty($nombre) || empty($apellido) || empty($correo) || empty($edad)) {
        echo "Por favor, completa todos los campos.";
    } else {
        try {
            // Actualizar los datos del usuario
            $stmt = $conn->prepare("UPDATE usuario SET nombre = :nombre, apellido = :apellido, correo = :correo, edad = :edad WHERE id_usuario = :id");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':edad', $edad);
            $stmt->bindParam(':id', $_SESSION['user_id']);
            $stmt->execute();

            // Actualizar los datos de la sesión
            $_SESSION['nombre'] = $nombre;
            $_SESSION['email'] = $correo;
            $_SESSION['edad'] = $edad;
            $_SESSION['apellido'] = $apellido;

            // Redirigir a la página de perfil
            header("Location: ../Perfil/perfil.php");
            exit;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>

    <link rel="stylesheet" type="text/css" href="editarPerfil.css">
</head>
<body>
    <div class="main">
    <div class="signup">
    <form action="editarPerfil.php" method="POST">
    <label for="chk" aria-hidden="true">Editar Perfil</label>
    <br>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($user['nombre']); ?>" required><br>

        <input type="text" id="apellido" name="apellido" value="<?php echo htmlspecialchars($user['apellido']); ?>" required><br>

        <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($user['correo']); ?>" required><br>

        <input type="number" id="edad" name="edad" value="<?php echo htmlspecialchars($user['edad']); ?>" required><br>

        <button type="submit">Guardar cambios</button>
        <button><a class="volver" href="../Perfil/Perfil.php">Volver al perfil</a></button>
    </form>
    </div>
    </div>
</body>
</html>
