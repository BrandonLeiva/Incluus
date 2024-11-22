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

    // Validar que el filtro sea uno de los valores permitidos
    $valoresPermitidos = ['Matemáticas', 'Ciencias', 'Lenguaje'];
    if (!in_array($filtro, $valoresPermitidos)) {
        echo "Filtro no válido.";
        exit;
    }

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

    // Consulta para obtener los cursos según la materia seleccionada
    $stmtCursos = $conn->prepare("SELECT curso.id_curso, curso.nivel, materia.nombre_materia
                                  FROM curso
                                  JOIN materia ON curso.id_materia = materia.id_materia
                                  WHERE materia.nombre_materia = :filtro");
    $stmtCursos->bindParam(':filtro', $filtro, PDO::PARAM_STR);
    $stmtCursos->execute();

    // Obtener todos los cursos
    $cursos = $stmtCursos->fetchAll(PDO::FETCH_ASSOC);

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
    <title>Cursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="cursos.css">
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

<div class="sidebar glass">
  <a href="#" class="sidebar-item ">
    <i class="icon">🏠</i>
    <span>Inicio</span>
  </a>
  <a href="#" class="sidebar-item ">
    <i class="icon">📘</i>
    <span>Lecciones</span>
  </a>
  <a href="#" class="sidebar-item active">
    <i class="icon">📚</i>
    <span>Niveles</span>
  </a>
  <a href="#" class="sidebar-item">
    <i class="icon">👤</i>
    <span>Perfil</span>
  </a>
  <a href="#" class="sidebar-item">
    <i class="icon">⚙️</i>
    <span>Configuración</span>
  </a>
 
</div>



        <!-- Fondo de estrellas -->
        <div class="stars"></div>
    <div class="moving-stars"></div>
    <div class="stars"></div>   

    <div class="moving-stars"></div>
    <div class="stars-2"></div>
    <div class="moving-stars-2"></div>
  
    <div class="stars"></div>
    <div class="moving-stars"></div>
    <div class="stars"></div>  

    <div class="container">
        <div class="row justify-content-center">
            <div class="col" style="max-width: 30rem;">
                <?php
                $offset = 0;
                // Itera sobre los resultados y genera un círculo para cada curso
                if (count($cursos) > 0) {
                    foreach ($cursos as $curso) {
                        ?>
                        <div class="row" style="margin-left: <?= $offset ?>px;">
                            <div class="col">
                            <form action="../interfaz/interfaz.php" method="GET">
                            <input type="hidden" name="materia" value="<?php echo htmlspecialchars($curso['nombre_materia']); ?>">
                            <input type="hidden" name="nivel" value="<?php echo htmlspecialchars($curso['nivel']); ?>">
                                <button class="course-circle btn" onclick="startCourse(<?= $curso['id_curso'] ?>)">
                    
                                    <span class="course-title text">Curso Nivel <?= $curso['nivel'] ?></span>
                                </button>
                
                            </form>
                            </div>
                        </div>
                        <?php
                        $offset += 20; // Incrementa el margen izquierdo para cada fila
                    }
                } else {
                    echo "<p>No hay cursos disponibles para esta materia.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
