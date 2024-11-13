// Función para cambiar de pestaña
function showTab(tabId) {
    // Oculta todas las pestañas
    document.querySelectorAll('.content').forEach(content => content.style.display = 'none');
    document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));

    // Muestra la pestaña seleccionada y agrega clase activa
    document.getElementById(tabId).style.display = 'block';
    document.querySelector(`.tab[onclick="showTab('${tabId}')"]`).classList.add('active');
}


