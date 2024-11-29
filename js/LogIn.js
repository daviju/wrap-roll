console.log('Paso 3: Ejecutando LogIn.js...');
// Aqui lo que hago es gestionar el login del php que tengo

document.addEventListener("DOMContentLoaded", () => {

    const form = document.querySelector("form");
    
    form.addEventListener("submit", async (event) => {
        event.preventDefault(); // Evita el envío predeterminado del formulario

        // Obtén los valores de los campos de entrada
        const email = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value.trim();

        // Validar los campos antes de enviar la solicitud
        if (!email || !password) {
            alert("Por favor, completa todos los campos.");
            return;
        }
        // Yo aqui lo que haria es si tienes un formulario lo que haces es verificar en el caso de
        try {
            // Realizar la petición GET a la API de validación
            const response = await fetch(`./Api/ApiUser.php?email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`);

            const data = await response.json();

            // Comprobar la respuesta de la API
            if (response.ok && data.success) {
                // Si la respuesta es positiva, redirigir o realizar alguna acción
                alert("Inicio de sesión exitoso");
                window.location.href = "./inisio.php"; // Redirige a la página de inicio
            } else {
                // Si hubo algún error en la autenticación
                alert(data.error || "Error al iniciar sesión. Verifica tus credenciales.");
            }
        } catch (error) {
            console.error(error);
            alert("Hubo un error en la conexión con el servidor. Inténtalo nuevamente.");
        }
    });
});
