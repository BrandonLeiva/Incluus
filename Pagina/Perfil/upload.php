<?php
// Incluir el archivo con la conexión PDO
require "../database.php";  // Asegúrate de que esta ruta sea correcta

// Verificar si se ha enviado el archivo correctamente
if (isset($_FILES['profile_image'])) {
    $userId = $_POST['user_id'];  // ID del usuario recibido por POST
    $image = $_FILES['profile_image'];

    // Validaciones básicas: Tipo de archivo permitido
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($image['type'], $allowedTypes)) {
        die("Formato de imagen no permitido.");
    }

    // Generar un nombre único para la imagen
    $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
    $newFileName = "perfil_" . $userId . "_" . time() . "." . $ext;

    // Directorio donde se guardarán las imágenes
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);  // Crear el directorio si no existe
    }

    // Mover el archivo subido al directorio de uploads
    $uploadPath = $uploadDir . $newFileName;
    if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
        // Preparar y ejecutar la consulta para actualizar la ruta de la foto
        $sql = "UPDATE usuario SET foto_perfil = :foto WHERE id_usuario = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':foto', $uploadPath);
        $stmt->bindParam(':id', $userId);

        if ($stmt->execute()) {
            echo "Foto de perfil actualizada exitosamente.";
        } else {
            echo "Error al actualizar la foto en la base de datos.";
        }
    } else {
        echo "Error al subir la imagen.";
    }
} else {
    echo "No se ha enviado ninguna imagen.";
}
?>
