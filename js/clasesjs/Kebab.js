// Función para mostrar los kebabs en la página
function mostrarKebabs(kebabs) {
    const contenedor = document.querySelector('.product-grid');

    // Limpiar tarjetas de kebabs existentes
    const tarjetasKebabs = contenedor.querySelectorAll('.product-item');
    tarjetasKebabs.forEach(tarjeta => tarjeta.remove());

    kebabs.forEach(kebab => {
        const tarjeta = document.createElement('a');
        tarjeta.classList.add('product-item');
        tarjeta.setAttribute('data-id', kebab.ID_Kebab);

        // Crear estructura HTML de la tarjeta
        const sidebarImage = document.createElement('div');
        sidebarImage.classList.add('sidebar-image');
        sidebarImage.style.backgroundImage = `url('http://localhost/SERVIDOR/wrap&roll/images/${kebab.foto}')`;

        const kebabName = document.createElement('h3');
        kebabName.textContent = kebab.nombre;

        const kebabPrice = document.createElement('p');
        kebabPrice.textContent = `${kebab.precio} €`;

        // Crear el contenedor para los ingredientes
        const ingredientesList = document.createElement('p');
        ingredientesList.textContent = '';

        // Obtener los ingredientes para este kebab
        fetch(`./Api/ApiKebabIngredientes.php?ID_Kebab=${kebab.ID_Kebab}`)
            .then(response => response.json())
            .then(ingredientesData => {
                if (Array.isArray(ingredientesData) && ingredientesData.length > 0) {
                    // Si ya es un array de nombres, solo unirlos
                    const ingredientesNombres = ingredientesData.join(', ');
                    ingredientesList.textContent = ingredientesNombres;  // Mostrar los nombres de los ingredientes
                } else {
                    ingredientesList.textContent = 'Sin ingredientes disponibles';
                }

                // Ahora que tenemos los ingredientes, podemos agregar los botones
                const botonesContenedor = document.createElement('div');
                botonesContenedor.classList.add('botones-container');

                const botonModificar = document.createElement('button');
                botonModificar.classList.add('boton-modificar');
                botonModificar.textContent = 'Modificar';
                botonModificar.addEventListener('click', () => modificarKebab(kebab.ID_Kebab));  // Acción para modificar

                const botonBorrar = document.createElement('button');
                botonBorrar.classList.add('boton-borrar');
                botonBorrar.textContent = 'Borrar';
                botonBorrar.addEventListener('click', () => borrarKebab(kebab.ID_Kebab));  // Acción para borrar

                botonesContenedor.appendChild(botonModificar);
                botonesContenedor.appendChild(botonBorrar);

                // Agregar todo al item de kebab después de la carga de los ingredientes
                tarjeta.appendChild(sidebarImage);
                tarjeta.appendChild(kebabName);
                tarjeta.appendChild(kebabPrice);
                tarjeta.appendChild(ingredientesList);
                tarjeta.appendChild(botonesContenedor);

                // Insertar el item de kebab en el contenedor
                contenedor.appendChild(tarjeta);
            })
            .catch(error => {
                console.error("Error al cargar los ingredientes:", error);
                ingredientesList.textContent = 'Error al cargar los ingredientes';
            });
    });
}

// Funciones para los botones
function modificarKebab(id) {
    console.log('Modificar kebab con ID:', id);
    // Aquí puedes redirigir o realizar la acción de modificar el kebab
}

function borrarKebab(id) {
    console.log('Borrar kebab con ID:', id);
    // Aquí puedes realizar la acción de borrar el kebab
}

// Función para cargar los kebabs desde la API
window.addEventListener('load', cargarKebabs());

function cargarKebabs() {
    fetch('./Api/ApiKebab.php')
        .then(response => response.json())
        .then(data => {
            if (Array.isArray(data)) {
                mostrarKebabs(data); // Llamar a la función para mostrar los kebabs
            } else {
                console.error("La respuesta no es un array de kebabs:", data);
            }
        })
        .catch(error => {
            console.error("Error al cargar los kebabs:", error);
        });
}
