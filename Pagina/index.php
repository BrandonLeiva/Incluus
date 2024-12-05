<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="Home/style.css">
    <title>Home</title>
</head>

<body>
   
    <header>
        <h1 id="h1"><strong>INCLUUS</strong></h1>
        <p></p>
        <p id="h1">Bienvenido a la mejor plataforma educativa</p>

    </header>

    <!-- Menú Normal -->
    <div class="menu-normal d-flex justify-content-center">
        <div class="row bar">
            <div class="col-2 mision"><a id="nav" href="../Perfil/Perfil.php">PORTAL</a></div>
            <div class="col-2 mision"><a id="nav" href="index.php">HOME</a></div>
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
                    <li class="nav-item">
                        <a class="nav-link" href="../Equipo/equipo.html" style="color: #6a5acd;">Equipo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Mision/mision.html" style="color: #6a5acd;">Misión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Metodologia2/metoxd.html" style="color: #6a5acd;">Metodología</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="fade-in">
        <section class="w-50 mx-auto text-center pt-5">
            <h1 class="p-3 fs-2 border-top border-3 pt-5" id="h1">Aprende a tu ritmo, mejora cada <span style="color: #5a67d8;">día.</span></h1>
            <p class="p-3 fs-4" id="h1">Domina nuevas habilidades con cursos interactivos y divertidos. Aprende desde cualquier lugar y avanza con lecciones personalizadas para ti.
                <br> <span style="color:#5a67d8;">¡Nunca fue tan fácil alcanzar tus metas!</span>
            </p>
        </section>
    </div>


    <!--=========================================-->
    <!--DESTACADO-->
    <!--=========================================-->

    <div class="fade-in ">
        <section class="container-fluid" id="intro">

            <div class="row w-100 mx-auto servicio-fila">
                <div class="col-lg-6 col-md-12 col-sm-12 my-5 d-flex justify-content-start icono-wrap">
                    <img src="Home/img/fast.png" alt="car" width="50%">
                    <div>
                        <h3 class="fs-5 mt-4 px-4 pb-1">Lecciones rápidas y dinámicas</h3>
                        <p class="px-4">Avanza con sesiones de 5 a 10 minutos al día. Aprende conceptos clave de forma rápida y efectiva,
                            sin interrumpir tu rutina diaria. ¡Sigue mejorando cada día sin esfuerzo!</p>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 col-sm-12 my-5 d-flex justify-content-start icono-wrap">
                    <img src="Home/img/creatividad.png" alt="location" width="50%">
                    <div>
                        <h3 class="fs-5 mt-4 px-4 pb-1">Método interactivo</h3>
                        <p class="px-4">Aprende de forma divertida participando con juegos, quizzes y actividades prácticas diseñadas para poner
                            en acción tus habilidades mientras te diviertes.
                    </div>
                </div>
                <p></p>

                <div class="row w-100 mx-auto servicio-fila" id="intro">
                    <div class="col-lg-6 col-md-12 col-sm-12 my-5 d-flex justify-content-start icono-wrap">
                        <img src="Home/img/certificado.png" alt="padlock" width="50%">
                        <div>
                            <h3 class="fs-5 mt-4 px-4 pb-1">Certificación al completar cursos</h3>
                            <p class="px-4">Acredita tus logros con certificados reconocidos. Cada vez que termines un curso, recibiras un certificado
                                especial que muestra todo lo que has aprendido.
                                ¡Cada paso cuenta!</p>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12 col-sm-12 my-5 d-flex justify-content-start icono-wrap">
                        <img src="Home/img/progreso.png" alt="money" width="50%">
                        <div>
                            <h3 class="fs-5 mt-4 px-4 pb-1">Seguimiento de progreso</h3>
                            <p class="px-4">¡Mira todo lo que has avanzado! Con nuestro sistema de seguimiento, puedes ver cuántas lecciones has completado
                                y lo cerca que estás de tu meta.</p>
                        </div>
                    </div>
                </div>


                <div class="texto-final">
                    <section class="w-50 mx-auto text-center pt-5">
                        <h1 class="p-3 fs-2 border-top border-3 pt-5" id="h1">¡Estás a un paso de convertirte en un superaprendiz!</h1>
                        <p class="p-3 fs-4" id="h1">Cada vez que completes una lección o juegues un juego, te acercarás más a tus metas.
                            Aprender es una aventura emocionante, ¡y estamos aquí para acompañarte en cada paso del camino!
                            Recuerda que lo más importante es divertirte mientras aprendes.
                        </p>
                        <img src="Home/img/motivacion.png" alt="money" width="50%">
                    </section>
                </div>

        </section>

        <footer>
    <p>© 2024 - Incluus. Todos los derechos reservados.</p>
</footer>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>