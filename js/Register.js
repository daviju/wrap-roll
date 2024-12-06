document.addEventListener("DOMContentLoaded", function () {

    // Event listener para el formulario de registro
    document.getElementById("registro-form").addEventListener("submit", function (event) {
        event.preventDefault(); // Prevenir el envío del formulario
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
    const rol = "Cliente"; // Puedes cambiar el rol según lo prefieras

    // Si no hay elementos en el carrito, enviar un string vacío
    const carrito = JSON.stringify([]); // Asegúrate de enviar un string JSON vacío "[]"

    // Crear un objeto con los datos
    const data = {
        nombre: nombre,
        foto: foto,
        contrasena: contrasena,
        email: email,
        telefono: telefono,
        monedero: monedero,
        rol: rol,
        carrito: carrito // Enviamos el carrito como un string JSON vacío
    };

    // Mostrar en la consola lo que se enviará a la API
    console.log("Datos enviados a la API:", data);

    // Hacer la solicitud POST a la API para registrar al usuario
    fetch('http://www.daviju.es/Api/ApiUser.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json' // Especificamos que estamos enviando JSON
        },
        body: JSON.stringify(data) // Convertimos el objeto a JSON
    })
    .then(response => response.json())
    
    .then(data => {
        if (data.success) {
            alert('Usuario registrado correctamente.');
            window.location.href = "./inisio.php"; // Redirigir a la página de inicio
        } else {
            alert('Error al registrar el usuario: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Hubo un problema al registrar el usuario.');
    });
}
