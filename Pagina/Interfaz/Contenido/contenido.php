<?php
require "../../database.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../home/login-register.html");
    exit;
}

// Obtener el id_contenido de la URL o de la sesión
$id_contenido = isset($_GET['id_contenido']) ? (int)$_GET['id_contenido'] : 0;

// Si el id_contenido no es válido, redirigir o mostrar un error
if ($id_contenido <= 0) {
    echo "<p>Contenido no válido.</p>";
    exit;
}


try {
    $stmt = $conn->prepare("SELECT id_contenido, titulo, texto, url_youtube, puntos_minimo, numero_contenido FROM contenido WHERE id_contenido = :id_contenido");
    $stmt->bindParam(':id_contenido', $id_contenido, PDO::PARAM_INT);
    $stmt->execute();
    $contenido = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si no hay contenido con ese id, mostrar un error
    if (!$contenido) {
        echo "<p>No se encontró el contenido.</p>";
        exit;
    }
} catch (PDOException $e) {
    echo "<p>Error al cargar el contenido: " . htmlspecialchars($e->getMessage()) . "</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contenido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="contenido.css">
</head>

<body>
    <div class="container">
        <div class="col">
            <div class="row">
                <h2><?php echo htmlspecialchars($contenido['titulo']); ?></h2>
            </div>
            <br>
            <div class="row">
                <p><?php echo htmlspecialchars($contenido['texto']); ?></p>
            </div>
            <br><br>
            <div class="row">
            <?php if (!empty($contenido['url_youtube'])): ?>
            <iframe src="https://www.youtube.com/embed/<?php echo htmlspecialchars($contenido['url_youtube']); ?>" allowfullscreen></iframe>
        <?php else: ?>
            <p class="no-video">No hay video asociado a este contenido.</p>
        <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="footer">
        <button  onclick="history.back()">Volver</button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
