<?php
// Conexión a la base de datos
$conn = new PDO("mysql:host=localhost;dbname=incluus_app", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Obtener materias existentes
$materias = $conn->query("SELECT * FROM materia")->fetchAll(PDO::FETCH_ASSOC);

// Obtener todos los cursos (se filtrarán después según la materia seleccionada)
$cursos = $conn->query("SELECT * FROM curso")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $numero_leccion = $_POST['numero_leccion'];
    $puntos_leccion = $_POST['puntos_leccion'];
    $id_curso = $_POST['id_curso'];

    // Insertar la lección
    $sql = "INSERT INTO leccion (numero_leccion, puntos_leccion, id_curso) VALUES (:numero_leccion, :puntos_leccion, :id_curso)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'numero_leccion' => $numero_leccion,
        'puntos_leccion' => $puntos_leccion,
        'id_curso' => $id_curso
    ]);

    $mensaje = "Lección creada correctamente.";
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
        <div class="contenedor-info">
            <?php include("menu.php") ?>
            <div class="panel">
                <h2>INGRESE UNA LECCIÓN</h2>
                <hr>
                <div id="dashboard">
                    <form action="" method="POST">
                        <!-- Selección de Materia -->
                        <label for="id_materia">Seleccione una materia:</label>
                        <select name="id_materia" id="id_materia" onchange="filtrarCursos()" required>
                            <option value="">-- Seleccione una materia --</option>
                            <?php foreach ($materias as $materia) : ?>
                                <option value="<?php echo $materia['id_materia']; ?>">
                                    <?php echo $materia['nombre_materia']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <!-- Selección de Curso -->
                        <label for="id_curso">Seleccione un curso:</label>
                        <select name="id_curso" id="id_curso" required>
                            <option value="">-- Seleccione un curso --</option>
                            <?php foreach ($cursos as $curso) : ?>
                                <option value="<?php echo $curso['id_curso']; ?>" data-materia="<?php echo $curso['id_materia']; ?>">
                                    <?php echo "Curso " . $curso['nivel']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <!-- Otros campos -->
                        <label for="numero_leccion">Número de la lección:</label>
                        <input type="number" name="numero_leccion" required>
                        <label for="puntos_leccion">Puntos de la lección:</label>
                        <input type="number" name="puntos_leccion" required>

                        <button style="border-radius: 10px;" type="submit">Crear Lección</button>
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

<script src="agregarLeccion.js"></script>

</html>