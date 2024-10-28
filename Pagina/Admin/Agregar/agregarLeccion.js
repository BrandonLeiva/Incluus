
function filtrarCursos() {
    // Obtener el id de la materia seleccionada
    const materiaSeleccionada = document.getElementById('id_materia').value;

    // Obtener todas las opciones del select de cursos
    const cursos = document.querySelectorAll('#id_curso option');

    // Mostrar solo los cursos que correspondan a la materia seleccionada
    cursos.forEach(curso => {
        // Obtener el atributo 'data-materia' de cada curso
        const idMateriaCurso = curso.getAttribute('data-materia');

        if (materiaSeleccionada === idMateriaCurso || curso.value === "") {
            curso.style.display = ''; // Mostrar curso
        } else {
            curso.style.display = 'none'; // Ocultar curso
        }
    });

    // Reiniciar la selección de cursos al cambiar la materia
    document.getElementById('id_curso').value = '';
}

