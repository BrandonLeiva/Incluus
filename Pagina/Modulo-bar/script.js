  // Seleccionamos todos los divs dentro de la fila
  const sections = document.querySelectorAll('.row div');

  // Función para activar la clase 'active' cuando se hace clic
  sections.forEach(section => {
    section.addEventListener('click', function() {
      // Removemos la clase 'active' de todos los divs
      sections.forEach(div => div.classList.remove('active'));
      
      // Agregamos la clase 'active' solo al div seleccionado
      this.classList.add('active');
    });
  });