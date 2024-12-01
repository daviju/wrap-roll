console.log('Paso 1: La página ha cargado.');

// Referencias a los elementos HTML
const form = document.getElementById('drag-drop-form');
const list1 = document.getElementById('list1')?.querySelector('.list-items');
const list2 = document.getElementById('list2')?.querySelector('.list-items');
const btn = document.querySelector('.btn');

// Validamos que las listas existan
if (!list1 || !list2) {
    console.error('Error: No se encontraron los elementos "list1" o "list2" en el HTML.');
}

console.log('Paso 2: Ejecutando loadIngredientes...');
loadIngredientes();

// Función para cargar los ingredientes desde ApiIngredientes.php
async function loadIngredientes() {
    await fetch('./Api/ApiIngredientes.php')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Paso 3: Datos de la API recibidos:', data);
            if (Array.isArray(data) && data.length > 0) {
                data.forEach(ingrediente => {
                    console.log('Paso 4: Procesando ingrediente:', ingrediente);

                    const div = document.createElement('div');
                    div.className = 'list';
                    div.textContent = ingrediente.nombre; // Campo "nombre" de la API
                    div.draggable = true;
                    div.dataset.id = ingrediente.idIngredientes; // Campo "idIngredientes" de la API
                    list1.appendChild(div);

                    // Eventos para drag and drop
                    div.addEventListener('dragstart', handleDragStart);
                    div.addEventListener('dragend', handleDragEnd);
                });
            } else {
                console.warn('Paso 5: La API devolvió un array vacío o no válido.');
            }
        })
        .catch(error => console.error('Paso 6: Error al cargar ingredientes:', error));
}

// Función para manejar el inicio del arrastre
function handleDragStart(event) {
    event.dataTransfer.setData('text/plain', event.target.dataset.id); // Guardar el ID
    event.target.classList.add('dragging');
}

// Función para manejar el fin del arrastre
function handleDragEnd(event) {
    event.target.classList.remove('dragging');
}

// Función para permitir que un área acepte el item arrastrado
function handleDragOver(event) {
    event.preventDefault(); // Necesario para permitir el drop
}

// Función para manejar el drop de los ingredientes
function handleDrop(event, targetList) {
    event.preventDefault();
    const ingredienteId = event.dataTransfer.getData('text/plain'); // Obtenemos el ID del ingrediente
    const draggedElement = document.querySelector(`[data-id='${ingredienteId}']`);

    if (!draggedElement) return;

    // Mover el elemento directamente a la lista objetivo
    if (!targetList.contains(draggedElement)) {
        targetList.appendChild(draggedElement);
    }
}

// Función para crear un nuevo kebab
function createKebab(nombre, foto, precio) {
    const formData = new FormData();
    formData.append('nombre', nombre);
    formData.append('foto', foto);
    formData.append('precio', precio);

    return fetch('./Api/ApiKebabs.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            console.log('Kebab creado:', data);
            return data; // Devuelve el kebab creado
        })
        .catch(error => console.error('Error al crear kebab:', error));
}

// Enviar el formulario
form.addEventListener('submit', async function (event) {
    event.preventDefault(); // Prevenir el envío por defecto del formulario

    // Obtener los datos del formulario
    const nombre = document.getElementById('nombre').value;
    const fotoFile = document.getElementById('foto').files[0]; // Archivo de imagen seleccionado
    const precio = parseFloat(document.getElementById('precio').value);

    // Obtener los IDs de los ingredientes seleccionados en list2
    const selectedIngredientes = Array.from(list2.querySelectorAll('div')).map(div => div.dataset.id);

    // Mostrar los datos extraídos del formulario
    console.log('Formulario extraído:');
    console.log('Nombre:', nombre);
    console.log('Foto seleccionada:', fotoFile ? fotoFile.name : 'No se seleccionó imagen');
    console.log('Precio:', precio);
    console.log('Ingredientes seleccionados:', selectedIngredientes);

    // Validar que haya datos necesarios
    if (!nombre || isNaN(precio)) {
        console.error('Error: Todos los campos del formulario son obligatorios.');
        return;
    }

    if (!fotoFile) {
        console.error('Error: Debes seleccionar una imagen.');
        return;
    }

    if (selectedIngredientes.length === 0) {
        console.error('Error: Debes seleccionar al menos un ingrediente.');
        return;
    }

    // Crear el JSON para enviar (fotoFile.name es el nombre del archivo seleccionado)
    const kebabData = {
        nombre,
        precio,
        foto: fotoFile.name, // Envía solo el nombre del archivo
        selectedIngredientes
    };

    console.log('Enviando JSON al servidor:', JSON.stringify(kebabData));

    // Llamar a la API para crear el kebab
    try {
        const response = await fetch('./Api/ApiKebabs.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(kebabData)
        });

        console.log('Respuesta del servidor al crear kebab:', response);

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        console.log('Kebab creado correctamente en la API:', data);

        // Limpiar los campos del formulario y la lista de ingredientes seleccionados
        form.reset();
        list2.innerHTML = '';
    } catch (error) {
        console.error('Error al crear kebab:', error);
    }
});

// Asignar eventos para las listas
list1.addEventListener('dragover', handleDragOver);
list1.addEventListener('drop', (event) => handleDrop(event, list1));

list2.addEventListener('dragover', handleDragOver);
list2.addEventListener('drop', (event) => handleDrop(event, list2));

// Evento para activar el input de archivo al hacer clic en el contenedor
document.querySelector('.preview-container').addEventListener('click', () => {
    document.getElementById('foto').click(); // Simula un clic en el input de tipo "file"
});

// Evento para mostrar la vista previa de la imagen seleccionada
document.getElementById('foto').addEventListener('change', mostrarVistaPrevia);

// Función para mostrar la vista previa de la imagen
function mostrarVistaPrevia(event) {
    const file = event.target.files[0]; // Obtener el archivo seleccionado

    if (file) {
        const reader = new FileReader(); // Crear un lector de archivos
        reader.onload = function (e) {
            const previewContainer = document.querySelector('.preview-container');
            previewContainer.style.backgroundImage = `url(${e.target.result})`;
            previewContainer.style.backgroundSize = 'cover';
            previewContainer.style.backgroundPosition = 'center';

            const span = previewContainer.querySelector('span');
            if (span) span.style.display = 'none'; // Ocultar texto inicial
        };
        reader.readAsDataURL(file); // Leer archivo como Data URL
    } else {
        const previewContainer = document.querySelector('.preview-container');
        previewContainer.style.backgroundImage = ''; // Reiniciar el fondo
        const span = previewContainer.querySelector('span');
        if (span) span.style.display = 'block'; // Mostrar texto inicial
    }
}
