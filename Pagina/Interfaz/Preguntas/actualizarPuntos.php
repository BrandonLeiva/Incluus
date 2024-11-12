<?php
require "../../database.php"; 

// Obtener los parámetros enviados en la solicitud AJAX
$id_leccion = isset($_POST['id_leccion']) ? intval($_POST['id_leccion']) : null;
$id_usuario = isset($_POST['id_usuario']) ? intval($_POST['id_usuario']) : null;

if ($id_leccion && $id_usuario) {
    try {
        // Obtener puntos de la lección
        $stmt = $conn->prepare("SELECT puntos_leccion FROM leccion WHERE id_leccion = :id_leccion");
        $stmt->bindParam(':id_leccion', $id_leccion, PDO::PARAM_INT);
        $stmt->execute();
        $leccion = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($leccion) {
            // Actualizar puntos del usuario
            $stmt = $conn->prepare("UPDATE usuario SET puntos_totales = puntos_totales + :puntos_leccion WHERE id_usuario = :id_usuario");
            $stmt->bindParam(':puntos_leccion', $leccion['puntos_leccion'], PDO::PARAM_INT);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->execute();

            echo "Puntos actualizados correctamente.";
        } else {
            echo "No se encontró la lección.";
        }
    } catch (PDOException $e) {
        error_log("Error al actualizar puntos: " . $e->getMessage());
        echo "Error en la base de datos. Por favor, inténtelo más tarde.";
    }
} else {
    echo "Datos incompletos.";
}
?>
