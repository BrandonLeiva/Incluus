<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");  // Redirigir al login si no ha iniciado sesión
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cambiar foto de perfil</title>
</head>
<body>
    <h2>Cambiar Foto de Perfil</h2>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="profile_image" accept="image/*" required><br><br>
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>"> <!-- Cambiar al ID del usuario -->
        <input type="submit" value="Subir Imagen">
    </form>
    <?php echo htmlspecialchars($_SESSION['user_id'] . ' ' . $_SESSION['apellido']); ?>
</body>
</html>
