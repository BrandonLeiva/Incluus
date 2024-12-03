<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <link rel="stylesheet" href="menu.css">
</head>

<body>
    
    
    <!-- Menú Normal -->
<div class="menu-normal d-flex justify-content-center">
    <div class="row bar">
        <div class="col-2 mision"><a id="nav" href="../Perfil/Perfil.php">PORTAL</a></div>
        <div class="col-2 mision"><a id="nav" href="../Home/home.php">HOME</a></div>
        <div class="col-2 mision"><a id="nav" href="../Equipo/equipo.html">EQUIPO</a></div>
        <div class="col-2 mision"><a id="nav" href="../Mision/mision.html">MISION</a></div>
        <div class="col-2 mision"><a id="nav" href="../Metodologia2/metoxd.html">METODOLOGIA</a></div>
    </div>
</div>

<!-- Menú Móvil -->
<nav class="menu-movil navbar navbar-expand-lg navbar-light" style="background-color: #f4f6f9;">
    <div class="container-fluid">
        <a class="navbar-brand" href="#" style="color: #6a5acd; font-weight: bold;">Inicio</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../Perfil/Perfil.php" style="color: #6a5acd;">Portal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../Home/home.php" style="color: #6a5acd;">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: #6a5acd;">
                        Más
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="../Equipo/equipo.html">Equipo</a></li>
                        <li><a class="dropdown-item" href="../Mision/mision.html">Misión</a></li>
                        <li><a class="dropdown-item" href="../Metodologia2/metoxd.html">Metodología</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>