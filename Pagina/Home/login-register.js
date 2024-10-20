// Validar el RUT
function validarRUT(rut) {
    if (!/^[0-9]+-[0-9kK]{1}$/.test(rut)) {
        return false;
    }

    const partes = rut.split('-');
    const numeros = partes[0].split('').reverse();
    const dv = partes[1].toUpperCase();
    
    let suma = 0;
    let multiplicador = 2;

    for (let i = 0; i < numeros.length; i++) {
        suma += parseInt(numeros[i]) * multiplicador;
        multiplicador = multiplicador === 7 ? 2 : multiplicador + 1;
    }

    const resto = suma % 11;
    const dvCalculado = resto === 0 ? '0' : resto === 1 ? 'K' : (11 - resto).toString();

    return dv === dvCalculado;
}


// Validar la contraseña
function validarPassword(password) {
    const passwordPattern = /^(?=.*[A-Z])(?=.*[0-9]).{8,}$/;
    return passwordPattern.test(password);
}

// Añadir eventos al formulario
document.getElementById('registrationForm').addEventListener('submit', function(event) {
    const rut = document.getElementById('rut').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const messageContainer = document.getElementById('messageContainer'); // Contenedor de mensajes
    messageContainer.textContent = ''; // Limpiar mensajes anteriores
    messageContainer.style.display = 'none'; // Ocultar el contenedor al inicio

    // Validaciones
    if (!validarRUT(rut)) {
        messageContainer.textContent = 'El RUT ingresado no es valido.';
        messageContainer.style.display = 'block'; // Mostrar el contenedor de mensajes
        event.preventDefault(); // Evitar que se envíe el formulario
        return;
    }

    if (!validarPassword(password)) {
        messageContainer.textContent = 'La contrasena debe tener al menos 8 caracteres, comenzar con una letra mayuscula y contener al menos un numero.';
        messageContainer.style.display = 'block'; // Mostrar el contenedor de mensajes
        event.preventDefault(); // Evitar que se envíe el formulario
        return;
    }
});
