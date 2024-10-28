<?php
$conn = new PDO("mysql:host=localhost;dbname=incluus_app", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Obtener todas las materias
$materias = $conn->query("SELECT * FROM materia")->fetchAll(PDO::FETCH_ASSOC);
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
    <div class="contenedor">
        <header>
            <h1>ADMINISTRADOR (Modificar)</h1>
        </header>
        <div class="contenedor-info">
            <?php include("menu2.php") ?>
            <div class="panel">
                <h2>Modificar Cursos</h2>
                <hr>
                <div id="dashboard">
                    <form method="POST" action="">
                        <!-- Selección de materia -->
                        <label for="id_materia">Seleccione una materia:</label>
                        <select name="id_materia" onchange="this.form.submit()" required>
                            <option value="">-- Seleccione una materia --</option>
                            <?php foreach ($materias as $materia): ?>
                                <option value="<?php echo $materia['id_materia']; ?>">
                                    <?php echo $materia['nombre_materia']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>

                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_materia'])) {
                        $id_materia = $_POST['id_materia'];

                        // Obtener cursos de la materia seleccionada
                        $cursos = $conn->prepare("SELECT * FROM curso WHERE id_materia = :id_materia");
                        $cursos->execute(['id_materia' => $id_materia]);
                        $cursos = $cursos->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                        <form method="POST" action="">
                            <input type="hidden" name="id_materia" value="<?php echo $id_materia; ?>">

                            <label for="id_curso">Seleccione un curso:</label>
                            <select name="id_curso" required>
                                <?php foreach ($cursos as $curso): ?>
                                    <option value="<?php echo $curso['id_curso']; ?>">
                                        <?php echo "Curso nivel " . $curso['nivel']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <label for="nuevo_nivel">Nuevo curso:</label>
                            <input type="number" name="nuevo_nivel" required>

                            <button type="submit">Modificar Curso</button>
                        </form>

                    <?php
                    }
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_curso'])) {
                        $id_curso = $_POST['id_curso'];
                        $nuevo_nivel = $_POST['nuevo_nivel'];

                        $sql = "UPDATE curso SET nivel = :nuevo_nivel WHERE id_curso = :id_curso";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute([
                            'nuevo_nivel' => $nuevo_nivel,
                            'id_curso' => $id_curso
                        ]);

                        echo "Curso actualizado correctamente.";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>