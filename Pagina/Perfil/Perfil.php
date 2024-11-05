<?php
require "../database.php";
session_start();  // Iniciar la sesión para obtener el estado del usuario

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    // Si no está logueado, redirigir al login
    header("Location: login.html");
    exit;
}

try {
    // Preparar la consulta SQL para obtener más información del usuario
    $stmt = $conn->prepare("SELECT correo, nombre, edad, rut, apellido, foto_perfil FROM usuario WHERE id_usuario = :id");
    $stmt->bindParam(':id', $_SESSION['user_id']);
    $stmt->execute();

    // Obtener los datos del usuario
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si se encontraron los datos del usuario
    if (!$user) {
        echo "No se encontraron los datos del usuario.";
        exit;
    }
     // Consulta para obtener los cursos (ajusta la tabla y campos según tu estructura)
     $stmtCursos = $conn->prepare("SELECT nombre_materia FROM materia"); // Ajusta 'cursos' y 'nombre_curso' según tu base de datos
     $stmtCursos->execute();
 
     // Obtener todos los cursos
     $cursos = $stmtCursos->fetchAll(PDO::FETCH_ASSOC);
 
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Cerrar la conexión
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <link rel="stylesheet" href="Perfil.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <section class="seccion-perfil-usuario">
        <div class="perfil-usuario-header">
            <div class="perfil-usuario-portada">
                <div class="perfil-usuario-avatar">
                    <img src="<?php echo htmlspecialchars($user['foto_perfil']); ?>" alt="Imagen de perfil del usuario">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="boton-avatar">
                        <i class="far fa-image"></i>
                    </button>
                </div>
                <button type="button" class="boton-portada">
                    <i class="far fa-image"></i> Cambiar fondo
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Cambiar foto de perfil</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="upload.php" method="POST" enctype="multipart/form-data">
                                    <input type="file" name="profile_image" accept="image/*" required><br><br>
                                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>"> <!-- Cambiar al ID del usuario -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <input class="btn btn-primary" type="submit" value="Subir Imagen">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mostrar mensaje de éxito o error dentro de un h1 en un div -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="mensaje-contenedor exito">
                <h1><?= $_SESSION['success_message']; ?></h1>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php elseif (isset($_SESSION['error_message'])): ?>
            <div class="mensaje-contenedor error">
                <h1><?= $_SESSION['error_message']; ?></h1>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <div class="perfil-usuario-body">
            <div class="perfil-usuario-bio">
                <h3 class="titulo"><?php echo htmlspecialchars($_SESSION['nombre'] . ' ' . $_SESSION['apellido']); ?></h3>
                <div class="info">
                    <h5>Edad: </h5>
                    <p class="texto"><?php echo htmlspecialchars($_SESSION['edad']); ?></p>
                    <h5>Correo: </h5>
                    <p class="texto"><?php echo htmlspecialchars($_SESSION['email']); ?></p>
                </div>
                <div class="botonPerfil">
                    <a href="../EditarPerfil/editarPerfil.php"><button>Editar Perfil</button></a>
                </div>
            </div>
            <br>
            <h2>Continua con tu progreso</h2>
            <a href="">Más cursos</a>
            <br>
            <!-- <div class="perfil-usuario-cursos">
                <div class="encabezado">
                    <h1 class="ramo">Matematicas</h1>
                </div>
                <div class="baner">
                    <img class="banner" src="img/BannerAzul.png" alt="">
                </div>
                <div class="boton">
                    <button>Continuar</button>
                </div>
            </div>
            <br>
            <div class="perfil-usuario-cursos">
                <div class="encabezado">
                    <h1 class="ramo">Lenguaje</h1>
                </div>
                <div class="baner">
                    <img class="banner" src="img/BannerRojo.png" alt="">
                </div>
                <div class="boton">
                    <button>Continuar</button>
                </div>
            </div>
            <br>
            
            <div class="perfil-usuario-cursos">
                <div class="encabezado">
                    <h1 class="ramo">Ciencias Sociales</h1>
                </div>
                <div class="baner">
                    <img class="banner" src="img/BannerVerde.png" alt="">
                </div>
                <div class="boton">
                    <button>Continuar</button>
                </div>
            </div> -->
            <?php foreach ($cursos as $curso): ?>
        <div class="perfil-usuario-cursos">
            <div class="encabezado">
                <h1 class="ramo"><?php echo htmlspecialchars($curso['nombre_materia']); ?></h1>
            </div>
            <div class="baner">
                <img class="banner" src="img/BannerAzul.png" alt="">
            </div>
            <div class="boton">
                <button>Continuar</button>
            </div>
        </div>
    <?php endforeach; ?>
        </div>
        
    </section>
    <br><br><br><br><br>
    <footer>
        <p>© 2024 - Incluus. Todos los derechos reservados.</p>
    </footer>

    <!-- Bootstrap JS y Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>