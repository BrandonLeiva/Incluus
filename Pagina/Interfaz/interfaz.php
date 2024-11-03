<!-- <?php
require "../database.php";
session_start();  // Iniciar la sesión para obtener el estado del usuario

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

// A partir de aquí puedes procesar los datos de $user y $lecciones
?> -->



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecciones</title>
    <!-- Enlace a Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <!-- <div class="container text-center">
        <h1 class="mb-4">Selecciona tu Lección</h1>
        <div class="row justify-content-center gy-3">
   
            <div class="col-6 col-md-3">
                <div class="lesson-circle" onclick="startLesson('Lección 1')">
                    <span class="lesson-number">1</span>
                    <span class="lesson-title">Lección 1</span>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="lesson-circle" onclick="startLesson('Lección 2')">
                    <span class="lesson-number">2</span>
                    <span class="lesson-title">Lección 2</span>
                </div>
            </div>
       
        </div>
    </div> -->

    <!-- 
    <div class="container text-center">
      
        <div class="row justify-content-center gy-3">
      
            <div class="col-6 col-md-3">
                <div class="lesson-circle" onclick="startLesson('Lección 1')">
                    <span class="lesson-number">1</span>
                    <span class="lesson-title">Lección 1</span>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="lesson-circle" onclick="startLesson('Lección 2')">
                    <span class="lesson-number">2</span>
                    <span class="lesson-title">Lección 2</span>
                </div>
            </div>
      
        </div>
    </div> -->


   <div class="container">
    <div class="row justify-content-center">
        <div class="col" style="max-width: 30rem;">
            <!-- Primera fila dentro de la columna -->
            <div class="row offset-row-1">
                <div class="col">
                    <div class="lesson-circle" onclick="startLesson('Lección 1')">
                        <span class="lesson-number">1</span>
                        <span class="lesson-title">Lección 1</span>
                    </div>
                </div>
            </div>
            <!-- Segunda fila dentro de la columna -->
            <div class="row offset-row-2">
                <div class="col">
                    <div class="lesson-circle" onclick="startLesson('Lección 2')">
                        <span class="lesson-number">2</span>
                        <span class="lesson-title">Lección 2</span>
                    </div>
                </div>
            </div>
            <!-- Tercera fila dentro de la columna -->
            <div class="row offset-row-3">
                <div class="col">
                    <div class="lesson-circle" onclick="startLesson('Lección 3')">
                        <span class="lesson-number">3</span>
                        <span class="lesson-title">Lección 3</span>
                    </div>
                </div>
            </div>
            <div class="row offset-row-4">
                <div class="col">
                    <div class="lesson-circle" onclick="startLesson('Lección 3')">
                        <span class="lesson-number">3</span>
                        <span class="lesson-title">Lección 3</span>
                    </div>
                </div>
            </div>
            <div class="row offset-row-5">
                <div class="col">
                    <div class="lesson-circle" onclick="startLesson('Lección 3')">
                        <span class="lesson-number">3</span>
                        <span class="lesson-title">Lección 3</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



    <script src="script.js"></script>
    <!-- Script de Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>