<?php

require "../PermisoAdmin.php";

try {
    $conn = new PDO("mysql:host=localhost;dbname=incluus_app", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['eliminar_id'])) {
        $eliminar_id = $_POST['eliminar_id'];
        $conn->beginTransaction();

        // Eliminar los ejercicios relacionados
        $sql = "DELETE FROM ejercicio WHERE id_leccion IN (SELECT id_leccion FROM leccion WHERE id_curso IN (SELECT id_curso FROM curso WHERE id_materia = :id_materia))";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id_materia' => $eliminar_id]);

        // Eliminar las lecciones relacionadas
        $sql = "DELETE FROM leccion WHERE id_curso IN (SELECT id_curso FROM curso WHERE id_materia = :id_materia)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id_materia' => $eliminar_id]);

        // Eliminar los cursos relacionados
        $sql = "DELETE FROM curso WHERE id_materia = :id_materia";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id_materia' => $eliminar_id]);

        // Eliminar la materia
        $sql = "DELETE FROM materia WHERE id_materia = :id_materia";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id_materia' => $eliminar_id]);

        $conn->commit();

        // Redirige a la página de éxito
        header("Location: verlistado.php");
        exit();
    } else {
        // Redirige a la página de error si no se recibe un ID válido
        header("Location: error.php");
        exit();
    }
} catch (PDOException $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    // Redirige a la página de error en caso de excepción
    header("Location: error.php");
    exit();
}
?>
