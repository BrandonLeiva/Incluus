<?php
require "../database.php";
session_start();

// Consulta para obtener los usuarios
$sql = "SELECT * FROM usuario ORDER BY puntos_totales DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();


$logged_in_user_id = $_SESSION['user_id']; // Asume que el ID del usuario logueado se almacena en $_SESSION['user_id']
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ranking.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Ranking</title>
</head>

<body>
    <header>
        <h1 id="h1"><strong>Ranking</strong></h1>
        <p></p>
        <p id="h1">Listado de usuarios que participan en incluus</p>
    </header>

    <div class=" d-flex justify-content-center ">
        <div class="row bar ">
            <div class="col-3 mision "><a id="nav" href="../Perfil/Perfil.php">PERFIL</a></div>
            <div class="col-3 mision"><a id="nav" href="../Ranking/ranking.php">RANKING</a></div>
            <?php if (isset($_SESSION['user_rol']) && $_SESSION['user_rol'] == 0 || $_SESSION['user_rol'] == 2): ?>
                <div class="col-3 mision"><a id="nav" href="../Admin/Agregar/agregarCurso.php">ADMIN</a></div>
            <?php endif; ?>
            <div class="col-3 mision"><a id="nav" onclick="window.location.href='../Home/logout.php'">CERRAR SESIÓN</a></div>
        </div>
    </div>

    <div class="fade-in">
        <section class="w-50 mx-auto text-center pt-5">
            <h1 class="p-3 fs-2 border-top border-3 pt-5" id="h1">Sube en el <span style="color: #5a67d8;">ranking</span>, demuestra tu progreso.</h1>
            <p class="p-3 fs-4" id="h1" style="color: #ffffff93;">Compite con otros usuarios mientras aprendes y mejoras tus habilidades. Gana puntos, escala posiciones y destaca en la comunidad.
                <br> <span style="color:#5a67d8;">¡Conviértete en el mejor y supera tus metas!</span>
            </p>
        </section>
    </div>

    <BR></BR>
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

    <!--=========================================-->
    <!--CONTENIDO-->
    <!--=========================================-->
    <div class="container">
        <!-- Pestañas -->
        <div class="tabs">
            <div class="tab active" onclick="showTab('matematicas')">
                Matemáticas
            </div>
            <div class="tab" onclick="showTab('lenguaje')">Lenguaje</div>
            <div class="tab" onclick="showTab('ciencias')">Ciencias</div>
        </div>

        <!-- Contenido de cada pestaña -->
        <div id="matematicas" class="content active">
            <table>
                <thead>
                    <tr>
                        <th style="width: 120px;">Posición</th>
                        <th>Estudiante</th>
                        <th>Rol</th>
                        <th>Edad</th>
                        <th>Puntos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($stmt->rowCount() > 0) {
                        $position = 1;
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $highlight_class = ($row['id_usuario'] == $logged_in_user_id) ? 'usuario-logeado' : '';
                            echo "<tr class='$highlight_class'>";
                            echo "<td class='lugar' data-label='Posición'>";
                            if ($position == 1) {
                                echo "<i class='fa-solid fa-crown gold-icon'></i>";
                            } elseif ($position == 2) {
                                echo "<i class='fa-solid fa-medal silver-icon'></i>";
                            } elseif ($position == 3) {
                                echo "<i class='fa-solid fa-medal bronze-icon'></i>";
                            } else {
                                echo $position . "°";
                            }

                            $rol =($row['rol'] == 0) ? "Profesor" : "Estudiante";
                            echo "</td>";
                            echo "<td data-label='Estudiante'>" . htmlspecialchars($row['nombre']) . " " . htmlspecialchars($row['apellido']) . "</td>";
                            echo "<td data-label='Rol'>" . htmlspecialchars($rol) . "</td>";
                            echo "<td data-label='Edad'>" . htmlspecialchars($row['edad']) . "</td>";
                            echo "<td data-label='Puntos'>" . htmlspecialchars($row['puntos_totales']) . "</td>";
                            echo "</tr>";
                            $position++;
                        }
                    } else {
                        echo "<tr><td colspan='5' style='text-align: center; font-size: 1.2em;'>No se han encontrado usuarios.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>



        <div id="lenguaje" class="content" style="display: none">
            <table>
                <thead>
                    <tr>
                        <th style="width: 120px;">Posición</th>
                        <th>Estudiante</th>
                        <th>Rol</th>
                        <th>Edad</th>
                        <th>Puntos</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" style="text-align: center; font-size: 1.2em; color: #555;">
                            No se han encontrado usuarios.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div id="ciencias" class="content" style="display: none">
            <table>
                <thead>
                    <tr>
                        <th style="width: 120px;">Posición</th>
                        <th>Estudiante</th>
                        <th>Rol</th>
                        <th>Edad</th>
                        <th>Puntos</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" style="text-align: center; font-size: 1.2em; color: #555;">
                            No se han encontrado usuarios.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        <p>© 2024 - Incluus. Todos los derechos reservados.</p>
    </footer>

    <script src="ranking.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>