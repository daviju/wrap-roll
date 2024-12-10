// Cargar alérgenos al cargar la página
window.addEventListener('load', cargarAlergenos);  // Se ejecuta cuando la página termina de cargar, para cargar los alérgenos.

function cargarAlergenos() {
    fetch('./Api/ApiAlergenos.php')  // Realiza una solicitud HTTP a la API que devuelve los alérgenos en formato JSON.
        .then(response => response.json())  // Convierte la respuesta en un objeto JSON.
        .then(data => {
            if (Array.isArray(data)) {  // Verifica que la respuesta sea un array de alérgenos.
                mostrarAlergenos(data);  // Si la respuesta es válida, pasa los datos a la función que mostrará los alérgenos.
            } else {
                console.error("La respuesta no es un array de alérgenos:", data);  // Si la respuesta no es un array, muestra un error en la consola.
            }
        })
        .catch(error => {
            console.error("Error al cargar los alérgenos:", error);  // Si ocurre un error en la solicitud fetch, se muestra un mensaje de error.
        });
}

function mostrarAlergenos(alergenos) {
    const contenedor = document.getElementById('alergenos-container');  // Obtiene el contenedor donde se mostrarán los alérgenos.
    contenedor.innerHTML = '';  // Limpia cualquier contenido previo del contenedor.

    alergenos.forEach(alergeno => {  // Recorre cada alérgeno del array recibido.
        console.log("Alergeno:", alergeno);  // Muestra en consola la información del alérgeno para depuración.

        const tarjeta = document.createElement('div');  // Crea un contenedor (tarjeta) para cada alérgeno.
        tarjeta.classList.add('product-item');  // Le añade una clase CSS para darle estilo.

        // Crear estructura HTML de la tarjeta
        const sidebarImage = document.createElement('div');  // Crea un contenedor para la imagen del alérgeno.
        sidebarImage.classList.add('sidebar-image');  // Le asigna una clase CSS.
        sidebarImage.style.backgroundImage = `url('./images/${alergeno.foto}')`;  // Asigna la imagen del alérgeno como fondo.

        const alergenoName = document.createElement('h3');  // Crea un título para el nombre del alérgeno.
        alergenoName.textContent = alergeno.tipo;  // Establece el texto del título con el tipo del alérgeno.

        // Crear los botones de acción
        const botonesAccion = document.createElement('div');  // Crea un contenedor para los botones.
        botonesAccion.classList.add('botones-accion');  // Añade una clase CSS a este contenedor.

        // Botón de modificar
        const btnModificar = document.createElement('button');  // Crea el botón para modificar el alérgeno.
        btnModificar.textContent = 'Modificar';  // Le asigna el texto "Modificar".
        btnModificar.onclick = () => modificarAlergeno(alergeno.idAlergenos);  // Define la acción cuando se hace clic: llamar a la función de modificar.

        // Botón de borrar
        const btnBorrar = document.createElement('button');  // Crea el botón para borrar el alérgeno.
        btnBorrar.textContent = 'Borrar';  // Le asigna el texto "Borrar".
        btnBorrar.onclick = () => borrarAlergeno(alergeno.ID_Alergenos);  // Define la acción al hacer clic: llamar a la función de borrar.

        // Añadir los botones a la estructura
        botonesAccion.appendChild(btnModificar);  // Añade el botón de modificar al contenedor de botones.
        botonesAccion.appendChild(btnBorrar);  // Añade el botón de borrar al contenedor de botones.

        // Agregar la tarjeta al contenedor principal
        tarjeta.appendChild(sidebarImage);  // Añade la imagen de fondo a la tarjeta.
        tarjeta.appendChild(alergenoName);  // Añade el nombre del alérgeno a la tarjeta.
        tarjeta.appendChild(botonesAccion);  // Añade los botones de acción a la tarjeta.

        contenedor.appendChild(tarjeta);  // Añade la tarjeta completa al contenedor en la página.
    });
}

// Función para modificar un alérgeno
function modificarAlergeno(id) {
    alert(`Modificar alérgeno con ID: ${id}`);  // Muestra un mensaje de alerta con el ID del alérgeno a modificar.
    // Aquí puedes agregar la lógica para modificar el alérgeno (abrir un formulario o redirigir a otra página).
}

// Función para borrar un alérgeno
function borrarAlergeno(id) {
    console.log("ID recibido para borrar:", id);  // Muestra en consola el ID del alérgeno que se quiere borrar para depuración.

    alert("Estás seguro de borrar el alérgeno con ID: " + id + "?");  // Muestra una alerta de confirmación antes de proceder.

    // URL de la API para borrar el alérgeno
    const url = `http://www.daviju.es/Api/ApiAlergenos.php`;  

    // Opciones para la solicitud fetch
    const options = {
        method: 'DELETE',  // Método HTTP para eliminar datos.
        headers: {
            'Content-Type': 'application/json'  // Especifica que el contenido de la solicitud es JSON.
        },
        body: JSON.stringify({ id_alergeno: id })  // Crea el cuerpo de la solicitud con el ID del alérgeno a borrar.
    };

    console.log("Opciones del fetch:", options);  // Muestra las opciones de la solicitud para depuración.

    // Realiza la solicitud fetch para eliminar el alérgeno
    fetch(url, options)
        .then(response => {
            console.log("Estado de la respuesta:", response.status);  // Muestra el estado de la respuesta (por ejemplo, 200 si fue exitosa).
            return response.json();  // Convierte la respuesta en un objeto JSON.
        })
        .then(data => {
            console.log("Respuesta del servidor:", data);  // Muestra los datos recibidos del servidor.
            if (data.success) {  // Si la respuesta del servidor indica éxito:
                cargarAlergenos();  // Recarga la lista de alérgenos.
            } else {
                console.error("Error al borrar el alérgeno:", data.error);  // Si hubo un error, lo muestra en consola.
            }
        })
        .catch(error => {
            console.error("Error al realizar el fetch:", error);  // Si ocurre un error en la solicitud fetch, lo muestra en consola.
        });
}
