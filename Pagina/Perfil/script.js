window.addEventListener("load", () => {
    const preloader = document.getElementById("preloader");
    const contenido = document.getElementById("contenido");

    // Asegurarse de que el preloader dure al menos 3 segundos
    setTimeout(() => {
        // Fade out del preloader
        preloader.style.opacity = "0";

        // Mostrar el contenido con fade in
        contenido.style.opacity = "1";
        contenido.style.visibility = "visible"; // Asegurar que sea visible

        // Eliminar el preloader después del fade out
        setTimeout(() => {
            preloader.style.display = "none";
        }, 1000); // Tiempo suficiente para el fade out (1s)
    }, 3000); // 3 segundos de espera
});
