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
    $stmt_ejercicios = $conn->prepare("SELECT ejercicio.id_juego, ejercicio.nombre_juego, ejercicio.respuesta_a, ejercicio.respuesta_b, ejercicio.respuesta_c, ejercicio.respuesta_d, ejercicio.correcta, ejercicio.imagen_a, ejercicio.imagen_b, ejercicio.imagen_c, ejercicio.imagen_d, tipo_ejercicio
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
<?php
function actualizarPuntosUsuario($conn, $userId, $idLeccion)
{
    try {
        // Obtener puntos de la lección
        $stmt = $conn->prepare("SELECT puntos_leccion FROM leccion WHERE id_leccion = 1");
        $stmt->bindParam(':id_leccion', $idLeccion, PDO::PARAM_INT);
        $stmt->execute();
        $leccion = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($leccion) {
            // Sumar puntos de la lección a los puntos totales del usuario
            $stmt = $conn->prepare("UPDATE usuario SET puntos_totales = puntos_totales + :puntos_leccion WHERE id_usuario = :id_usuario");
            $stmt->bindParam(':puntos_leccion', $leccion['puntos_leccion'], PDO::PARAM_INT);
            $stmt->bindParam(':id_usuario', $userId, PDO::PARAM_INT);
            $stmt->execute();
        }
    } catch (PDOException $e) {
        error_log("Error al actualizar puntos del usuario: " . $e->getMessage());
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicios de la Lección</title>
    <link rel="stylesheet" href="preguntas.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
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
                        <?php if ($ejercicio['tipo_ejercicio'] === 'imagen'): ?>
                            <div class="imagenes">
                                <button class="opcion-imagen" onclick="seleccionarRespuesta('A')"><?= htmlspecialchars($ejercicio['respuesta_a']) ?>
                                    <?php if (!empty($ejercicio['imagen_a'])): ?>
                                        <img src="../../admin/uploads/<?= htmlspecialchars($ejercicio['imagen_a']) ?>" alt="Imagen A">
                                    <?php endif; ?>
                                </button>
                                <button class="opcion-imagen" onclick="seleccionarRespuesta('B')"><?= htmlspecialchars($ejercicio['respuesta_b']) ?>
                                    <?php if (!empty($ejercicio['imagen_b'])): ?>
                                        <img src="../../admin/uploads/<?= htmlspecialchars($ejercicio['imagen_b']) ?>" alt="Imagen B">
                                    <?php endif; ?>
                                </button>
                                <button class="opcion-imagen" onclick="seleccionarRespuesta('C')"><?= htmlspecialchars($ejercicio['respuesta_c']) ?>
                                    <?php if (!empty($ejercicio['imagen_c'])): ?>
                                        <img src="../../admin/uploads/<?= htmlspecialchars($ejercicio['imagen_c']) ?>" alt="Imagen C">
                                    <?php endif; ?>
                                </button>
                                <button class="opcion-imagen" onclick="seleccionarRespuesta('D')"><?= htmlspecialchars($ejercicio['respuesta_d']) ?>
                                    <?php if (!empty($ejercicio['imagen_d'])): ?>
                                        <img src="../../admin/uploads/<?= htmlspecialchars($ejercicio['imagen_d']) ?>" alt="Imagen D">
                                    <?php endif; ?>
                                </button>
                            </div>
                        <?php elseif ($ejercicio['tipo_ejercicio'] === 'ordenar'): ?>
                            <div class="ordenar-container">
                                <ul id="opciones-<?= $index ?>" class="sortable">
                                    <li class="opcion"><span style="display: none;">D.</span><?= htmlspecialchars($ejercicio['respuesta_d']) ?></li>
                                    <li class="opcion"><span style="display: none;">B.</span><?= htmlspecialchars($ejercicio['respuesta_b']) ?></li>
                                    <li class="opcion"><span style="display: none;">A.</span><?= htmlspecialchars($ejercicio['respuesta_a']) ?></li>
                                    <li class="opcion"><span style="display: none;">C.</span><?= htmlspecialchars($ejercicio['respuesta_c']) ?></li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <div class="respuestas">
                                <button onclick="seleccionarRespuesta('A')">A. <?= htmlspecialchars($ejercicio['respuesta_a']) ?></button>
                                <button onclick="seleccionarRespuesta('B')">B. <?= htmlspecialchars($ejercicio['respuesta_b']) ?></button>
                                <button onclick="seleccionarRespuesta('C')">C. <?= htmlspecialchars($ejercicio['respuesta_c']) ?></button>
                                <button onclick="seleccionarRespuesta('D')">D. <?= htmlspecialchars($ejercicio['respuesta_d']) ?></button>
                            </div>
                        <?php endif; ?>
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
        <button style="background-color: #212121; color:#666;" id="boton-saltar" disabled onclick="siguienteEjercicio()">Siguiente</button>
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

            const preguntaActual = document.getElementById(`pregunta-${ejercicioActual}`);
            const tipoEjercicio = preguntaActual.querySelector(".ordenar-container, .imagenes, .respuestas");

            if (tipoEjercicio.classList.contains("ordenar-container")) {
                // Validar el orden en el tipo ordenar
                const opciones = $(`#opciones-${ejercicioActual} .opcion`).map(function() {
                    return $(this).text().trim().charAt(0); // Extrae solo la letra inicial
                }).get().join('');

                const correcta = preguntaActual.getAttribute("data-correcta");

                if (opciones === correcta) {
                    mensajeContenedor.style.color = "#28a745";
                    mensajeContenedor.textContent = "¡Orden correcto!";
                    sonidoCorrecto.play();

                    respuestaCorrectaSeleccionada = true;
                    botonSaltar.disabled = false;
                    botonSaltar.style.backgroundColor = "#28a745"; // Cambio de color a verde
                    botonSaltar.style.color = "white";
                } else {
                    mensajeContenedor.style.color = "#f00";
                    mensajeContenedor.textContent = "Orden incorrecto. Inténtalo nuevamente.";
                    sonidoIncorrecto.play();
                    setTimeout(() => {
                        mensajeContenedor.textContent = "";
                    }, 3000);
                }
            } else {
                // Validar para otros tipos de ejercicios
                if (respuestaSeleccionada === null) {
                    mensajeContenedor.textContent = "Por favor, selecciona una respuesta antes de comprobar.";
                    return;
                }

                const respuestaCorrecta = preguntaActual.getAttribute("data-correcta");

                if (respuestaSeleccionada === respuestaCorrecta) {
                    mensajeContenedor.style.color = "#28a745";
                    mensajeContenedor.textContent = "¡Respuesta correcta!";
                    sonidoCorrecto.play();

                    respuestaCorrectaSeleccionada = true;
                    botonSaltar.disabled = false;
                    botonSaltar.style.backgroundColor = "#28a745"; // Cambio de color a verde
                    botonSaltar.style.color = "white";
                } else {
                    mensajeContenedor.style.color = "#f00";
                    mensajeContenedor.textContent = "Respuesta incorrecta. Inténtalo de nuevo.";
                    sonidoIncorrecto.play();
                    setTimeout(() => {
                        mensajeContenedor.textContent = "";
                    }, 3000);
                }
            }
        }

        function siguienteEjercicio() {
    if (!respuestaCorrectaSeleccionada) return;

    // Ocultar la pregunta actual
    document.getElementById(`pregunta-${ejercicioActual}`).style.display = "none";
    ejercicioActual++;

    // Mostrar la siguiente pregunta, si existe
    if (ejercicioActual < totalEjercicios) {
        document.getElementById(`pregunta-${ejercicioActual}`).style.display = "block";
        barraProgreso.value = (ejercicioActual / totalEjercicios) * 100;
        
        // Restablecer el botón "Siguiente" a su color original
        const botonSaltar = document.getElementById("boton-saltar");
        botonSaltar.disabled = true;
        botonSaltar.style.backgroundColor = "#212121";
        botonSaltar.style.color = "#666"; // Coloca el color #666 para el texto

    } else {
        barraProgreso.value = 100;

        // Cambiar el contenido para mostrar la lección completada
        document.querySelector(".container").innerHTML = `
            <h1 style='color: #28a745;'>¡Lección completada!</h1>
            <button id="boton-continuar" onclick="history.back()">Continuar con las lecciones</button>`;

        // Reproducir el sonido al completar la lección
        const sonidoLeccionCompletada = new Audio('sonidos/completado.mp3');
        sonidoLeccionCompletada.play();

        // Ocultar los botones que ya no son necesarios
        document.getElementById("boton-comprobar").style.display = "none";
        document.getElementById("boton-saltar").style.display = "none";

        // Actualizar los puntos en la base de datos con AJAX
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "actualizarPuntos.php", true); // Ruta relativa aquí
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log("Respuesta del servidor:", xhr.responseText);
            } else if (xhr.readyState === 4) {
                console.error("Error en la solicitud AJAX:", xhr.status, xhr.statusText);
            }
        };

        xhr.send(`id_leccion=${<?= $id_leccion ?>}&id_usuario=${<?= $_SESSION['user_id'] ?>}`);
    }
}

        $(function() {
            $(".sortable").sortable();
            $(".sortable").disableSelection();
        });


        function comprobarOrden(index) {
            const opciones = $(`#opciones-${index} .opcion`).map(function() {
                return $(this).text().trim().charAt(0);
            }).get().join('');

            const correcta = "<?= htmlspecialchars($ejercicio['correcta']) ?>";

            if (opciones === correcta) {
                alert("¡Orden correcto!");
            } else {
                alert("Orden incorrecto. Inténtalo nuevamente.");
            }
        }
    </script>
</body>

</html>