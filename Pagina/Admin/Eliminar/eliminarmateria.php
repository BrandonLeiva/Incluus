<?php
$mensaje = "Error en la eliminación";

try {
    $conn = new PDO("mysql:host=localhost;dbname=incluus_app", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['eliminar_id'])) {
        $eliminar_id = $_POST['eliminar_id'];
        $conn->beginTransaction();

        // Primero, elimina los ejercicios que pertenecen a lecciones que están en el curso que se quiere eliminar
        $sql = "DELETE FROM ejercicio WHERE id_leccion IN (SELECT id_leccion FROM leccion WHERE id_curso IN (SELECT id_curso FROM curso WHERE id_materia = :id_materia))";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id_materia' => $eliminar_id]);

        // Luego, elimina las lecciones que pertenecen al curso que está en la materia que se quiere eliminar
        $sql = "DELETE FROM leccion WHERE id_curso IN (SELECT id_curso FROM curso WHERE id_materia = :id_materia)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id_materia' => $eliminar_id]);

        // Finalmente, elimina los cursos que tienen la materia
        $sql = "DELETE FROM curso WHERE id_materia = :id_materia";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id_materia' => $eliminar_id]);

        // Eliminar la materia
        $sql = "DELETE FROM materia WHERE id_materia = :id_materia";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id_materia' => $eliminar_id]);

        $conn->commit();
        $mensaje = "Materia y registros relacionados eliminados correctamente.";
    } else {
        $mensaje = "No se recibió un ID de materia válido.";
    }
} catch (PDOException $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    $mensaje = "Error en la eliminación: " . $e->getMessage();
}

echo $mensaje;
?>
