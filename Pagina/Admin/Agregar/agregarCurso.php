<?php

require "../PermisoAdmin.php";
// Conexión a la base de datos
$conn = new PDO("mysql:host=localhost;dbname=incluus_app", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Obtener todas las materias para mostrarlas en el formulario
$materias = $conn->query("SELECT * FROM materia")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nivel = $_POST['nivel'];
    $id_materia = $_POST['id_materia']; 
    $descripcion = $_POST['descripcion'];

    // Insertar el curso en la base de datos
    $sql = "INSERT INTO curso (nivel, id_materia, descripcion) VALUES (:nivel, :id_materia, :descripcion)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['nivel' => $nivel, 'id_materia' => $id_materia, 'descripcion' => $descripcion]);

    $mensaje = "Curso creado correctamente.";
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="estilo.css">
    <title>QUIZ GAME</title>
</head>

<body>
<?php include '../MenuPrincipal.html'; ?>

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
    <div class="contenedor">
    <header>
            <h1>ADMINISTRADOR</h1>
        </header>
        <?php include("../submenu.html") ?>
        <div class="contenedor-info">
            <?php include("menu.php") ?>
            <div class="panel">
                <h2>INGRESE UN CURSO</h2>
                <hr>
                <div id="dashboard">
                    <!-- Formulario para crear un curso -->
                    <form action="" method="POST">
                        <label for="id_materia">Seleccione una materia:</label>
                        <select name="id_materia" required>
                            <?php foreach ($materias as $materia) : ?>
                                <option value="<?php echo $materia['id_materia']; ?>">
                                    <?php echo $materia['nombre_materia']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <label for="nivel">Nivel del curso:</label>
                        <input type="number" name="nivel" required>

                        <label for="descripcion">Descripción del curso:</label>
                        <textarea name="descripcion" id="" cols="30" rows="10"></textarea>

                        <br><br>

                        <button style="border-radius: 10px;" type="submit">Crear Curso</button>
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