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
    <h2>Subir un nuevo curso</h2>
    
    <form action="subir_curso.php" method="POST">
        <label for="nivel">Nivel:</label>
        <input type="text" id="nivel" name="nivel" required>
        
        <label for="materia">Materia:</label>
        <select id="materia" name="id_materia" required>
            <!-- Suponiendo que tienes una tabla de materias en tu base de datos -->
            <?php
            $conexion = new mysqli("localhost", "root", "", "incluus");
            $consultaMaterias = "SELECT id_materia, nombre_materia FROM materia";
            $resultadoMaterias = $conexion->query($consultaMaterias);
            
            while ($materia = $resultadoMaterias->fetch_assoc()) {
                echo '<option value="' . $materia['id_materia'] . '">' . htmlspecialchars($materia['nombre_materia']) . '</option>';
            }
            ?>
        </select>

        <button type="submit">Subir Curso</button>
    </form>
</div>
