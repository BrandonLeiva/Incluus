<?php

require "../PermisoAdmin.php";

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
    // Datos comunes a todos los tipos de ejercicio
    $nombre_juego = $_POST['nombre_juego'] ?? null;
    $dificultad = $_POST['dificultad'] ?? null;
    $categoria = $_POST['categoria'] ?? null;
    $tipo_ejercicio = $_POST['tipo_ejercicio'] ?? null;
    $id_leccion = $_POST['id_leccion'] ?? null;
    $correcta = $_POST['correcta'] ?? null;

    // Variables para tipos específicos de ejercicio
    $respuesta_a = $_POST['respuesta_a'] ?? null;
    $respuesta_b = $_POST['respuesta_b'] ?? null;
    $respuesta_c = $_POST['respuesta_c'] ?? null;
    $respuesta_d = $_POST['respuesta_d'] ?? null;

    $imagen_a = $_FILES['imagen_a']['name'] ?? null;
    $imagen_b = $_FILES['imagen_b']['name'] ?? null;
    $imagen_c = $_FILES['imagen_c']['name'] ?? null;
    $imagen_d = $_FILES['imagen_d']['name'] ?? null;

    // Validación del tipo de ejercicio
    if ($tipo_ejercicio === "pregunta_respuesta") {
        if (!$respuesta_a || !$respuesta_b || !$respuesta_c || !$respuesta_d || !$correcta) {
            die("Faltan datos para el tipo de ejercicio 'Pregunta y Respuesta'.");
        }

        $sql = "INSERT INTO ejercicio (nombre_juego, dificultad, categoria, tipo_ejercicio, id_leccion, respuesta_a, respuesta_b, respuesta_c, 
        respuesta_d, correcta) VALUES (:nombre_juego, :dificultad, :categoria, :tipo_ejercicio, :id_leccion, :respuesta_a, :respuesta_b, :respuesta_c, 
        :respuesta_d, :correcta)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'nombre_juego' => $nombre_juego,
            'dificultad' => $dificultad,
            'categoria' => $categoria,
            'tipo_ejercicio' => $tipo_ejercicio,
            'id_leccion' => $id_leccion,
            'respuesta_a' => $respuesta_a,
            'respuesta_b' => $respuesta_b,
            'respuesta_c' => $respuesta_c,
            'respuesta_d' => $respuesta_d,
            'correcta' => $correcta,
        ]);

    } elseif ($tipo_ejercicio === "imagen") {
        if (!$imagen_a || !$imagen_b || !$imagen_c || !$imagen_d || !$correcta) {
            die("Faltan datos para el tipo de ejercicio 'Imagen'.");
        }

        // Subir imágenes
        move_uploaded_file($_FILES['imagen_a']['tmp_name'], "../uploads/" . $imagen_a);
        move_uploaded_file($_FILES['imagen_b']['tmp_name'], "../uploads/" . $imagen_b);
        move_uploaded_file($_FILES['imagen_c']['tmp_name'], "../uploads/" . $imagen_c);
        move_uploaded_file($_FILES['imagen_d']['tmp_name'], "../uploads/" . $imagen_d);

        $sql = "INSERT INTO ejercicio (nombre_juego, dificultad, categoria, tipo_ejercicio, id_leccion, imagen_a, imagen_b, imagen_c, 
        imagen_d, correcta) VALUES (:nombre_juego, :dificultad, :categoria, :tipo_ejercicio, :id_leccion, :imagen_a, :imagen_b, :imagen_c, 
        :imagen_d, :correcta)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'nombre_juego' => $nombre_juego,
            'dificultad' => $dificultad,
            'categoria' => $categoria,
            'tipo_ejercicio' => $tipo_ejercicio,
            'id_leccion' => $id_leccion,
            'imagen_a' => $imagen_a,
            'imagen_b' => $imagen_b,
            'imagen_c' => $imagen_c,
            'imagen_d' => $imagen_d,
            'correcta' => $correcta,
        ]);
    } elseif ($tipo_ejercicio === "ordenar") {
        // Validar que las respuestas no estén vacías
        if (!$respuesta_a || !$respuesta_b || !$respuesta_c || !$respuesta_d) {
            die("Faltan datos para el tipo de ejercicio 'Ordenar Elementos'.");
        }
    
        // Insertar en la base de datos
        $sql = "INSERT INTO ejercicio (nombre_juego, dificultad, categoria, tipo_ejercicio, id_leccion, respuesta_a, respuesta_b, respuesta_c, respuesta_d, correcta) 
                VALUES (:nombre_juego, :dificultad, :categoria, :tipo_ejercicio, :id_leccion, :respuesta_a, :respuesta_b, :respuesta_c, :respuesta_d, :correcta)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'nombre_juego' => $nombre_juego,
            'dificultad' => $dificultad,
            'categoria' => $categoria,
            'tipo_ejercicio' => $tipo_ejercicio,
            'id_leccion' => $id_leccion,
            'respuesta_a' => $respuesta_a,
            'respuesta_b' => $respuesta_b,
            'respuesta_c' => $respuesta_c,
            'respuesta_d' => $respuesta_d,
            'correcta' => $correcta,
        ]);
    } else {
        die("Tipo de ejercicio no reconocido.");
    } $mensaje = "Ejercicio creado correctamente.";
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
    <script>
        // Función para filtrar los cursos según la materia seleccionada
        function filtrarCursos() {
            var materiaSeleccionada = document.getElementById("id_materia").value;
            var cursos = document.getElementById("id_curso").getElementsByTagName("option");

            // Mostrar solo los cursos correspondientes a la materia seleccionada
            for (var i = 0; i < cursos.length; i++) {
                if (cursos[i].getAttribute("data-materia") === materiaSeleccionada || cursos[i].value === "") {
                    cursos[i].style.display = "block";
                } else {
                    cursos[i].style.display = "none";
                }
            }

            // Habilitar el select de cursos
            document.getElementById("id_curso").disabled = false;
            // Limpiar la selección de cursos y lecciones
            document.getElementById("id_curso").value = "";
            document.getElementById("id_leccion").value = "";
            document.getElementById("id_leccion").disabled = true;
        }

        // Función para filtrar las lecciones según el curso seleccionado
        function filtrarLecciones() {
            var cursoSeleccionado = document.getElementById("id_curso").value;
            var lecciones = document.getElementById("id_leccion").getElementsByTagName("option");

            // Mostrar solo las lecciones correspondientes al curso seleccionado
            for (var i = 0; i < lecciones.length; i++) {
                if (lecciones[i].getAttribute("data-curso") === cursoSeleccionado || lecciones[i].value === "") {
                    lecciones[i].style.display = "block";
                } else {
                    lecciones[i].style.display = "none";
                }
            }

            // Habilitar el select de lecciones
            document.getElementById("id_leccion").disabled = false;
        }

        function mostrarFormulario() {
            const tipo = document.getElementById("tipo_ejercicio").value;
            const formularios = document.querySelectorAll(".formulario");

            formularios.forEach(formulario => {
                if (formulario.id === "formulario_" + tipo) {
                    // Mostrar y habilitar el formulario seleccionado
                    formulario.style.display = "block";
                    formulario.querySelectorAll("input, select, textarea").forEach(campo => {
                        campo.disabled = false;
                    });
                } else {
                    // Ocultar y deshabilitar los demás formularios
                    formulario.style.display = "none";
                    formulario.querySelectorAll("input, select, textarea").forEach(campo => {
                        campo.disabled = true;
                    });
                }
            });
        }
    </script>
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
                <h2>INGRESE LA PREGUNTA</h2>
                <hr>
                <div id="dashboard">
                    <form action="" method="POST" enctype="multipart/form-data">
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
                        <select name="id_curso" id="id_curso" onchange="filtrarLecciones()" disabled required>
                            <option value="">-- Seleccione un curso --</option>
                            <?php foreach ($cursos as $curso) : ?>
                                <option value="<?php echo $curso['id_curso']; ?>" data-materia="<?php echo $curso['id_materia']; ?>">
                                    <?php echo "Curso " . $curso['nivel']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <!-- Selección de Lección -->
                        <label for="id_leccion">Seleccione una lección:</label>
                        <select name="id_leccion" id="id_leccion" disabled required>
                            <option value="">-- Seleccione una lección --</option>
                            <?php foreach ($lecciones as $leccion) : ?>
                                <option value="<?php echo $leccion['id_leccion']; ?>" data-curso="<?php echo $leccion['id_curso']; ?>">
                                    <?php echo "Lección " . $leccion['numero_leccion']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <br><br>

                        <h1>Ejercicio</h1>

                        <br>

                        <!-- Tipo de ejercicio -->
                        <label for="tipo_ejercicio">Seleccione el tipo de ejercicio:</label>
                        <select id="tipo_ejercicio" name="tipo_ejercicio" onchange="mostrarFormulario()" required>
                            <option value="">-- Seleccione un tipo --</option>
                            <option value="pregunta_respuesta">Pregunta y Respuesta</option>
                            <option value="imagen">Tipo Imagen</option>
                            <option value="ordenar">Ordenar Elementos</option>
                        </select>

                        <!-- Otros campos -->

                        <label for="nombre_juego">Pregunta:</label>
                        <br>
                        <textarea name="nombre_juego" id="" cols="30" rows="10" required></textarea>
                        <br>
                        <label for="dificultad">Dificultad:</label>
                        <input type="text" name="dificultad" required>

                        <label for="categoria">Categoría:</label>
                        <input type="text" name="categoria" required>

                        <!-- Formularios -->
                        <div id="formulario_pregunta_respuesta" class="formulario" style="display: none;">

                            <label>Opciones:</label>
                            <input type="text" name="respuesta_a" placeholder="Opción A" required>
                            <input type="text" name="respuesta_b" placeholder="Opción B" required>
                            <input type="text" name="respuesta_c" placeholder="Opción C" required>
                            <input type="text" name="respuesta_d" placeholder="Opción D" required>

                            <label>Respuesta Correcta:</label>
                            <select name="correcta" required>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>
                        </div>

                        <div id="formulario_imagen" class="formulario" style="display: none;">
                            <label>Subir Imágenes:</label>
                            <br>
                            <input type="file" name="imagen_a" accept="image/*" required>
                            <input type="file" name="imagen_b" accept="image/*" required>
                            <input type="file" name="imagen_c" accept="image/*" required>
                            <input type="file" name="imagen_d" accept="image/*" required>

                            <br>

                            <label>Respuesta Correcta:</label>
                            <select name="correcta" required>
                                <option value="A">Imagen A</option>
                                <option value="B">Imagen B</option>
                                <option value="C">Imagen C</option>
                                <option value="D">Imagen D</option>
                            </select>
                        </div>

                        <div id="formulario_ordenar" class="formulario" style="display: none;">
                            <label>Elementos a ordenar:</label>
                            <div id="ordenar_elementos">
                                <input type="text" name="respuesta_a" placeholder="1°">
                                <input type="text" name="respuesta_b" placeholder="2°">
                                <input type="text" name="respuesta_c" placeholder="3°">
                                <input type="text" name="respuesta_d" placeholder="4°">
                                <input type="text" name="correcta" placeholder="ABCD" value="ABCD" hidden>
                            </div>
                        </div>
                        <br>
                        <button style="border-radius: 10px;" type="submit">Crear Ejercicio</button>
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