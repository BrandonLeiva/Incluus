<?php
// Conexión a la base de datos
$conn = new PDO("mysql:host=localhost;dbname=incluus_app", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Obtener todas las materias
$materias = $conn->query("SELECT * FROM materia")->fetchAll(PDO::FETCH_ASSOC);

// Obtener todos los cursos
$cursos = $conn->query("SELECT * FROM curso")->fetchAll(PDO::FETCH_ASSOC);

// Obtener todas las lecciones
$lecciones = $conn->query("SELECT * FROM leccion")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_juego = $_POST['nombre_juego'];
    $dificultad = $_POST['dificultad'];
    $categoria = $_POST['categoria'];
    $id_leccion = $_POST['id_leccion'];
    $pregunta_a = $_POST['pregunta_a'];
    $pregunta_b = $_POST['pregunta_b'];
    $pregunta_c = $_POST['pregunta_c'];
    $pregunta_d = $_POST['pregunta_d'];
    $correcta = $_POST['correcta'];


    // Insertar el ejercicio en la base de datos
    $sql = "INSERT INTO ejercicio (nombre_juego, dificultad, categoria, id_leccion, pregunta_a, pregunta_b, pregunta_c, pregunta_d, correcta) VALUES (:nombre_juego, :dificultad, :categoria, :id_leccion, :pregunta_a, :pregunta_b
    , :pregunta_c, :pregunta_d, :correcta)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'nombre_juego' => $nombre_juego,
        'dificultad' => $dificultad,
        'categoria' => $categoria,
        'id_leccion' => $id_leccion,
        'pregunta_a' => $pregunta_a,
        'pregunta_b' => $pregunta_b,
        'pregunta_c' => $pregunta_c,
        'pregunta_d' => $pregunta_d,
        'correcta' => $correcta,
    ]);

    $mensaje = "Ejercicio creado correctamente.";
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
                <h2>INGRESE LA PREGUNTA</h2>
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
                        <select name="id_curso" id="id_curso" onchange="filtrarLecciones()" required>
                            <option value="">-- Seleccione un curso --</option>
                            <?php foreach ($cursos as $curso) : ?>
                                <option value="<?php echo $curso['id_curso']; ?>" data-materia="<?php echo $curso['id_materia']; ?>">
                                    <?php echo "Curso " . $curso['nivel']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <!-- Selección de Lección -->
                        <label for="id_leccion">Seleccione una lección:</label>
                        <select name="id_leccion" id="id_leccion" required>
                            <option value="">-- Seleccione una lección --</option>
                            <?php foreach ($lecciones as $leccion) : ?>
                                <option value="<?php echo $leccion['id_leccion']; ?>" data-curso="<?php echo $leccion['id_curso']; ?>">
                                    <?php echo "Lección " . $leccion['numero_leccion']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <!-- Otros campos -->
                        <label for="nombre_juego">Pregunta:</label>
                        <textarea  name="nombre_juego" id="" cols="30" rows="10" required ></textarea>

                        <label for="dificultad">Dificultad:</label>
                        <input type="text" name="dificultad" required>

                        <label for="categoria">Categoría:</label>
                        <input type="text" name="categoria" required>

                        <hr>
                        <h1>Respuestas</h1>

                        <label for="Respuesta A">Respuesta A:</label>
                        <input type="text" name="pregunta_a" required>

                        <label for="Respuesta B">Respuesta B:</label>
                        <input type="text" name="pregunta_b" required>

                        <label for="Respuesta C">Respuesta C:</label>
                        <input type="text" name="pregunta_c" required>

                        <label for="Respuesta D">Respuesta D:</label>
                        <input type="text" name="pregunta_d" required>

                        <label for="correcta">Seleccione la respuesta correcta:</label>
                        <select style="width: 50px;" name="correcta" id="correcta" required>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
                        <br>
                        <button type="submit">Crear Ejercicio</button>
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