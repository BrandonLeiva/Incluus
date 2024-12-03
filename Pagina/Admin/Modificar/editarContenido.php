<?php

require "../PermisoAdmin.php";

// Conexión a la base de datos
$conn = new PDO("mysql:host=localhost;dbname=incluus_app", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Obtener materias existentes
$materias = $conn->query("SELECT * FROM materia")->fetchAll(PDO::FETCH_ASSOC);

$mensaje = "";
if (isset($_POST['id_contenido'])) {
    $id_contenido = $_POST['id_contenido'];
    $nuevo_titulo = $_POST['nuevo_titulo'];
    $nuevo_texto = $_POST['nuevo_texto'];
    $nuevo_url_youtube = $_POST['nuevo_url_youtube'];
    $nuevo_puntos_minimo = $_POST['nuevo_puntos_minimo'];
    $nuevo_numero_contenido = $_POST['nuevo_numero_contenido'];

    // Actualizar el contenido en la base de datos
    $sql = "UPDATE contenido 
            SET titulo = :nuevo_titulo,
                texto = :nuevo_texto,
                url_youtube = :nuevo_url_youtube,
                puntos_minimo = :nuevo_puntos_minimo,
                numero_contenido = :nuevo_numero_contenido
            WHERE id_contenido = :id_contenido";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'nuevo_titulo' => $nuevo_titulo,
        'nuevo_texto' => $nuevo_texto,
        'nuevo_url_youtube' => $nuevo_url_youtube,
        'nuevo_puntos_minimo' => $nuevo_puntos_minimo,
        'nuevo_numero_contenido' => $nuevo_numero_contenido,
        'id_contenido' => $id_contenido
    ]);

    $mensaje = "Contenido actualizado correctamente.";
}

if (isset($_POST['id_contenido'])) {
    $id_contenido = $_POST['id_contenido'];
    $contenido = $conn->prepare("SELECT * FROM contenido WHERE id_contenido = :id_contenido");
    $contenido->execute(['id_contenido' => $id_contenido]);
    $contenido = $contenido->fetch(PDO::FETCH_ASSOC);
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
    <title>Perfil de Profesor</title>
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
            <h2>Modificar Contenidos</h2>
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
                // Si se selecciona un curso, mostrar los contenidos relacionados
                if (isset($_POST['id_curso'])) {
                    $id_curso = $_POST['id_curso'];

                    // Obtener los contenidos del curso seleccionado
                    $contenidos = $conn->prepare("SELECT * FROM contenido WHERE id_curso = :id_curso");
                    $contenidos->execute(['id_curso' => $id_curso]);
                    $contenidos = $contenidos->fetchAll(PDO::FETCH_ASSOC);
                ?>

                    <!-- Formulario para seleccionar Contenido -->
                    <form method="POST" action="">
                        <input type="hidden" name="id_materia" value="<?php echo $id_materia; ?>">
                        <input type="hidden" name="id_curso" value="<?php echo $id_curso; ?>">
                        <br>
                        <h2>Seleccione un contenido</h2>
                        <br>
                        <select name="id_contenido" required>
                            <option value="">-- Seleccione un contenido --</option>
                            <?php foreach ($contenidos as $contenido): ?>
                                <option value="<?php echo $contenido['id_contenido']; ?>">
                                    <?php echo $contenido['titulo']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <label for="nuevo_titulo">Nuevo Título de contenido:</label>
                        <input type="text" name="nuevo_titulo" required>

                        <label for="nuevo_texto">Nuevo Texto de contenido:</label>
                        <textarea name="nuevo_texto" required></textarea>

                        <label for="nuevo_url_youtube">Nuevo URL de YouTube:</label>
                        <input type="url" name="nuevo_url_youtube">
                        <br>
                        <label for="nuevo_puntos_minimo">Nuevo Puntos Mínimo:</label>
                        <input type="number" name="nuevo_puntos_minimo" required>

                        <label for="nuevo_numero_contenido">Nuevo Número de Contenido:</label>
                        <input type="number" name="nuevo_numero_contenido" required>

                        <button style="border-radius: 10px;" type="submit">Modificar Contenido</button>
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
