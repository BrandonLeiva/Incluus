<?php
$conn = new PDO("mysql:host=localhost;dbname=incluus_app", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Obtener todas las materias
$materias = $conn->query("SELECT * FROM materia")->fetchAll(PDO::FETCH_ASSOC);
?>


<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_materia = $_POST['id_materia'];
    $nuevo_nombre = $_POST['nuevo_nombre'];

    $sql = "UPDATE materia SET nombre_materia = :nuevo_nombre WHERE id_materia = :id_materia";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'nuevo_nombre' => $nuevo_nombre,
        'id_materia' => $id_materia
    ]);

    $mensaje = "Materia actualizada correctamente.";
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="estilo.css">
    <title>QUIZ GAME</title>
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
            <h1>ADMINISTRADOR (Modificar)</h1>
        </header>
        <div class="contenedor-info">
            <?php include("menu2.php") ?>
            <div class="panel">
                <h2>Modificar materias</h2>
                <hr>
                <div id="dashboard">
                    <form method="POST" action="">
                        <label for="materia">Seleccione una materia:</label>
                        <select name="id_materia" required>
                            <?php foreach ($materias as $materia): ?>
                                <option value="<?php echo $materia['id_materia']; ?>">
                                    <?php echo $materia['nombre_materia']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <label for="nuevo_nombre">Nuevo nombre:</label>
                        <input type="text" name="nuevo_nombre" required>

                        <button style="border-radius: 10px;" type="submit">Modificar Materia</button>
                        <?php if (!empty($mensaje)): ?>
                                <p style="color: #28a745;"><?php echo $mensaje; ?></p>
                            <?php endif; ?>
                    </form>


                </div>
            </div>
        </div>
    </div>
</body>

<footer>
        <p>© 2024 - Incluus. Todos los derechos reservados.</p>
    </footer>
</html>

