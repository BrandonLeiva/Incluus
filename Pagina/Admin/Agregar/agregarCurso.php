<?php
// Conexión a la base de datos
$conn = new PDO("mysql:host=localhost;dbname=incluus_app", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Obtener todas las materias para mostrarlas en el formulario
$materias = $conn->query("SELECT * FROM materia")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nivel = $_POST['nivel'];
    $id_materia = $_POST['id_materia']; // Asegurarse de que este valor sea el correcto

    // Insertar el curso en la base de datos
    $sql = "INSERT INTO curso (nivel, id_materia) VALUES (:nivel, :id_materia)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['nivel' => $nivel, 'id_materia' => $id_materia]);

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
    <link rel="stylesheet" href="estilo.css">
    <title>QUIZ GAME</title>
</head>

<body>
    <div class="contenedor">
        <header>
            <h1>ADMINISTRADOR</h1>
        </header>
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

                        <button type="submit">Crear Curso</button>
                        <?php if (!empty($mensaje)): ?>
                            <p style="color: #28a745;"><?php echo $mensaje; ?></p>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>