// Paso 1: Mensaje inicial para saber que la página ha cargado correctamente.
console.log('Paso 1: La página ha cargado.');

// Referencias a los elementos HTML
const form = document.getElementById('drag-drop-form'); // Formulario para crear el kebab
const list1 = document.getElementById('list1')?.querySelector('.list-items'); // Lista de ingredientes disponibles
const list2 = document.getElementById('list2')?.querySelector('.list-items'); // Lista de ingredientes seleccionados
const precioInput = document.getElementById('precio'); // Input de precio
const btn = document.querySelector('.btn'); // Botón que probablemente se use para enviar el formulario

// Obtener el userId desde el HTML
const userIdElement = document.getElementById('user-data');
const userId = userIdElement ? userIdElement.getAttribute('data-user-id') : null;

console.log('ID del usuario:', userId);

// Contenedor de alérgenos
const alergenosContainer = document.querySelector('.alergenos-container');

// Validamos que las listas existan en el HTML
if (!list1 || !list2) {
    console.error('Error: No se encontraron los elementos "list1" o "list2" en el HTML.');
}

console.log('Paso 2: Ejecutando loadIngredientes...');
// Llamada a la función para cargar los ingredientes desde la API
loadIngredientes();

async function loadIngredientes() {
    await fetch('./Api/ApiIngredientes.php') // Hacemos la solicitud fetch a la API
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json(); // Parseamos la respuesta como JSON
        })
        .then(data => {
            console.log('Paso 3: Datos de la API recibidos:', data);
            if (Array.isArray(data) && data.length > 0) {
                // Iteramos sobre los ingredientes recibidos
                data.forEach(ingrediente => {
                    console.log('Paso 4: Procesando ingrediente:', ingrediente);

                    // Creamos un div para cada ingrediente
                    const div = document.createElement('div');
                    div.className = 'list';
                    div.textContent = `${ingrediente.nombre} - $${ingrediente.precio}`; // Mostrar nombre y precio
                    div.draggable = true; // Hacemos el elemento arrastrable

                    // Asignamos el ID del ingrediente como data-id
                    div.dataset.id = ingrediente.ID_Ingredientes;
                    div.dataset.precio = ingrediente.precio; // Guardamos el precio en el data-atributo

                    // Convertimos los alérgenos a un formato JSON y los asignamos al dataset
                    div.dataset.alergenos = JSON.stringify(ingrediente.alergenos); // Asegúrate de que 'alergenos' es un array de objetos

                    // Añadimos el ingrediente a la lista de ingredientes disponibles (list1)
                    list1.appendChild(div);

                    // Eventos para el manejo del drag and drop
                    div.addEventListener('dragstart', handleDragStart);
                    div.addEventListener('dragend', handleDragEnd);

                    console.log(div.dataset.id);
                });
            } else {
                console.warn('Paso 5: La API devolvió un array vacío o no válido.');
            }
        })
        .catch(error => console.error('Paso 6: Error al cargar ingredientes:', error)); // En caso de error
}

// Función para manejar el inicio del arrastre
function handleDragStart(event) {
    event.dataTransfer.setData('text/plain', event.target.dataset.id); // Guardamos el ID del ingrediente arrastrado
    event.target.classList.add('dragging'); // Añadimos una clase "dragging" para estilo visual
}

// Función para manejar el fin del arrastre
function handleDragEnd(event) {
    event.target.classList.remove('dragging'); // Eliminamos la clase "dragging" cuando se termina el arrastre
}

// Función para permitir que un área acepte el item arrastrado
function handleDragOver(event) {
    event.preventDefault(); // Necesario para permitir el drop
}

// Función para manejar el drop de los ingredientes en la lista de ingredientes seleccionados
function handleDrop(event, targetList) {
    event.preventDefault(); // Prevenir el comportamiento por defecto
    
    const ingredienteId = event.dataTransfer.getData('text/plain'); // Obtenemos el ID del ingrediente arrastrado
    const draggedElement = document.querySelector(`[data-id='${ingredienteId}']`); // Buscamos el ingrediente en el DOM

    if (!draggedElement || !ingredienteId) {
        console.error('Error: No se encontró el ID del ingrediente.');
        return; // Si no hay ID válido, salimos
    }

    // Mover el ingrediente a la lista de destino (list2)
    if (!targetList.contains(draggedElement)) {
        targetList.appendChild(draggedElement);
    }

    actualizarPrecio(); // Llamar a la función para actualizar el precio

    console.log('ID del ingrediente arrastrado:', ingredienteId);
    
    // Llamar a la función para mostrar los alérgenos del ingrediente
    mostrarAlergenos(ingredienteId); // Aquí llamamos a la función con el ID del ingrediente
}

// Función para actualizar el precio
function actualizarPrecio() {
    const selectedIngredientes = Array.from(list2.querySelectorAll('div'));
    const totalPrecio = selectedIngredientes.reduce((total, ingrediente) => total + parseFloat(ingrediente.dataset.precio), 0);
    precioInput.value = totalPrecio.toFixed(2);
}


