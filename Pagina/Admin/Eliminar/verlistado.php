<?php
// Conexión a la base de datos
$conn = new PDO("mysql:host=localhost;dbname=incluus_app", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Obtener todos los cursos junto con el nombre de la materia correspondiente
$sql = "SELECT * FROM materia"; 
$materias = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de materias</title>
    <link rel="stylesheet" href="verlistado.css">
    <style>
        /* Incluye aquí el CSS del ejemplo anterior */
    </style>
</head>
<body>
    <div class="contenedor">
        <header>
            <h1>Listado de materias</h1>
        </header>
        <div class="panel">
            <?php if (count($materias) > 0): ?>
                <table>
                    <tr>
                        <th>ID Materia</th>
                        <th>Materia</th>
                        <th>Acciones</th>
                    </tr>
                    <?php foreach ($materias as $materia): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($materia['id_materia']); ?></td>
                            <td><?php echo htmlspecialchars($materia['nombre_materia']); ?></td>
                            <td>
                                <!-- Botón de eliminar con enlace a eliminarmateria.php -->
                                <form action="../eliminar/eliminarmateria.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="eliminar_id" value="<?php echo $materia['id_materia']; ?>">
                                    <button type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar este curso?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p class="mensaje">No hay cursos disponibles.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
