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
    SELECT leccion.id_leccion, leccion.numero_leccion, curso.nivel, materia.nombre_materia, leccion.puntos_minimo
    FROM leccion
    JOIN curso ON leccion.id_curso = curso.id_curso
    JOIN materia ON curso.id_materia = materia.id_materia
    WHERE materia.nombre_materia = :filtro 
      AND curso.nivel = :filtroc 
      AND leccion.puntos_minimo <= (
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

    // Consulta para obtener los contenidos relacionados
    $stmt_contenido = $conn->prepare("
    SELECT contenido.id_contenido, contenido.titulo, contenido.texto, contenido.url_youtube, contenido.puntos_minimo, contenido.numero_contenido, curso.nivel, materia.nombre_materia
    FROM contenido
    JOIN curso ON contenido.id_curso = curso.id_curso
    JOIN materia ON curso.id_materia = materia.id_materia
    WHERE materia.nombre_materia = :filtro 
      AND curso.nivel = :filtroc
      AND contenido.puntos_minimo <= (
          SELECT puntos_totales 
          FROM usuario 
          WHERE id_usuario = :id_usuario
      )
      
");
    $stmt_contenido->bindParam(':filtro', $filtro, PDO::PARAM_STR);
    $stmt_contenido->bindParam(':filtroc', $filtroc, PDO::PARAM_STR);
    $stmt_contenido->bindParam(':id_usuario', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt_contenido->execute();
    $contenidos = $stmt_contenido->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage()); // Registrar el error en un log
    echo "Error en la base de datos. Por favor, inténtelo más tarde.";
    exit;
}

// Combina las lecciones y contenidos en un solo array
$items = [];

// Agregar las lecciones
foreach ($lecciones as $leccion) {
    $items[] = [
        'id' => $leccion['id_leccion'],
        'tipo' => 'leccion',
        'nivel' => $leccion['nivel'],
        'nombre_materia' => $leccion['nombre_materia'],
        'puntos_minimo' => $leccion['puntos_minimo'],
        'numero' => $leccion['numero_leccion'],
    ];
}

// Agregar los contenidos
foreach ($contenidos as $contenido) {
    $items[] = [
        'id' => $contenido['id_contenido'],
        'tipo' => 'contenido',
        'nivel' => $contenido['nivel'],
        'nombre_materia' => $contenido['nombre_materia'],
        'puntos_minimo' => $contenido['puntos_minimo'],
        'numero' => $contenido['numero_contenido'],
    ];
}

// Ordena el array combinado por nombre de materia y número
usort($items, function ($a, $b) {
    // Primero ordena por materia, luego por número de lección o contenido
    if ($a['nombre_materia'] === $b['nombre_materia']) {
        return $a['numero'] - $b['numero'];
    }
    return strcmp($a['nombre_materia'], $b['nombre_materia']);
});
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecciones y Contenidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body class="d-flex justify-content-center align-items-center vh-100">

    <div class="sidebar glass">
        <a href="../perfil/perfil.php" class="sidebar-item ">
            <i class="icon">🏠</i>
            <span>Inicio</span>
        </a>
        <a href="#" class="sidebar-item active">
            <i class="icon">📘</i>
            <span>Lecciones</span>
        </a>
        <a href="#" class="sidebar-item">
            <i class="icon">📚</i>
            <span>Niveles</span>
        </a>
        <a href="#" class="sidebar-item">
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
                $offset = 0;  // Para desplazar los círculos si es necesario
                // Iterar sobre los items combinados
                if (count($items) > 0) {
                    foreach ($items as $item) {
                        $desbloqueado = $item['puntos_minimo'] <= $user['puntos_totales'];
                        $titulo = $item['tipo'] === 'leccion' ? "Lección {$item['numero']}" : "Contenido {$item['numero']}";
                ?>
                        <div class="row" style="margin-left: <?= $offset ?>px;">
                            <div class="col">
                                <div class="lesson-circle <?= $desbloqueado ? 'btn' . ($item['tipo'] === 'contenido' ? ' btn-contenido' : '') : 'blocked' ?>"
                                    <?= $desbloqueado ? "onclick=\"" . ($item['tipo'] === 'contenido' ? "startContent({$item['id']})" : "startLesson({$item['id']})") . "\"" : '' ?>>
                                    <span class="lesson-number text"><?= $item['numero'] ?></span>
                                    <span class="lesson-title text"><?= $desbloqueado ? $titulo : "Bloqueada" ?></span>
                                </div>
                            </div>
                        </div>
                <?php
                        $offset += 20; // Aumentar desplazamiento para la siguiente fila
                    }
                } else {
                    echo "<p>No hay lecciones o contenidos disponibles.</p>";
                }
                ?>
            </div>
        </div>
    </div>
    

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>