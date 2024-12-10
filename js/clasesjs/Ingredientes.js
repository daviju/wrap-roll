// Se añade un evento para cuando la página se haya cargado completamente
window.addEventListener('load', cargarIngredientes()); // Llamada a la función para cargar los ingredientes desde la API cuando la página esté lista

// Función que se encarga de obtener los ingredientes de la API
function cargarIngredientes() {
    fetch('./Api/ApiIngredientes.php') // Realiza una solicitud GET a la API para obtener los ingredientes
        .then(response => response.json()) // Convierte la respuesta en formato JSON
        .then(data => {

            // Verifica si los datos obtenidos son un array
            if (Array.isArray(data)) {
                mostrarIngredientes(data); // Llama a la función mostrarIngredientes para procesar y mostrar los ingredientes
            } else {
                console.error("La respuesta no es un array de ingredientes:", data); // Si la respuesta no es válida, muestra un error
            }
        })
        .catch(error => {
            console.error("Error al cargar los ingredientes:", error); // Maneja cualquier error durante la solicitud
        });
}

// Función para mostrar los ingredientes en la interfaz de usuario
function mostrarIngredientes(ingredientes) {
    const contenedor = document.getElementById('ingredientes-container'); // Selecciona el contenedor donde se mostrarán los ingredientes
    contenedor.innerHTML = '';  // Limpia el contenedor antes de agregar nuevos ingredientes

    // Itera sobre cada ingrediente y lo agrega a la interfaz
    ingredientes.forEach(ingrediente => {
        const tarjeta = document.createElement('div'); // Crea un nuevo contenedor para cada ingrediente
        tarjeta.classList.add('product-item'); // Añade una clase para los estilos CSS

        // Crea el contenedor de la imagen del ingrediente
        const sidebarImage = document.createElement('div');
        sidebarImage.classList.add('sidebar-image');
        sidebarImage.style.backgroundImage = `url('./images/${ingrediente.foto}')`; // Establece la imagen de fondo

        // Crea el nombre del ingrediente
        const ingredienteName = document.createElement('h3');
        ingredienteName.textContent = ingrediente.nombre;

        // Crea el precio del ingrediente
        const precio = document.createElement('p');
        precio.textContent = `Precio: ${ingrediente.precio} €`;

        // Crea el tipo de ingrediente (por ejemplo, si es carne, vegetales, etc.)
        const tipo = document.createElement('p');
        tipo.textContent = `Tipo: ${ingrediente.tipo}`;

        // Crea el contenedor para los alérgenos
        const alergenosContainer = document.createElement('div');
        alergenosContainer.classList.add('alergenos-container');

        // Si el ingrediente tiene alérgenos, los muestra
        if (ingrediente.alergenos && ingrediente.alergenos.length > 0) {
            ingrediente.alergenos.forEach(alergeno => {
                const alergenoElement = document.createElement('div');
                alergenoElement.classList.add('alergeno-item');

                // Si hay foto del alérgeno, se crea una imagen
                if (alergeno.foto) {
                    const alergenoImg = document.createElement('img');
                    alergenoImg.src = `./images/${alergeno.foto}`;
                    alergenoImg.alt = alergeno.tipo; // Muestra el tipo del alérgeno como texto alternativo
                    alergenoImg.title = alergeno.tipo; // Muestra el tipo al pasar el cursor sobre la imagen
                    alergenoImg.classList.add('alergeno-img');
                    alergenoElement.appendChild(alergenoImg);
                } else {
                    // Si no hay foto, solo muestra el nombre del alérgeno
                    const alergenoName = document.createElement('span');
                    alergenoName.textContent = alergeno.tipo;
                    alergenoElement.appendChild(alergenoName);
                }

                alergenosContainer.appendChild(alergenoElement); // Añade el alérgeno al contenedor
            });
        } else {
            // Si no tiene alérgenos, muestra un mensaje indicando que no tiene
            const sinAlergenos = document.createElement('p');
            sinAlergenos.textContent = "Sin alérgenos";
            alergenosContainer.appendChild(sinAlergenos);
        }

        // Crear los botones de acción (modificar y borrar)
        const botonesAccion = document.createElement('div');
        botonesAccion.classList.add('botones-accion');

        // Botón para modificar el ingrediente
        const btnModificar = document.createElement('button');
        btnModificar.textContent = 'Modificar';
        btnModificar.onclick = () => modificarIngrediente(ingrediente.ID_Ingredientes); // Llama a la función para modificar el ingrediente

        // Botón para borrar el ingrediente
        const btnBorrar = document.createElement('button');
        btnBorrar.textContent = 'Borrar';
        btnBorrar.onclick = () => borrarIngrediente(ingrediente.ID_Ingredientes); // Llama a la función para borrar el ingrediente

        // Añade los botones al contenedor
        botonesAccion.appendChild(btnModificar);
        botonesAccion.appendChild(btnBorrar);

        // Añadir todos los elementos creados al contenedor principal de la tarjeta
        tarjeta.appendChild(sidebarImage);
        tarjeta.appendChild(ingredienteName);
        tarjeta.appendChild(precio);
        tarjeta.appendChild(tipo);
        tarjeta.appendChild(alergenosContainer); // Añade el contenedor de alérgenos
        tarjeta.appendChild(botonesAccion); // Añade los botones de acción

        contenedor.appendChild(tarjeta); // Finalmente, añade la tarjeta al contenedor principal
    });
}

// Función para modificar un ingrediente
function modificarIngrediente(id) {
    alert(`Modificar ingrediente con id: ${id}`); // Alerta para simular la modificación
    // Aquí podrías agregar la lógica para abrir un formulario o redirigir a otra página para editar el ingrediente
}

// Función para borrar un ingrediente
function borrarIngrediente(id) {
    const confirmacion = confirm('¿Estás seguro de que quieres borrar este ingrediente?'); // Solicita confirmación al usuario

    if (confirmacion) {
        const url = `.Api/ApiIngredientes.php?ID_Ingredientes=${id}`; // URL para borrar el ingrediente
        const options = {
            method: 'DELETE', // Método HTTP DELETE para eliminar el ingrediente
            headers: {
                'Content-Type': 'application/json' // Indicamos que el cuerpo de la solicitud es JSON
            }
        };

        fetch(url, options) // Realiza la solicitud para borrar el ingrediente
            .then(response => {
                console.log('Estado de la respuesta:', response.status, response.statusText); // Muestra el estado de la respuesta
                return response.text(); // Lee la respuesta como texto
            })
            .then(data => {
                console.log("miau", data);
                if (data) {
                    cargarIngredientes(); // Vuelve a cargar los ingredientes para actualizar la vista
                }
            })
            .catch(error => {
                console.error('Error al borrar el ingrediente:', error); // Maneja cualquier error en la solicitud
            });
    }
}
