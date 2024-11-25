// Función para registrar un usuario
function registrarUsuario() {
    // Recoger los datos del formulario
    const nombre = document.getElementById("nombre").value;
    const foto = document.getElementById("foto").files[0]; // Si se selecciona una imagen
    const contrasena = document.getElementById("contrasena").value;
    const email = document.getElementById("email").value;
    const telefono = document.getElementById("telefono").value;
    const monedero = 0; // Si es nuevo, lo inicializamos en 0
    const rol = "usuario"; // Puedes cambiar el rol según lo que prefieras
    const carrito = []; // Inicializamos el carrito vacío

    // Crear un FormData para enviar los datos, incluyendo la foto
    const formData = new FormData();
    formData.append('nombre', nombre);
    formData.append('foto', foto);
    formData.append('contrasena', contrasena);
    formData.append('email', email);
    formData.append('telefono', telefono);
    formData.append('monedero', monedero);
    formData.append('rol', rol);
    formData.append('carrito', JSON.stringify(carrito)); // El carrito debe enviarse como un JSON

    // Hacer la solicitud POST a la API para registrar al usuario
    fetch('http://localhost/tu_api/ApiUser.php', {
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

// Event listener para el formulario de registro
document.getElementById("registro-form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevenir el envío del formulario tradicional
    registrarUsuario(); // Llamar a la función de registro
});
