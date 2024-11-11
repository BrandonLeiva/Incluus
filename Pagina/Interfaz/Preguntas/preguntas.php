<?php
require "../../database.php";
session_start(); // Iniciar la sesión para obtener el estado del usuario

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../home/login-register.html");
    exit;
}

// Obtener el id de la lección desde la URL
$id_leccion = isset($_GET['id_leccion']) ? intval($_GET['id_leccion']) : null;
if (!$id_leccion) {
    echo "ID de lección no proporcionado.";
    exit;
}

try {
    // Consulta para obtener los datos del usuario
    $stmt = $conn->prepare("SELECT correo, nombre, edad, rut, apellido, foto_perfil FROM usuario WHERE id_usuario = :id");
    $stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "No se encontraron los datos del usuario.";
        exit;
    }

    // Consulta para obtener los ejercicios de la lección específica
    $stmt_ejercicios = $conn->prepare("SELECT ejercicio.id_juego, ejercicio.nombre_juego, ejercicio.respuesta_a, ejercicio.respuesta_b, ejercicio.respuesta_c, ejercicio.respuesta_d, ejercicio.correcta
                                      FROM ejercicio 
                                      WHERE ejercicio.id_leccion = :id_leccion");
    $stmt_ejercicios->bindParam(':id_leccion', $id_leccion, PDO::PARAM_INT);
    $stmt_ejercicios->execute();
    $ejercicios = $stmt_ejercicios->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo "Error en la base de datos. Por favor, inténtelo más tarde.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicios de la Lección</title>
    <link rel="stylesheet" href="preguntas.css">
</head>

<body>
    <div class="barra-progreso">
        <label for="progress-bar"></label>
        <progress id="progress-bar" value="0" max="100"></progress>
    </div>
    <div class="container">
        <?php if (count($ejercicios) > 0): ?>
            <?php foreach ($ejercicios as $index => $ejercicio): ?>
                <div class="pregunta" id="pregunta-<?= $index ?>" style="<?= $index === 0 ? '' : 'display: none;' ?>" data-correcta="<?= htmlspecialchars($ejercicio['correcta']) ?>">
                    <h2><?= htmlspecialchars($ejercicio['nombre_juego']) ?></h2>
                    <div class="container">
                        <div class="respuestas">
                            <button onclick="seleccionarRespuesta('A')">A. <?= htmlspecialchars($ejercicio['respuesta_a']) ?></button>
                            <button onclick="seleccionarRespuesta('B')">B. <?= htmlspecialchars($ejercicio['respuesta_b']) ?></button>
                            <button onclick="seleccionarRespuesta('C')">C. <?= htmlspecialchars($ejercicio['respuesta_c']) ?></button>
                            <button onclick="seleccionarRespuesta('D')">D. <?= htmlspecialchars($ejercicio['respuesta_d']) ?></button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <h1 style="color: #fafafa;">No hay ejercicios disponibles para esta lección.</h1>
        <?php endif; ?>
    </div>

    <div class="footer">
        <button id="boton-comprobar" onclick="comprobarRespuesta()">Comprobar</button>
        <div id="mensaje-respuesta" style="color: #f00; font-weight: bold;"></div> <!-- Contenedor para el mensaje -->
        <button id="boton-saltar" disabled onclick="siguienteEjercicio()">Siguiente</button>
    </div>

    <script>
        let ejercicioActual = 0;
        const totalEjercicios = <?= count($ejercicios) ?>;
        const barraProgreso = document.getElementById('progress-bar');
        let respuestaCorrectaSeleccionada = false;

        function seleccionarRespuesta(opcion) {
            respuestaSeleccionada = opcion; // Guarda la opción seleccionada
            console.log("Opción seleccionada: " + opcion);

            // Deshabilita el botón "Saltar" inicialmente
            const botonSaltar = document.getElementById("boton-saltar");
            botonSaltar.disabled = true;
        }

        function comprobarRespuesta() {
            const mensajeContenedor = document.getElementById("mensaje-respuesta");
            const botonSaltar = document.getElementById("boton-saltar");

            const sonidoCorrecto = new Audio('sonidos/correcto.mp3');
            const sonidoIncorrecto = new Audio('sonidos/incorrecto.mp3');

            if (respuestaSeleccionada === null) {
                mensajeContenedor.textContent = "Por favor, selecciona una respuesta antes de comprobar.";
                return;
            }

            const preguntaActual = document.getElementById(`pregunta-${ejercicioActual}`);
            const respuestaCorrecta = preguntaActual.getAttribute("data-correcta");

            if (respuestaSeleccionada === respuestaCorrecta) {
                mensajeContenedor.style.color = "#28a745"; // Verde para correcto
                mensajeContenedor.textContent = "¡Respuesta correcta!";

                sonidoCorrecto.play();

                // Habilitar el botón "Saltar" y restaurar su color verdadero
                respuestaCorrectaSeleccionada = true;
                botonSaltar.disabled = false;
                botonSaltar.style.backgroundColor = "#28a745"; // Color verdadero al habilitar
                botonSaltar.style.color = "white"; // Color de texto verdadero al habilitar
            } else {
                mensajeContenedor.style.color = "#f00"; // Rojo para incorrecto
                mensajeContenedor.textContent = "Respuesta incorrecta. Inténtalo de nuevo.";

                sonidoIncorrecto.play();

                // Limpiar el mensaje después de un tiempo solo si la respuesta es incorrecta
                setTimeout(() => {
                    mensajeContenedor.textContent = ""; // Limpia el mensaje después de 3 segundos
                }, 3000);
            }
        }

        function siguienteEjercicio() {
            // Solo avanzar si la respuesta correcta ha sido seleccionada y el botón "Saltar" está habilitado
            if (!respuestaCorrectaSeleccionada) return;

            // Ocultar la pregunta actual
            document.getElementById(`pregunta-${ejercicioActual}`).style.display = "none";
            ejercicioActual++;
            respuestaCorrectaSeleccionada = false; // Restablece para la siguiente pregunta

            // Limpiar el mensaje de respuesta
            const mensajeContenedor = document.getElementById("mensaje-respuesta");
            mensajeContenedor.textContent = "";

            if (ejercicioActual < totalEjercicios) {
                // Mostrar la siguiente pregunta
                document.getElementById(`pregunta-${ejercicioActual}`).style.display = "block";

                // Actualizar la barra de progreso
                const progreso = (ejercicioActual / totalEjercicios) * 100;
                barraProgreso.value = progreso;

                // Deshabilitar el botón "Saltar" para la nueva pregunta
                const botonSaltar = document.getElementById("boton-saltar");
                botonSaltar.disabled = true;
                botonSaltar.style.backgroundColor = "#212121"; // Color oscuro al deshabilitar nuevamente
                botonSaltar.style.color = "#666"; // Color del texto al deshabilitar nuevamente
            } else {
                // Rellenar la barra de progreso al 100% y mostrar el mensaje "Lección completada"
                barraProgreso.value = 100;
                document.querySelector(".container").innerHTML = "<h1 style='color: #28a745;'>¡Lección completada!</h1>";

                // Ocultar el botón "Comprobar" y "Saltar" al finalizar
                document.getElementById("boton-comprobar").style.display = "none";
                document.getElementById("boton-saltar").style.display = "none";
            }
        }
    </script>
</body>

</html>