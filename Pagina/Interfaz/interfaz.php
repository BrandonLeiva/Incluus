<?php
require "../database.php";
session_start(); // Iniciar la sesión para obtener el estado del usuario

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../home/login-register.html");
    exit;
}

try {
    // Consulta para obtener los datos del usuario
    $stmt = $conn->prepare("SELECT correo, nombre, edad, rut, apellido, foto_perfil FROM usuario WHERE id_usuario = :id");
    $stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si se encontraron los datos del usuario
    if (!$user) {
        echo "No se encontraron los datos del usuario.";
        exit;
    }

    // Consulta para obtener las lecciones
    $stmt_lecciones = $conn->prepare("SELECT id_leccion FROM leccion");
    $stmt_lecciones->execute();
    $lecciones = $stmt_lecciones->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col" style="max-width: 30rem;">
                <?php
                $offset = 0;
                // Itera sobre los resultados y genera un círculo para cada lección
                if (count($lecciones) > 0) {
                    foreach ($lecciones as $leccion) {
                        ?>
                        <div class="row" style="margin-left: <?= $offset ?>px;">
                            <div class="col">
                                <div class="lesson-circle" onclick="startLesson('Lección <?= $leccion['id_leccion'] ?>')">
                                    <span class="lesson-number"><?= $leccion['id_leccion'] ?></span>
                                    <span class="lesson-title">Lección <?= $leccion['id_leccion'] ?></span>
                                </div>
                            </div>
                        </div>
                        <?php
                        $offset += 20; // Incrementa el margen izquierdo para cada fila
                    }
                } else {
                    echo "<p>No hay lecciones disponibles.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
