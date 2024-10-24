<?php
// Conexión a la base de datos
session_start();
require '../database.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir los datos del formulario
    $id_materia = $_POST['id_materia'];
    $nivel = $_POST['nivel'];
    $id_usuario = $_SESSION['id_usuario']; 

    // Inserción del curso
    $sql = "INSERT INTO curso (nivel, id_materia, id_usuario) VALUES (:nivel, :id_materia, :id_usuario)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nivel', $nivel);
    $stmt->bindParam(':id_materia', $id_materia);
    $stmt->bindParam(':id_usuario', $id_usuario);

        if ($stmt->execute()) {
            echo "Curso subido con éxito";
        } else {
            echo "Error al subir el curso";
        }
            // Cerrar la conexión (opcional, PDO lo hace automáticamente)
    $conn = null;
}
  
?>