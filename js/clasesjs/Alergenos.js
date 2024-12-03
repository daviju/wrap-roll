// Cargar alérgenos al cargar la página
window.addEventListener('load', cargarAlergenos);

function cargarAlergenos() {
    fetch('./Api/ApiAlergenos.php') // Cambiar a la ruta de tu API de alérgenos
        .then(response => response.json())
        .then(data => {
            if (Array.isArray(data)) {
                mostrarAlergenos(data); // Mostrar alérgenos en la página
            } else {
                console.error("La respuesta no es un array de alérgenos:", data);
            }
        })
        .catch(error => {
            console.error("Error al cargar los alérgenos:", error);
        });
}

function mostrarAlergenos(alergenos) {
    const contenedor = document.getElementById('alergenos-container');
    contenedor.innerHTML = ''; // Limpiar contenedor de alérgenos previos

    alergenos.forEach(alergeno => {
        console.log("Alergeno:", alergeno); // Verificar que el ID está presente

        const tarjeta = document.createElement('div');
        tarjeta.classList.add('product-item');

        // Crear estructura HTML de la tarjeta
        const sidebarImage = document.createElement('div');
        sidebarImage.classList.add('sidebar-image');
        sidebarImage.style.backgroundImage = `url('./images/${alergeno.foto}')`; // Ruta de la imagen

        const alergenoName = document.createElement('h3');
        alergenoName.textContent = alergeno.tipo;

        // Crear los botones de acción
        const botonesAccion = document.createElement('div');
        botonesAccion.classList.add('botones-accion');

        // Botón de modificar
        const btnModificar = document.createElement('button');
        btnModificar.textContent = 'Modificar';
        btnModificar.onclick = () => modificarAlergeno(alergeno.idAlergenos);

        // Botón de borrar
        const btnBorrar = document.createElement('button');
        btnBorrar.textContent = 'Borrar';
        btnBorrar.onclick = () => borrarAlergeno(alergeno.ID_Alergenos);

        // Añadir los botones a la estructura
        botonesAccion.appendChild(btnModificar);
        botonesAccion.appendChild(btnBorrar);

        // Agregar la tarjeta al contenedor
        tarjeta.appendChild(sidebarImage);
        tarjeta.appendChild(alergenoName);
        tarjeta.appendChild(botonesAccion);

        contenedor.appendChild(tarjeta);
    });
}

// Función para modificar un alérgeno
function modificarAlergeno(id) {
    alert(`Modificar alérgeno con ID: ${id}`);
    // Aquí puedes agregar la lógica para modificar el alérgeno (abrir un formulario o redirigir a otra página)
}

// Función para borrar un alérgeno
function borrarAlergeno(id) {
    console.log("ID recibido para borrar:", id);  // Asegúrate de que el id esté siendo recibido correctamente

    alert("Estás seguro de borrar el alérgeno con ID: " + id + "?");
    const url = `http://www.daviju.es/Api/ApiAlergenos.php`;
    const options = {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id_alergeno: id })  // Pasamos el id correctamente
    };

    console.log("Opciones del fetch:", options);

    fetch(url, options)
        .then(response => {
            console.log("Estado de la respuesta:", response.status);
            return response.json();
        })
        .then(data => {
            console.log("Respuesta del servidor:", data);
            if (data.success) {
                cargarAlergenos();  // Recargar los alérgenos después de borrar
            } else {
                console.error("Error al borrar el alérgeno:", data.error);
            }
        })
        .catch(error => {
            console.error("Error al realizar el fetch:", error);
        });
}
