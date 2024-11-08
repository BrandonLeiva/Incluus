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
    <div class="container">
        <?php if (count($ejercicios) > 0): ?>
            <?php foreach ($ejercicios as $index => $ejercicio): ?>
                <div class="pregunta" id="pregunta-<?= $index ?>" style="<?= $index === 0 ? '' : 'display: none;' ?>">
                    <h2><?= htmlspecialchars($ejercicio['nombre_juego']) ?></h2>
                    <div class="respuestas">
                        <button onclick="seleccionarRespuesta('A')">A. <?= htmlspecialchars($ejercicio['respuesta_a']) ?></button>
                        <button onclick="seleccionarRespuesta('B')">B. <?= htmlspecialchars($ejercicio['respuesta_b']) ?></button>
                        <button onclick="seleccionarRespuesta('C')">C. <?= htmlspecialchars($ejercicio['respuesta_c']) ?></button>
                        <button onclick="seleccionarRespuesta('D')">D. <?= htmlspecialchars($ejercicio['respuesta_d']) ?></button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <h1 style="color: #fafafa;">No hay ejercicios disponibles para esta lección.</h1>
        <?php endif; ?>
    </div>

    <div class="footer">
        <button onclick="siguienteEjercicio()">Saltar</button>
        <button onclick="siguienteEjercicio()">Comprobar</button>
    </div>

    <script>
        let ejercicioActual = 0;
        const totalEjercicios = <?= count($ejercicios) ?>;

        function siguienteEjercicio() {
            document.getElementById(`pregunta-${ejercicioActual}`).style.display = "none";
            ejercicioActual++;

            if (ejercicioActual < totalEjercicios) {
                document.getElementById(`pregunta-${ejercicioActual}`).style.display = "block";
            } else {
                alert("¡Has completado todos los ejercicios!");
            }
        }

        function seleccionarRespuesta(opcion) {
            console.log("Opción seleccionada: " + opcion);
        }
    </script>
</body>

</html>
