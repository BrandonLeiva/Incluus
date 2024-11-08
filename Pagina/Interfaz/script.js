// Archivo: script.js
function startLesson(idLeccion) {
    window.location.href = `Preguntas/preguntas.php?id_leccion=${idLeccion}`;
    // Aquí podrías redirigir a la página de la lección o cargar contenido adicional.
    // window.location.href = `/leccion/${lessonName.toLowerCase().replace(" ", "_")}`;
}
