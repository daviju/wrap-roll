console.log('Paso 1: La página ha cargado.');
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

console.log('Paso 2: Ejecutando loadAlergenos...');
loadAlergenos();

// Función para cargar los alérgenos desde ApiAlergenos.php
async function loadAlergenos() {
    await fetch('./Api/ApiAlergenos.php')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Paso 3: Datos de la API recibidos:', data);
            if (Array.isArray(data) && data.length > 0) {
                data.forEach(alergeno => {
                    console.log('Paso 4: Procesando alérgeno:', alergeno);

                    const div = document.createElement('div');
                    div.className = 'list';
                    div.textContent = alergeno.tipo; // Campo "tipo" de la API
                    div.draggable = true;
                    div.dataset.id = alergeno.ID_Alergenos; // Campo "ID_Alergenos" de la API
                    list1.appendChild(div);

                    // Eventos para drag and drop
                    div.addEventListener('dragstart', handleDragStart);
                    div.addEventListener('dragend', handleDragEnd);
                });
            } else {
                console.warn('Paso 5: La API devolvió un array vacío o no válido.');
            }
        })
        .catch(error => console.error('Paso 6: Error al cargar alérgenos:', error));
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

// Función para manejar el drop de los alérgenos
function handleDrop(event, targetList) {
    event.preventDefault();
    const alergenoId = event.dataTransfer.getData('text/plain'); // Obtenemos el ID del alérgeno
    const draggedElement = document.querySelector(`[data-id='${alergenoId}']`);

    if (!draggedElement) return;

    // Mover el elemento directamente a la lista objetivo
    if (!targetList.contains(draggedElement)) {
        targetList.appendChild(draggedElement);
    }
}


// Función para crear un nuevo ingrediente
function createIngrediente(nombre, foto, precio, tipo) {
    const formData = new FormData();
    formData.append('nombre', nombre);
    formData.append('foto', foto);
    formData.append('precio', precio);
    formData.append('tipo', tipo);

    return fetch('./Api/ApiIngredientes.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            console.log('Ingrediente creado:', data);
            return data; // Devuelve el ingrediente creado
        })
        .catch(error => console.error('Error al crear ingrediente:', error));
}

// Función para relacionar el ingrediente con los alérgenos seleccionados
function relateIngredienteAlergenos(ingredienteId, alergenos) {
    const formData = new FormData();
    formData.append('ingrediente_id', ingredienteId);
    formData.append('alergenos', JSON.stringify(alergenos)); // Convertimos el array a JSON

    return fetch('./Api/ApiIngredientesAlergenos.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            console.log('Relación establecida:', data);
        })
        .catch(error => console.error('Error al relacionar alérgenos:', error));
}

// Enviar el formulario
form.addEventListener('submit', async function (event) {
    event.preventDefault(); // Prevenir el envío por defecto del formulario

    // Obtener los datos del formulario
    const nombre = document.getElementById('nombre').value;
    const fotoFile = document.getElementById('foto').files[0]; // Archivo de imagen seleccionado
    const precio = parseFloat(document.getElementById('precio').value);
    const tipo = document.getElementById('tipo').value;

    // Obtener los IDs de los alérgenos seleccionados en list2
    const selectedAlergenos = Array.from(list2.querySelectorAll('div')).map(div => div.dataset.id);

    // Mostrar los datos extraídos del formulario
    console.log('Formulario extraído:');
    console.log('Nombre:', nombre);
    console.log('Foto seleccionada:', fotoFile ? fotoFile.name : 'No se seleccionó imagen');
    console.log('Precio:', precio);
    console.log('Tipo:', tipo);
    console.log('Alérgenos seleccionados:', selectedAlergenos);

    // Validar que haya datos necesarios
    if (!nombre || isNaN(precio) || !tipo) {
        console.error('Error: Todos los campos del formulario son obligatorios.');
        return;
    }

    if (!fotoFile) {
        console.error('Error: Debes seleccionar una imagen.');
        return;
    }

    if (selectedAlergenos.length === 0) {
        console.error('Error: Debes seleccionar al menos un alérgeno.');
        return;
    }

    // Crear el JSON para enviar (fotoFile.name es el nombre del archivo seleccionado)
    const ingredienteData = {
        nombre,
        precio,
        tipo,
        foto: fotoFile.name, // Envía solo el nombre del archivo
        selectedAlergenos
    };

    // Log para verificar el JSON creado
    console.log('Enviando JSON al servidor:', JSON.stringify(ingredienteData));

    // Llamar a la API para crear el ingrediente
    try {
        const response = await fetch('./Api/ApiIngredientes.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(ingredienteData)
        });

        // Verificamos si la respuesta fue exitosa
        if (!response.ok) {
            const errorMessage = await response.json(); // Obtener texto de la respuesta si hay error
            throw new Error(`Error ${response.status}: ${errorMessage}`);
        }

        const data = await response.text();
        console.log(data);


        // Limpiar los campos del formulario y la lista de alérgenos seleccionados
        form.reset();
        list2.innerHTML = '';
    } catch (error) {
        console.error('Error al crear ingrediente :', error);
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