// Función para añadir un kebab al carrito
function añadirLineaPedidoAlCarrito(kebab) {
    if (!userId) {
        console.error("No se encontró el ID del usuario.");
        return;
    }

    const nuevaLineaPedido = {
        ID_LineaPedido: null,
        linea_pedidos: {
            cantidad: 1,
            nombre: kebab.nombre,
            precio: kebab.precio,
            ingredientes: kebab.selectedIngredientes // Aquí se incluyen los nombres de los ingredientes
        },
        ID_Pedido: null
    };

    fetch(`./Api/ApiUser.php?idUsuario=${userId}`)
        .then(response => response.json())
        .then(usuario => {
            let carrito = usuario?.carrito || [];
            if (typeof carrito === "string") carrito = JSON.parse(carrito);

            const existente = carrito.find(item => item.linea_pedidos.nombre === kebab.nombre);
            if (existente) {
                existente.linea_pedidos.cantidad += 1;
            } else {
                carrito.push(nuevaLineaPedido);
            }

            fetch('./Api/ApiUser.php', {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ ...usuario, carrito: JSON.stringify(carrito) })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log("Carrito actualizado en el servidor.");
                        alert('Kebab añadido al carrito.');
                    } else {
                        console.error("Error al actualizar el carrito en el servidor.");
                    }
                })
                .catch(error => console.error("Error al enviar el carrito al servidor:", error));
        })
        .catch(error => console.error("Error al cargar los datos del usuario desde el servidor:", error));
}


// Enviar el formulario
form.addEventListener('submit', async function (event) {
    event.preventDefault(); // Prevenimos el envío por defecto del formulario

    // Obtenemos los datos del formulario
    const nombre = document.getElementById('nombre').value || "Kebab Personalizado"; // Valor predeterminado si está vacío
    const foto = 'kebabGusto.jpg'; // Foto predeterminada
    const precio = parseFloat(precioInput.value); // Obtener el precio calculado
    const selectedIngredientes = Array.from(list2.querySelectorAll('div')).map(div => div.textContent.split(' - ')[0]); // Obtener nombres de los ingredientes seleccionados

    // Mostrar los datos extraídos del formulario en consola
    console.log('Formulario extraído:', {
        nombre,
        foto,
        precio,
        selectedIngredientes
    });

    // Validamos que todos los campos necesarios estén completos
    if (!nombre.trim()) {
        console.error('Error: El nombre del kebab no puede estar vacío.');
        return;
    }

    if (isNaN(precio) || precio <= 0) {
        console.error('Error: El precio debe ser un valor numérico positivo.');
        return;
    }

    if (selectedIngredientes.length === 0) {
        console.error('Error: Debes seleccionar al menos un ingrediente.');
        return;
    }

    // Crear el objeto para enviar al carrito
    const kebabData = {
        nombre,
        foto,
        precio,
        selectedIngredientes
    };

    // Llamar a la función para añadir el kebab al carrito
    try {
        console.log('Enviando JSON al servidor:', JSON.stringify(kebabData));
        await añadirLineaPedidoAlCarrito(kebabData); // Función async para manejar la lógica del carrito
        alert('Kebab añadido al carrito correctamente.');
    } catch (error) {
        console.error('Error al añadir el kebab al carrito:', error);
        alert('Ocurrió un error al añadir el kebab al carrito. Por favor, inténtalo de nuevo.');
    }
});

// Asignar eventos para las listas de ingredientes
if (list1 && list2) {
    list1.addEventListener('dragover', handleDragOver); // Permitir el arrastre sobre la lista de ingredientes disponibles
    list1.addEventListener('drop', (event) => handleDrop(event, list1)); // Manejar el drop en la lista de ingredientes disponibles
    list2.addEventListener('dragover', handleDragOver); // Permitir el arrastre sobre la lista de ingredientes seleccionados
    list2.addEventListener('drop', (event) => handleDrop(event, list2)); // Manejar el drop en la lista de ingredientes seleccionados
} else {
    console.error("No se encontraron los elementos list1 o list2 en el DOM.");
}

// Función para mostrar los alérgenos con sus fotos
function mostrarAlergenos(ingredienteId) {
    const ingredienteElement = document.querySelector(`[data-id='${ingredienteId}']`);
    if (!ingredienteElement) {
        console.error('Error: Ingrediente no encontrado.');
        return;
    }

    const alergenos = JSON.parse(ingredienteElement.dataset.alergenos); // Obtenemos los alérgenos del ingrediente

    if (alergenos && alergenos.length > 0) {
        // Limpiar el contenedor de alérgenos
        alergenosContainer.innerHTML = '';

        // Iteramos sobre los alérgenos y mostramos solo el nombre
        alergenos.forEach(alergeno => {
            const div = document.createElement('div');
            div.textContent = alergeno.tipo; // Mostrar solo el nombre del alérgeno
            alergenosContainer.appendChild(div); // Añadimos el nombre al contenedor de alérgenos
        });
    } else {
        // Si no hay alérgenos, mostrar un mensaje
        alergenosContainer.innerHTML = 'Este ingrediente no tiene alérgenos registrados.';
    }
}
