document.addEventListener("DOMContentLoaded", function () {
    // Event listener para el formulario de registro
    document.getElementById("registro-form").addEventListener("submit", function (event) {
        event.preventDefault(); // Prevenir el envío del formulario tradicional
        registrarUsuario(); // Llamar a la función de registro
    });
});

// Función para registrar un usuario
function registrarUsuario() {
    // Recoger los datos del formulario
    const nombre = document.getElementById("name").value;
    const foto = document.getElementById("photo").files[0]?.name || ""; // Solo enviar el nombre de la foto
    const contrasena = document.getElementById("password").value;
    const email = document.getElementById("email").value;
    const telefono = document.getElementById("phone").value;
    const monedero = document.getElementById("wallet").value;
    const rol = "Cliente"; // Puedes cambiar el rol según lo que prefieras
    const carrito = []; // Inicializamos el carrito vacío

    // Crear un FormData para enviar los datos
    const formData = new FormData();
    formData.append('nombre', nombre);
    formData.append('foto', foto); // Solo el nombre del archivo
    formData.append('contrasena', contrasena);
    formData.append('monedero', monedero);
    formData.append('email', email);
    formData.append('carrito', JSON.stringify(carrito));
    formData.append('rol', rol);
    formData.append('telefono', telefono);

    // Mostrar en la consola lo que se enviará a la API
    console.log("Datos enviados a la API:");
    formData.forEach((value, key) => {
        console.log(`${key}: ${value}`);
    });

    // Hacer la solicitud POST a la API para registrar al usuario
    fetch('./Api/ApiUser.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Usuario registrado correctamente.');
            window.location.href = 'login.html'; // Redirige a la página de login o a donde desees
        } else {
            alert('Error al registrar el usuario: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Hubo un problema al registrar el usuario.');
    });
}
