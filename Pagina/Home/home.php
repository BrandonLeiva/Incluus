<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Home</title>
</head>
<body>
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
    
            <div class="carousel-item active" data-bs-interval="3000">
                <img src="img/slider1.png" class="d-block w-100" alt="slider1">
            </div>
    
            <div class="carousel-item" data-bs-interval="3000">
                <img src="img/slider2.png" class="d-block w-100" alt="slider2">
            </div>
    
            <div class="carousel-item" data-bs-interval="3000">
                <img src="img/slider3.png" class="d-block w-100" alt="slider3">
            </div>
    
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    
    <!--=========================================-->
    <!--INTRO-->
    <!--=========================================-->
    
    <section class="w-50 mx-auto text-center pt-5" id="intro">
        <h1 class="p-3 fs-2 border-top border-3 pt-5">Aprende a tu ritmo, mejora cada  <span style="color: #5a67d8;">día.</span></h1>
        <p class="p-3 fs-4">Domina nuevas habilidades con cursos interactivos y divertidos. Aprende desde cualquier lugar y avanza con lecciones personalizadas para ti. 
           <br> <span style="color:#5a67d8;">¡Nunca fue tan fácil alcanzar tus metas!</span></p>
    </section>
    
    <!--=========================================-->
    <!--DESTACADO-->
    <!--=========================================-->
    
    <section class="container-fluid">
        <div class="row w-100 mx-auto servicio-fila">
            <div class="col-lg-6 col-md-12 col-sm-12 my-5 d-flex justify-content-start icono-wrap">
                <img src="img/fast.png" alt="car" width="50%">
                <div>
                    <h3 class="fs-5 mt-4 px-4 pb-1">Lecciones rápidas y dinámicas</h3>
                    <p class="px-4">Avanza con sesiones de 5 a 10 minutos al día.</p>
                </div>
            </div>
    
            <div class="col-lg-6 col-md-12 col-sm-12 my-5 d-flex justify-content-start icono-wrap">
                <img src="img/creatividad.png" alt="location"width="50%">
                <div>
                    <h3 class="fs-5 mt-4 px-4 pb-1">Método interactivo</h3>
                    <p class="px-4">Aprende de forma divertida con juegos, quizzes y actividades prácticas.</p>
                </div>
            </div>
        </div>
    
        <div class="row w-100 mx-auto servicio-fila">
            <div class="col-lg-6 col-md-12 col-sm-12 my-5 d-flex justify-content-start icono-wrap">
                <img src="img/certificado.png" alt="padlock" width="40%">
                <div>
                    <h3 class="fs-5 mt-4 px-4 pb-1">Certificación al completar cursos</h3>
                    <p class="px-4">Acredita tus logros con certificados reconocidos.</p>
                </div>
            </div>
    
            <div class="col-lg-6 col-md-12 col-sm-12 my-5 d-flex justify-content-start icono-wrap">
                <img src="img/progreso.png" alt="money" width="50%" >
                <div>
                    <h3 class="fs-5 mt-4 px-4 pb-1">Seguimiento de progreso</h3>
                    <p class="px-4">Visualiza tu avance diario y establece tus propias metas.</p>
                </div>
            </div>
        </div>
    </section>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>