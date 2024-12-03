<?php
require "../database.php";
session_start();  // Iniciar la sesión para obtener el estado del usuario

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    // Si no está logueado, redirigir al login
    header("Location: ../home/login-register.php");
    exit;
}



try {
    // Preparar la consulta SQL para obtener más información del usuario
    $stmt = $conn->prepare("SELECT correo, nombre, edad, rut, apellido, foto_perfil, rol FROM usuario WHERE id_usuario = :id");
    $stmt->bindParam(':id', $_SESSION['user_id']);
    $stmt->execute();

    // Obtener los datos del usuario
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si se encontraron los datos del usuario
    if (!$user) {
        echo "No se encontraron los datos del usuario.";
        exit;
    }

    // Guardar el rol en la sesión
    $_SESSION['user_rol'] = $user['rol'];

    // Consulta para obtener los cursos (ajusta la tabla y campos según tu estructura)
    $stmtCursos = $conn->prepare("SELECT nombre_materia FROM materia"); // Ajusta 'cursos' y 'nombre_curso' según tu base de datos
    $stmtCursos->execute();

    // Obtener todos los cursos
    $cursos = $stmtCursos->fetchAll(PDO::FETCH_ASSOC);

    // Verifica si 'foto_perfil' es NULL o está vacía
    $fotoPerfil = !empty($user['foto_perfil']) ? $user['foto_perfil'] : 'img/1053244.png';
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
    <title>Perfil</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <link rel="stylesheet" href="Perfil.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div id="contenido" >
<header>
        <h1 id="h1"><strong>Perfil</strong></h1>
        <p></p>
        <p id="h1">Perfil de usuario</p>
    </header>

    <div class="d-flex justify-content-center ">
    <div class="row bar ">
        <div class="col-3 mision "><a id="nav" href="../Home/home.php">HOME</a></div>
        <div class="col-3 mision"><a id="nav" href="../Ranking/ranking.php">RANKING</a></div>
        <?php if (isset($_SESSION['user_rol']) && $_SESSION['user_rol'] == 0): ?>
            <div class="col-3 mision"><a id="nav" href="../Admin/Agregar/agregarCurso.php">ADMIN</a></div>
        <?php endif; ?>
        <div class="col-3 mision"><a id="nav" onclick="window.location.href='../Home/logout.php'">CERRAR SESIÓN</a></div>
    </div>
</div>


<body>
    <section class="seccion-perfil-usuario ">
        <div class="perfil-usuario-header">
            <div class="perfil-usuario-portada modal-shadow">
                <div class="perfil-usuario-avatar">
                    <img src="<?php echo htmlspecialchars($fotoPerfil); ?>" alt="Imagen de perfil del usuario">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="boton-avatar">
                        <i class="far fa-image"></i>
                    </button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content" id="modal-shadow">
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

        <div class="perfil-usuario-body"  >
            <div class="perfil-usuario-bio" >

            <div class="button-container" >
                    <a href="../home/home.php"><button class="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 1024 1024" stroke-width="0" fill="currentColor" stroke="currentColor" class="icon">
                    <path d="M946.5 505L560.1 118.8l-25.9-25.9a31.5 31.5 0 0 0-44.4 0L77.5 505a63.9 63.9 0 0 0-18.8 46c.4 35.2 29.7 63.3 64.9 63.3h42.5V940h691.8V614.3h43.4c17.1 0 33.2-6.7 45.3-18.8a63.6 63.6 0 0 0 18.7-45.3c0-17-6.7-33.1-18.8-45.2zM568 868H456V664h112v204zm217.9-325.7V868H632V640c0-22.1-17.9-40-40-40H432c-22.1 0-40 17.9-40 40v228H238.1V542.3h-96l370-369.7 23.1 23.1L882 542.3h-96.1z"></path>
                    </svg>
                </button></a>
            </div>
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
            <h2 id="gb">Continua con tu progreso</h2>
            <br>
            <?php foreach ($cursos as $curso): ?>
                <div class="perfil-usuario-cursos">
                    <div class="encabezado">
                        <h1 class="ramo"><?php echo htmlspecialchars($curso['nombre_materia']); ?></h1>
                    </div>
                    <div class="baner">
                        <img class="banner" src="img/matematicas.png" alt="">
                    </div>
                    <form action="../cursos/obtener_c.php" method="GET">
                        <div class="boton">
                            <input type="hidden" name="materia" value="<?php echo htmlspecialchars($curso['nombre_materia']); ?>">
                            <button type="submit" onclick="obtener_c('<?php echo htmlspecialchars($curso['nombre_materia']); ?>')">Continuar</button>
                        </div>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>


        <div class="container-card">
        <div class="card">
            <div class="header">
                <span class="title">ola</span>
                <span class="price">Free</span>
            </div>
            <p class="desc">Etiam ac convallis enim, eget euismod dolor.</p>
            <ul class="lists">
                <li class="list">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>C</span>
                </li>
                <li class="list">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>Morbi semper</span>
                </li>
                <li class="list">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>Tristique enim nec</span>
                </li>
            </ul>
            <button  type="button" class="action"><a href="https://sandbox.flow.cl/btn.php?token=ob244eb12823092a1c72024efcadc8151ceca700">Comprar</a></button>
        </div>
        <div class="card">
            <div class="header">
                <span class="title">ola</span>
                <span class="price">Free</span>
            </div>
            <p class="desc">Etiam ac convallis enim, eget euismod dolor.</p>
            <ul class="lists">
                <li class="list">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>C</span>
                </li>
                <li class="list">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>Morbi semper</span>
                </li>
                <li class="list">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>Tristique enim nec</span>
                </li>
            </ul>
            <button  type="button" class="action"><a href="https://sandbox.flow.cl/btn.php?token=ob244eb12823092a1c72024efcadc8151ceca700">Comprar</a></button>
        </div>
        <div class="card">
            <div class="header">
                <span class="title">ola</span>
                <span class="price">Free</span>
            </div>
            <p class="desc">Etiam ac convallis enim, eget euismod dolor.</p>
            <ul class="lists">
                <li class="list">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>C</span>
                </li>
                <li class="list">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>Morbi semper</span>
                </li>
                <li class="list">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>Tristique enim nec</span>
                </li>
            </ul>
            <button  type="button" class="action"><a href="https://www.mercadopago.cl/subscriptions/checkout?preapproval_plan_id=2c93808493809e5d01938ed97d1f0761" name="MP-payButton" class='blue-ar-l-rn-none'>Suscribirme</a></button>
        </div>
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
    

    </section>
    <br><br><br><br><br>
    <footer>
        <p>© 2024 - Incluus. Todos los derechos reservados.</p>
    </footer>
    </div>

    <script type="text/javascript">
   (function() {
      function $MPC_load() {
         window.$MPC_loaded !== true && (function() {
         var s = document.createElement("script");
         s.type = "text/javascript";
         s.async = true;
         s.src = document.location.protocol + "//secure.mlstatic.com/mptools/render.js";
         var x = document.getElementsByTagName('script')[0];
         x.parentNode.insertBefore(s, x);
         window.$MPC_loaded = true;
      })();
   }
   window.$MPC_loaded !== true ? (window.attachEvent ? window.attachEvent('onload', $MPC_load) : window.addEventListener('load', $MPC_load, false)) : null;
   })();
  /*
        // to receive event with message when closing modal from congrants back to site
        function $MPC_message(event) {
          // onclose modal ->CALLBACK FUNCTION
         // !!!!!!!!FUNCTION_CALLBACK HERE Received message: {event.data} preapproval_id !!!!!!!!
        }
        window.$MPC_loaded !== true ? (window.addEventListener("message", $MPC_message)) : null; 
        */
</script>
    <!-- Bootstrap JS y Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
    <div class="loader" id="preloader"></div>
</body>

</html>