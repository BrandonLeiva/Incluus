<?php
require "../database.php";
session_start();  // Iniciar la sesión para obtener el estado del usuario

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    // Si no está logueado, redirigir al login
    header("Location: login.html");
    exit;
}

try {
    // Preparar la consulta SQL para obtener más información del usuario
    $stmt = $conn->prepare("SELECT correo, nombre, edad, rut, apellido FROM usuario WHERE id_usuario = :id");
    $stmt->bindParam(':id', $_SESSION['user_id']);
    $stmt->execute();

    // Obtener los datos del usuario
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si se encontraron los datos del usuario
    if (!$user) {
        echo "No se encontraron los datos del usuario.";
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Cerrar la conexión
$conn = null;
?>

<link href="subir.css" rel="stylesheet">
<div class="perfil-usuario-body">
    <div class="perfil-usuario-bio">
        <h3 class="titulo"><?php echo htmlspecialchars($_SESSION['nombre'] . ' ' . $_SESSION['apellido']); ?></h3>
        <div class="info">
            <h5>Edad: </h5>
            <p class="texto"><?php echo htmlspecialchars($_SESSION['edad']); ?></p>
            <h5>Correo: </h5>   
            <p class="texto"><?php echo htmlspecialchars($_SESSION['email']); ?></p>
        </div>
    </div>
    <br>
    <h2>Subir un nuevo curso (ADMIN)</h2>
<?php

//conexión a la base de datos
$sql = "SELECT id_materia, nombre_materia FROM materia";
$stmt = $conn->prepare("SELECT id_materia, nombre_materia FROM materia");
$stmt->execute();
$materia = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<form action="subircurso2.php" method="POST">
    <label for="materia">Selecciona una materia:</label>
    <select name="id_materia" id="id_materia">
        <?php foreach ($materia as $materia): ?>
            <option value="<?php echo $materia['id_materia']; ?>">
                <?php echo htmlspecialchars($materia['nombre_materia']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="nivel">Nivel del curso:</label>
    <input type="number" name="nivel" id="nivel" required>

    <input type="submit" value="Subir curso">
</form>

</div>

</div>

