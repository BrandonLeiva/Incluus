<?php

require "../PermisoAdmin.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_materia = $_POST['nombre_materia'];

    try {
        $conn = new PDO("mysql:host=localhost;dbname=incluus_app", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO materia (nombre_materia) VALUES (:nombre_materia)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['nombre_materia' => $nombre_materia]);

        $mensaje = "Materia creada correctamente.";
    } catch (PDOException $e) {
        $mensaje = "Error: " . $e->getMessage();
    }
}
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="estilo.css">
    <title>QUIZ GAME</title>
</head>

<body>
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
    
    
    <?php include '../MenuPrincipal.html'; ?>
    <div class="contenedor">
        <header>
            <h1>ADMINISTRADOR</h1>
        </header>
        <?php include("../submenu.html") ?>
        <div class="contenedor-info">
            <?php include("menu.php") ?>
            <div class="panel">
                <h2>INGRESE UNA MATERIA</h2>
                <hr>
                <div id="dashboard">
                    <form action="" method="POST">
                        <label for="nombre_materia">Nombre de la materia:</label>
                        <input type="text" name="nombre_materia" required>
                        <button style="border-radius: 10px;" type="submit">Crear Materia</button>
                        <?php if (!empty($mensaje)): ?>
                        <p style="color: #28a745;"><?php echo $mensaje; ?></p>
                    <?php endif; ?>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</body>

<footer>
        <p>© 2024 - Incluus. Todos los derechos reservados.</p>
    </footer>

</html>