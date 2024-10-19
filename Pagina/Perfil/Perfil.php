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
    $stmt = $conn->prepare("SELECT correo, nombre, edad, rut, apellido FROM usuario WHERE id_usuario = :id");
    $stmt->bindParam(':id', $_SESSION['user_id']);
    $stmt->execute();

    // Obtener los datos del usuario
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si se encontraron los datos del usuario
    if (!$user) {
        echo "No se encontraron los datos del usuario.";
        exit;
    }
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
</head>

<body>
    <section class="seccion-perfil-usuario">
        <div class="perfil-usuario-header">
            <div class="perfil-usuario-portada">
                <div class="perfil-usuario-avatar">
                    <img src="" alt="">
                    <button type="button" class="boton-avatar">
                        <i class="far fa-image"></i>
                    </button>
                </div>
                <button type="button" class="boton-portada">
                    <i class="far fa-image"></i> Cambiar fondo
                </button>
            </div>
        </div>
        <div class="perfil-usuario-body">
            <div class="perfil-usuario-bio">
                <h3 class="titulo"><?php echo htmlspecialchars($_SESSION['nombre']); ?></h3>
                <h3 class="titulo"><?php echo htmlspecialchars($_SESSION['apellido']); ?></h3>
                <p class="texto"><?php echo htmlspecialchars($_SESSION['edad']); ?></p>
                <hr>
                <p class="texto"><?php echo htmlspecialchars($_SESSION['email']); ?></p>
                <div class="botonPerfil">
                    <a href="../EditarPerfil/editarPerfil.php"><button>Editar Perfil</button></a>
                </div>
            </div>
            <h1>Continua con tu progreso</h1>   
            <a href="">Más cursos</a>
            <br>
            <div class="perfil-usuario-cursos">
                <div class="encabezado">
                    <h1 class="ramo">Matematicas</h1>
                </div>
                <div class="baner">
                    <img  class="banner" src="img/BannerAzul.png" alt="">   
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
                    <img  class="banner" src="img/BannerRojo.png" alt="">   
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
                    <img  class="banner" src="img/BannerVerde.png" alt="">   
                </div>
                <div class="boton">
                    <button>Continuar</button>
                </div>
            </div>
        </div>
    </section>
    <br><br><br><br><br>
    <footer>
        <p>© 2024 - Incluus. Todos los derechos reservados.</p>
    </footer>
</body>

</html>