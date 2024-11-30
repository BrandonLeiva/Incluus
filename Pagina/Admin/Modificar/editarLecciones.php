<?php

require "../PermisoAdmin.php";

// Conexión a la base de datos
$conn = new PDO("mysql:host=localhost;dbname=incluus_app", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Obtener materias existentes
$materias = $conn->query("SELECT * FROM materia")->fetchAll(PDO::FETCH_ASSOC);

$mensaje = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id_leccion']) && isset($_POST['nuevo_numero'])) {
        $id_leccion = $_POST['id_leccion'];
        $nuevo_numero = $_POST['nuevo_numero'];

        // Actualizar la lección en la base de datos
        $sql = "UPDATE leccion SET numero_leccion = :nuevo_numero WHERE id_leccion = :id_leccion";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'nuevo_numero' => $nuevo_numero,
            'id_leccion' => $id_leccion
        ]);

        $mensaje = "Lección actualizada correctamente.";
    }
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
            <h1>ADMINISTRADOR</h1>
        </header>
        <?php include("../submenu.html") ?>
        <div class="contenedor-info">
            <?php include("menu2.php") ?>
            <div class="panel">
                <h2>Modificar lecciones</h2>
                <hr>
                <div id="dashboard">

                    <!-- Formulario para seleccionar Materia -->
                    <form method="POST" action="">
                        <label for="id_materia">Seleccione una Materia:</label>
                        <select name="id_materia" onchange="this.form.submit()" required>
                            <option value="">-- Seleccione una materia --</option>
                            <?php foreach ($materias as $materia): ?>
                                <option value="<?php echo $materia['id_materia']; ?>" <?php if (isset($_POST['id_materia']) && $_POST['id_materia'] == $materia['id_materia']) echo 'selected'; ?>>
                                    <?php echo $materia['nombre_materia']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>

                    <?php
                    // Si se selecciona una materia, mostrar los cursos relacionados
                    if (isset($_POST['id_materia'])) {
                        $id_materia = $_POST['id_materia'];

                        // Obtener los cursos de la materia seleccionada
                        $cursos = $conn->prepare("SELECT * FROM curso WHERE id_materia = :id_materia");
                        $cursos->execute(['id_materia' => $id_materia]);
                        $cursos = $cursos->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                        <!-- Formulario para seleccionar Curso -->
                        <form method="POST" action="">
                            <input type="hidden" name="id_materia" value="<?php echo $id_materia; ?>">

                            <label for="id_curso">Seleccione un curso:</label>
                            <select name="id_curso" onchange="this.form.submit()" required>
                                <option value="">-- Seleccione un curso --</option>
                                <?php foreach ($cursos as $curso): ?>
                                    <option value="<?php echo $curso['id_curso']; ?>" <?php if (isset($_POST['id_curso']) && $_POST['id_curso'] == $curso['id_curso']) echo 'selected'; ?>>
                                        <?php echo "Curso nivel " . $curso['nivel']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </form>

                    <?php
                    }
                    // Si se selecciona un curso, mostrar las lecciones relacionadas
                    if (isset($_POST['id_curso'])) {
                        $id_curso = $_POST['id_curso'];

                        // Obtener las lecciones del curso seleccionado
                        $lecciones = $conn->prepare("SELECT * FROM leccion WHERE id_curso = :id_curso");
                        $lecciones->execute(['id_curso' => $id_curso]);
                        $lecciones = $lecciones->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                        <!-- Formulario para seleccionar Lección -->
                        <form method="POST" action="">
                            <input type="hidden" name="id_materia" value="<?php echo $id_materia; ?>">
                            <input type="hidden" name="id_curso" value="<?php echo $id_curso; ?>">

                            <label for="id_leccion">Seleccione una lección:</label>
                            <select name="id_leccion" required>
                                <option value="">-- Seleccione una lección --</option>
                                <?php foreach ($lecciones as $leccion): ?>
                                    <option value="<?php echo $leccion['id_leccion']; ?>">
                                        <?php echo "Lección " . $leccion['numero_leccion']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <label for="nuevo_numero">Nuevo número de lección:</label>
                            <input type="number" name="nuevo_numero" required>

                            <button style="border-radius: 10px;" type="submit">Modificar Lección</button>
                            <?php if (!empty($mensaje)): ?>
                                <p style="color: #28a745;"><?php echo $mensaje; ?></p>
                            <?php endif; ?>
                        </form>

                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
<footer>
        <p>© 2024 - Incluus. Todos los derechos reservados.</p>
    </footer>
</html>
