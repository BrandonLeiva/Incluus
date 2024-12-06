<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecciones y Contenidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../Interfaz/styles.css">
</head>

<body class="d-flex justify-content-center align-items-center vh-100">

    <div class="sidebar glass">
        <a href="../perfil/perfil.php" class="sidebar-item ">
            <i class="icon">🏠</i>
            <span>Inicio</span>
        </a>
        <a href="#" class="sidebar-item active">
            <i class="icon">📘</i>
            <span>Lecciones</span>
        </a>
        <a href="#" class="sidebar-item">
            <i class="icon">📚</i>
            <span>Niveles</span>
        </a>
        <a href="#" class="sidebar-item">
            <i class="icon">👤</i>
            <span>Perfil</span>
        </a>
        <a href="configuracion.html" class="sidebar-item">
            <i class="icon">⚙️</i>
            <span>Configuración</span>
        </a>
    </div>

    <div class="container">
        <div class="row justify-content-center">

            <div class="card glass">
                <div class="stage">Nivel <?php echo isset($lecciones[0]['nivel']) ? $lecciones[0]['nivel'] : 'Sin nivel'; ?> </div>
                <div class="section">Sección A</div>
            </div>

        </div>

        <div class="row justify-content-center">
            <div class="col" style="max-width: 30rem;">
                
                <h1 style="color: #fff;">
                    No hay cursos disponibles
                </h1>
            </div>
        </div>
    </div>
    

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>