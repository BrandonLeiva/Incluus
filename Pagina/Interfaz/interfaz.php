<?php
require "../database.php";
session_start(); // Iniciar la sesión para obtener el estado del usuario

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../home/login-register.html");
    exit;
}

try {
    // Obtén el valor del filtro desde la URL
    $filtro = isset($_GET['materia']) ? $_GET['materia'] : '';
    $filtroc = isset($_GET['nivel']) ? $_GET['nivel'] : '';

    // Validar que el filtro sea uno de los valores permitidos
    $valoresPermitidos = ['Matemáticas', 'Ciencias', 'Lenguaje'];
    if (!in_array($filtro, $valoresPermitidos)) {
        echo "Filtro no válido.";
        exit;
    }

    // Consulta para obtener los datos del usuario
    $stmt = $conn->prepare("SELECT correo, nombre, edad, rut, apellido, foto_perfil, puntos_totales FROM usuario WHERE id_usuario = :id");
    $stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si se encontraron los datos del usuario
    if (!$user) {
        echo "No se encontraron los datos del usuario.";
        exit;
    }

    // Consulta para obtener las lecciones
    $stmt_lecciones = $conn->prepare("
    SELECT leccion.id_leccion, curso.nivel, materia.nombre_materia, leccion.puntos_minimos
    FROM leccion
    JOIN curso ON leccion.id_curso = curso.id_curso
    JOIN materia ON curso.id_materia = materia.id_materia
    WHERE materia.nombre_materia = :filtro 
      AND curso.nivel = :filtroc 
      AND leccion.puntos_minimos <= (
          SELECT puntos_totales 
          FROM usuario 
          WHERE id_usuario = :id_usuario
      )
");
    $stmt_lecciones->bindParam(':filtro', $filtro, PDO::PARAM_STR);
    $stmt_lecciones->bindParam(':filtroc', $filtroc, PDO::PARAM_STR);
    $stmt_lecciones->bindParam(':id_usuario', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt_lecciones->execute();
    $lecciones = $stmt_lecciones->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage()); // Registrar el error en un log
    echo "Error en la base de datos. Por favor, inténtelo más tarde.";
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

<body class=" d-flex justify-content-center align-items-center vh-100">


    <div class="sidebar glass">
        <a href="../perfil/perfil.php" class="sidebar-item ">
            <i class="icon">🏠</i>
            <span>Inicio</span>
        </a>
        <a href="#" class="sidebar-item active">
            <i class="icon">📘</i>
            <span>Lecciones</span>
        </a>
        <a href="metas.html" class="sidebar-item">
            <i class="icon">📚</i>
            <span>Niveles</span>
        </a>
        <a href="perfil.html" class="sidebar-item">
            <i class="icon">👤</i>
            <span>Perfil</span>
        </a>
        <a href="configuracion.html" class="sidebar-item">
            <i class="icon">⚙️</i>
            <span>Configuración</span>
        </a>

    </div>


    <div class="container">
        <div class="row justify-content-center">

        <div class="card glass">
                <div class="stage">Nivel <?php echo isset($lecciones[0]['nivel']) ? $lecciones[0]['nivel'] : 'Sin nivel'; ?> </div>
                <div class="section">Sección A</div>
            </div>

        </div>
        <div class="row justify-content-center">
            <div class="col" style="max-width: 30rem;">
                <?php
                $offset = 0;
                // Itera sobre los resultados y genera un círculo para cada lección
                if (count($lecciones) > 0) {
                    foreach ($lecciones as $leccion) {
                        $desbloqueado = $leccion['puntos_minimos'] <= $user['puntos_totales'];
                        ?>
                        <div class="row" style="margin-left: <?= $offset ?>px;">
                            <div class="col">
                                <div class="lesson-circle <?= $desbloqueado ? 'btn' : 'blocked' ?>" 
                                     <?= $desbloqueado ? "onclick=\"startLesson({$leccion['id_leccion']})\"" : '' ?>>
                                    <span class="lesson-number text"><?= $leccion['id_leccion'] ?></span>
                                    <span class="lesson-title text">
                                        <?= $desbloqueado ? "Lección {$leccion['id_leccion']}" : "Bloqueada" ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <?php
                        $offset += 20;
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