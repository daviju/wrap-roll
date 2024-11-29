window.addEventListener('load', cargarIngredientes());


function cargarIngredientes() {
    fetch('./Api/ApiIngredientes.php')
        .then(response => response.json())
        .then(data => {

            if (Array.isArray(data)) {
                mostrarIngredientes(data); // Llamar a la función para mostrar los ingredientes
            } else {
                console.error("La respuesta no es un array de ingredientes:", data);
            }
        })
        .catch(error => {
            console.error("Error al cargar los ingredientes:", error);
        });
}

function mostrarIngredientes(ingredientes) {
    const contenedor = document.getElementById('ingredientes-container');
    contenedor.innerHTML = '';  // Limpiar contenedor de ingredientes previos

    ingredientes.forEach(ingrediente => {
        const tarjeta = document.createElement('div');
        tarjeta.classList.add('product-item');

        // Crear estructura HTML de la tarjeta
        const sidebarImage = document.createElement('div');
        sidebarImage.classList.add('sidebar-image');

        // Ruta de la imagen del ingrediente
        sidebarImage.style.backgroundImage = `url('./images/${ingrediente.foto}')`;

        const ingredienteName = document.createElement('h3');
        ingredienteName.textContent = ingrediente.nombre;

        const precio = document.createElement('p');
        precio.textContent = `Precio: ${ingrediente.precio} €`;

        const tipo = document.createElement('p');
        tipo.textContent = `Tipo: ${ingrediente.tipo}`;

        // Crear contenedor para los alérgenos
        const alergenosContainer = document.createElement('div');
        alergenosContainer.classList.add('alergenos-container');

        // Verificar si tiene alérgenos y mostrarlos
        if (ingrediente.alergenos && ingrediente.alergenos.length > 0) {
            ingrediente.alergenos.forEach(alergeno => {
                // Crear imagen o texto para cada alergeno
                const alergenoElement = document.createElement('div');
                alergenoElement.classList.add('alergeno-item');

                if (alergeno.foto) {
                    // Si hay foto, mostrar la imagen
                    const alergenoImg = document.createElement('img');
                    alergenoImg.src = `./images/${alergeno.foto}`;
                    alergenoImg.alt = alergeno.tipo; // Mostrar el tipo como texto alternativo
                    alergenoImg.title = alergeno.tipo; // Mostrar el tipo como título
                    alergenoImg.classList.add('alergeno-img'); // Clase para estilos
                    alergenoElement.appendChild(alergenoImg);
                } else {
                    // Si no hay foto, mostrar el tipo
                    const alergenoName = document.createElement('span');
                    alergenoName.textContent = alergeno.tipo;
                    alergenoElement.appendChild(alergenoName);
                }

                alergenosContainer.appendChild(alergenoElement);
            });
        } else {
            // Mostrar texto si no tiene alérgenos
            const sinAlergenos = document.createElement('p');
            sinAlergenos.textContent = "Sin alérgenos";
            alergenosContainer.appendChild(sinAlergenos);
        }

        // Crear los botones de acción
        const botonesAccion = document.createElement('div');
        botonesAccion.classList.add('botones-accion');

        // Botón de modificar
        const btnModificar = document.createElement('button');
        btnModificar.textContent = 'Modificar';
        btnModificar.onclick = () => modificarIngrediente(ingrediente.ID_Ingredientes);

        // Botón de borrar
        const btnBorrar = document.createElement('button');
        btnBorrar.textContent = 'Borrar';
        btnBorrar.onclick = () => borrarIngrediente(ingrediente.ID_Ingredientes);

        // Añadir los botones a la estructura
        botonesAccion.appendChild(btnModificar);
        botonesAccion.appendChild(btnBorrar);

        // Agregar la tarjeta al contenedor
        tarjeta.appendChild(sidebarImage);
        tarjeta.appendChild(ingredienteName);
        tarjeta.appendChild(precio);
        tarjeta.appendChild(tipo);
        tarjeta.appendChild(alergenosContainer); // Agregar los alérgenos debajo del tipo
        tarjeta.appendChild(botonesAccion);

        contenedor.appendChild(tarjeta);
    });
}


// Función para modificar un ingrediente
function modificarIngrediente(id) {
    alert(`Modificar ingrediente con id: ${id}`);
    // Aquí puedes agregar la lógica para modificar el ingrediente (abrir un formulario o redirigir a otra página)
}

// Función para borrar un ingrediente

/*
function borrarIngrediente(id) {
    const confirmacion = confirm('¿Estás seguro de que quieres borrar este ingrediente?');
    if (confirmacion) {
        fetch(`http://www.daviju.es/Api/ApiIngredientes.php?ID_Ingredientes=${id}`, {
            method: 'DELETE', // Método para borrar el ingrediente
            headers: {
                'Content-Type': 'application/json'
            },
        })        
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Ingrediente borrado correctamente');
                // Recargar los ingredientes después de borrar
                cargarIngredientes();
            } else {
                alert('Error al borrar el ingrediente');
            }
        })
        .catch(error => {
            console.error('Error al borrar el ingrediente:', error);
        });
    }
}*/

// Función para borrar un ingrediente
function borrarIngrediente(id) {
    const confirmacion = confirm('¿Estás seguro de que quieres borrar este ingrediente?');
    if (confirmacion) {
        const url = `http://www.daviju.es/Api/ApiIngredientes.php?ID_Ingredientes=${id}`;
        const options = {
            method: 'DELETE', // Método para borrar el ingrediente
            headers: {
                'Content-Type': 'application/json'
            }
        };

        fetch(url, options)
            .then(response => {
                console.log('Estado de la respuesta:', response.status, response.statusText);
                return response.text();
            })
            .then(data => {
                console.log("miau",data);
                if (data) {
                    // Recargar los ingredientes después de borrar
                    cargarIngredientes();
                }
            })
            .catch(error => {
                console.error('Error al borrar el ingrediente:', error);
            });
    }
}