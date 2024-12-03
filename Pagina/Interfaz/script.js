
function startLesson(idLeccion) {
    window.location.href = `Preguntas/preguntas.php?id_leccion=${idLeccion}`;
}

// Archivo: script.js
function startContent(id_contenido) {
    window.location.href = `Contenido/contenido.php?id_contenido=${id_contenido}`;
    // Aquí podrías redirigir a la página de la lección o cargar contenido adicional.
    // window.location.href = `/leccion/${lessonName.toLowerCase().replace(" ", "_")}`;
}
