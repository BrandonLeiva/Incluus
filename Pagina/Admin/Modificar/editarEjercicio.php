<?php

require "../PermisoAdmin.php";

// Conexión a la base de datos
$conn = new PDO("mysql:host=localhost;dbname=incluus_app", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Obtener materias existentes
$materias = $conn->query("SELECT * FROM materia")->fetchAll(PDO::FETCH_ASSOC);

// Obtener todos los cursos (se filtrarán después según la materia seleccionada)
$cursos = $conn->query("SELECT * FROM curso")->fetchAll(PDO::FETCH_ASSOC);

// Obtener todas las lecciones
$lecciones = $conn->query("SELECT * FROM leccion")->fetchAll(PDO::FETCH_ASSOC);

$ejercicio_actual = null; // Variable para almacenar el ejercicio actual
?>

<?php
// Procesar las solicitudes de selección de materia, curso, lección y ejercicio
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id_materia'])) {
        $id_materia = $_POST['id_materia'];
        // Obtener los cursos de la materia seleccionada
        $cursos = $conn->prepare("SELECT * FROM curso WHERE id_materia = :id_materia");
        $cursos->execute(['id_materia' => $id_materia]);
        $cursos = $cursos->fetchAll(PDO::FETCH_ASSOC);
    }
    if (isset($_POST['id_curso'])) {
        $id_curso = $_POST['id_curso'];
        // Obtener las lecciones del curso seleccionado
        $lecciones = $conn->prepare("SELECT * FROM leccion WHERE id_curso = :id_curso");
        $lecciones->execute(['id_curso' => $id_curso]);
        $lecciones = $lecciones->fetchAll(PDO::FETCH_ASSOC);
    }
    if (isset($_POST['id_leccion'])) {
        $id_leccion = $_POST['id_leccion'];
        // Obtener los ejercicios de la lección seleccionada
        $ejercicios = $conn->prepare("SELECT * FROM ejercicio WHERE id_leccion = :id_leccion");
        $ejercicios->execute(['id_leccion' => $id_leccion]);
        $ejercicios = $ejercicios->fetchAll(PDO::FETCH_ASSOC);
    }
    if (isset($_POST['id_ejercicio'])) {
        $id_ejercicio = $_POST['id_ejercicio'];
        // Obtener los datos del ejercicio seleccionado
        $stmt = $conn->prepare("SELECT * FROM ejercicio WHERE id_juego = :id_ejercicio");
        $stmt->execute(['id_ejercicio' => $id_ejercicio]);
        $ejercicio_actual = $stmt->fetch(PDO::FETCH_ASSOC);

        // Actualizar el ejercicio si se enviaron datos para modificarlo
        if (isset($_POST['nuevo_nombre_juego'])) {
            $nuevo_nombre_juego = $_POST['nuevo_nombre_juego'];
            $nueva_dificultad = $_POST['nueva_dificultad'];
            $nueva_categoria = $_POST['nueva_categoria'];
            $respuesta_a = $_POST['respuesta_a'];
            $respuesta_b = $_POST['respuesta_b'];
            $respuesta_c = $_POST['respuesta_c'];
            $respuesta_d = $_POST['respuesta_d'];
            $correcta = $_POST['correcta'];

            // Actualizar en la base de datos
            $sql = "UPDATE ejercicio SET nombre_juego = :nuevo_nombre_juego, dificultad = :nueva_dificultad, categoria = :nueva_categoria, respuesta_a = :respuesta_a, respuesta_b = :respuesta_b, respuesta_c = :respuesta_c, respuesta_d = :respuesta_d, correcta = :correcta WHERE id_juego = :id_ejercicio";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'nuevo_nombre_juego' => $nuevo_nombre_juego,
                'nueva_dificultad' => $nueva_dificultad,
                'nueva_categoria' => $nueva_categoria,
                'id_ejercicio' => $id_ejercicio,
                'respuesta_a' => $respuesta_a,
                'respuesta_b' => $respuesta_b,
                'respuesta_c' => $respuesta_c,
                'respuesta_d' => $respuesta_d,
                'correcta' => $correcta
            ]);

            $mensaje = "Ejercicio actualizado correctamente.";
        }
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
            <h1>ADMINISTRADOR (Modificar)</h1>
        </header>
        <div class="contenedor-info">
            <?php include("menu2.php") ?>
            <div class="panel">
                <h2>Modificar ejercicio</h2>
                <hr>
                <div id="dashboard">
                    <!-- Formulario para seleccionar Materia -->
                    <form method="POST" action="">
                        <label for="id_materia">Seleccione una Materia:</label>
                        <select name="id_materia" onchange="this.form.submit()" required>
                            <option value="">-- Seleccione una materia --</option>
                            <?php foreach ($materias as $materia): ?>
                                <option value="<?php echo $materia['id_materia']; ?>" <?php if (isset($id_materia) && $id_materia == $materia['id_materia']) echo 'selected'; ?>>
                                    <?php echo $materia['nombre_materia']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>

                    <!-- Formulario para seleccionar Curso (solo se muestra si se ha seleccionado una Materia) -->
                    <?php if (isset($id_materia) && isset($cursos)): ?>
                        <form method="POST" action="">
                            <input type="hidden" name="id_materia" value="<?php echo $id_materia; ?>">
                            <label for="id_curso">Seleccione un Curso:</label>
                            <select name="id_curso" onchange="this.form.submit()" required>
                                <option value="">-- Seleccione un curso --</option>
                                <?php foreach ($cursos as $curso): ?>
                                    <option value="<?php echo $curso['id_curso']; ?>" <?php if (isset($id_curso) && $id_curso == $curso['id_curso']) echo 'selected'; ?>>
                                        <?php echo "Curso nivel " . $curso['nivel']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    <?php endif; ?>

                    <!-- Formulario para seleccionar Lección (solo se muestra si se ha seleccionado un Curso) -->
                    <?php if (isset($id_curso) && isset($lecciones)): ?>
                        <form method="POST" action="">
                            <input type="hidden" name="id_materia" value="<?php echo $id_materia; ?>">
                            <input type="hidden" name="id_curso" value="<?php echo $id_curso; ?>">
                            <label for="id_leccion">Seleccione una Lección:</label>
                            <select name="id_leccion" onchange="this.form.submit()" required>
                                <option value="">-- Seleccione una lección --</option>
                                <?php foreach ($lecciones as $leccion): ?>
                                    <option value="<?php echo $leccion['id_leccion']; ?>" <?php if (isset($id_leccion) && $id_leccion == $leccion['id_leccion']) echo 'selected'; ?>>
                                        <?php echo "Lección " . $leccion['numero_leccion']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    <?php endif; ?>

                    <!-- Formulario para seleccionar Ejercicio (solo se muestra si se ha seleccionado una Lección) -->
                    <?php if (isset($id_leccion) && isset($ejercicios)): ?>
                        <form method="POST" action="">
                            <input type="hidden" name="id_materia" value="<?php echo $id_materia; ?>">
                            <input type="hidden" name="id_curso" value="<?php echo $id_curso; ?>">
                            <input type="hidden" name="id_leccion" value="<?php echo $id_leccion; ?>">

                            <label for="id_ejercicio">Seleccione un Ejercicio:</label>
                            <select name="id_ejercicio" onchange="this.form.submit()" required>
                                <option value="">-- Seleccione un ejercicio --</option>
                                <?php foreach ($ejercicios as $ejercicio): ?>
                                    <option value="<?php echo $ejercicio['id_juego']; ?>" <?php if ($ejercicio_actual && $ejercicio['id_juego'] == $ejercicio_actual['id_juego']) echo 'selected'; ?>>
                                        <?php echo $ejercicio['nombre_juego']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    <?php endif; ?>

                    <!-- Formulario para modificar Ejercicio (si se ha seleccionado un ejercicio) -->
                    <?php if ($ejercicio_actual): ?>

                            
                            <h1>Ejercicio</h1>
                        <form method="POST" action="">
                            <input type="hidden" name="id_ejercicio" value="<?php echo $ejercicio_actual['id_juego']; ?>">
                            <label for="nuevo_nombre_juego">Nuevo nombre del juego:</label>
                            <input type="text" name="nuevo_nombre_juego" value="<?php echo $ejercicio_actual['nombre_juego']; ?>" required>

                            <label for="nueva_dificultad">Nueva dificultad:</label>
                            <input type="text" name="nueva_dificultad" value="<?php echo $ejercicio_actual['dificultad']; ?>" required>

                            <label for="nueva_categoria">Nueva categoría:</label>
                            <input type="text" name="nueva_categoria" value="<?php echo $ejercicio_actual['categoria']; ?>" required>

                            
                            <h1>Respuestas</h1>

                            <label for="respuesta_a">Respuesta A:</label>
                            <input type="text" name="respuesta_a" value="<?php echo $ejercicio_actual['respuesta_a']; ?>" required>

                            <label for="respuesta_b">Respuesta B:</label>
                            <input type="text" name="respuesta_b" value="<?php echo $ejercicio_actual['respuesta_b']; ?>" required>

                            <label for="respuesta_c">Respuesta C:</label>
                            <input type="text" name="respuesta_c" value="<?php echo $ejercicio_actual['respuesta_c']; ?>" required>

                            <label for="respuesta_d">Respuesta D:</label>
                            <input type="text" name="respuesta_d" value="<?php echo $ejercicio_actual['respuesta_d']; ?>" required>

                            <label for="correcta">Seleccione la respuesta correcta:</label>
                            <select name="correcta" required>
                                <option value="A" <?php if ($ejercicio_actual['correcta'] == 'A') echo 'selected'; ?>>A</option>
                                <option value="B" <?php if ($ejercicio_actual['correcta'] == 'B') echo 'selected'; ?>>B</option>
                                <option value="C" <?php if ($ejercicio_actual['correcta'] == 'C') echo 'selected'; ?>>C</option>
                                <option value="D" <?php if ($ejercicio_actual['correcta'] == 'D') echo 'selected'; ?>>D</option>
                            </select>
                            <br>

                            <button style="border-radius: 10px;" type="submit">Modificar Ejercicio</button>
                            <?php if (!empty($mensaje)): ?>
                                <p style="color: #28a745;"><?php echo $mensaje; ?></p>
                            <?php endif; ?>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
<footer>
        <p>© 2024 - Incluus. Todos los derechos reservados.</p>
    </footer>
</html>