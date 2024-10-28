
// Filtrar los cursos según la materia seleccionada
function filtrarCursos() {
    const materiaSeleccionada = document.getElementById('id_materia').value;
    const cursos = document.querySelectorAll('#id_curso option');

    cursos.forEach(curso => {
        const idMateriaCurso = curso.getAttribute('data-materia');
        if (materiaSeleccionada === idMateriaCurso || curso.value === "") {
            curso.style.display = ''; // Mostrar curso
        } else {
            curso.style.display = 'none'; // Ocultar curso
        }
    });

    // Reiniciar la selección de cursos y lecciones al cambiar la materia
    document.getElementById('id_curso').value = '';
    document.getElementById('id_leccion').value = '';
    filtrarLecciones(); // Para reiniciar las lecciones
}

// Filtrar las lecciones según el curso seleccionado
function filtrarLecciones() {
    const cursoSeleccionado = document.getElementById('id_curso').value;
    const lecciones = document.querySelectorAll('#id_leccion option');

    lecciones.forEach(leccion => {
        const idCursoLeccion = leccion.getAttribute('data-curso');
        if (cursoSeleccionado === idCursoLeccion || leccion.value === "") {
            leccion.style.display = ''; // Mostrar lección
        } else {
            leccion.style.display = 'none'; // Ocultar lección
        }
    });

    // Reiniciar la selección de lecciones al cambiar el curso
    document.getElementById('id_leccion').value = '';
}
