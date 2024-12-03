<?php

require "../PermisoAdmin.php";

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
    <title>Perfil de Profesor</title>
    <link rel="stylesheet" href="verlistado.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Incluye SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
<?php include '../MenuPrincipal.html'; ?>

<!-- Fondo de estrellas -->
<div class="stars"></div>
<div class="moving-stars"></div>
<div class="stars"></div>   

<div class="moving-stars"></div>
<div class="stars-2"></div>
<div class="moving-stars-2"></div>

<div class="stars"></div>
<div class="moving-stars"></div>
<div class="stars"></div>   
    <div class="contenedor">
        <header>
            <h1>ADMINISTRADOR</h1>
        </header>
        <?php include("../submenu.html") ?>
        <div class="contenedor-info">
            <?php include("menu.php") ?>
            <div class="panel">
                <h2>MATERIAS DISPONIBLES</h2>
                <hr>
                <div id="dashboard">
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
                                        <form action="../eliminar/eliminarmateria.php" method="POST" style="display:inline;" onsubmit="return confirmarEliminar(event)">
                                            <input type="hidden" name="eliminar_id" value="<?php echo $materia['id_materia']; ?>">
                                            <button style="border-radius: 15px; padding: 10px;" type="submit">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php else: ?>
                        <p class="mensaje">No hay materias disponibles.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmarEliminar(event) {
            event.preventDefault(); // Evita el envío del formulario inmediato

            Swal.fire({
                title: "Estas seguro?",
                text: "No podras revertir este cambio!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Si, Eliminar!",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Eliminado!",
                        text: "La materia junto a sus relacionados han sido borrados.",
                        icon: "success"
                    }).then(() => {
                        event.target.submit(); // Envía el formulario después de la confirmación
                    });
                }
            });
        }
    </script>
</body>
<footer>
        <p>© 2024 - Incluus. Todos los derechos reservados.</p>
    </footer>
</html>
