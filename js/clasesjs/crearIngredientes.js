// Referencias a los elementos HTML
const form = document.getElementById('drag-drop-form');  // Referencia al formulario con id 'drag-drop-form'
const list1 = document.getElementById('list1')?.querySelector('.list-items');  // Lista de alérgenos disponibles para arrastrar (list1)
const list2 = document.getElementById('list2')?.querySelector('.list-items');  // Lista donde se pueden soltar los alérgenos seleccionados (list2)
const btn = document.querySelector('.btn');  // Referencia al botón (no se usa en el código, pero está disponible)

// Validamos que las listas existan
if (!list1 || !list2) {
    console.error('Error: No se encontraron los elementos "list1" o "list2" en el HTML.');
}

loadAlergenos();  // Llamada a la función para cargar los alérgenos desde la API.

// Función para cargar los alérgenos desde ApiAlergenos.php
async function loadAlergenos() {
    await fetch('./Api/ApiAlergenos.php')  // Solicitud fetch a la API para obtener los alérgenos
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);  // Si la respuesta no es exitosa, muestra un error.
            }
            return response.json();  // Convierte la respuesta en formato JSON.
        })
        .then(data => {
            console.log('Paso 3: Datos de la API recibidos:', data);
            if (Array.isArray(data) && data.length > 0) {  // Verifica que los datos sean un array no vacío.
                data.forEach(alergeno => {  // Recorre los alérgenos recibidos.
                    console.log('Paso 4: Procesando alérgeno:', alergeno);

                    const div = document.createElement('div');  // Crea un nuevo div para el alérgeno.
                    div.className = 'list';  // Asigna la clase 'list' al div.
                    div.textContent = alergeno.tipo;  // Muestra el nombre del alérgeno.
                    div.draggable = true;  // Hace que el div sea arrastrable.
                    div.dataset.id = alergeno.ID_Alergenos;  // Asigna el ID del alérgeno al div como dato.

                    list1.appendChild(div);  // Añade el div a la lista 'list1'.

                    // Añade eventos para manejar el arrastre (drag and drop)
                    div.addEventListener('dragstart', handleDragStart);  // Evento para el inicio del arrastre.
                    div.addEventListener('dragend', handleDragEnd);  // Evento para cuando termina el arrastre.
                });
            } else {
                console.warn('Paso 5: La API devolvió un array vacío o no válido.');
            }
        })
        .catch(error => console.error('Paso 6: Error al cargar alérgenos:', error));
}

// Función para manejar el inicio del arrastre
function handleDragStart(event) {
    event.dataTransfer.setData('text/plain', event.target.dataset.id);  // Guarda el ID del elemento arrastrado en el objeto dataTransfer.
    event.target.classList.add('dragging');  // Añade la clase 'dragging' al elemento arrastrado para estilizarlo.
}

// Función para manejar el fin del arrastre
function handleDragEnd(event) {
    event.target.classList.remove('dragging');  // Elimina la clase 'dragging' del elemento arrastrado al finalizar el arrastre.
}

// Función para permitir que un área acepte el item arrastrado
function handleDragOver(event) {
    event.preventDefault();  // Necesario para permitir el 'drop' en el área de destino.
}

// Función para manejar el drop de los alérgenos
function handleDrop(event, targetList) {
    event.preventDefault();  // Prevenir el comportamiento por defecto (para que funcione el drop).
    const alergenoId = event.dataTransfer.getData('text/plain');  // Obtiene el ID del alérgeno arrastrado.
    const draggedElement = document.querySelector(`[data-id='${alergenoId}']`);  // Obtiene el elemento arrastrado por su ID.

    if (!draggedElement) return;  // Si no existe el elemento arrastrado, se detiene la función.

    // Mueve el elemento directamente a la lista de destino si no está ya presente
    if (!targetList.contains(draggedElement)) {
        targetList.appendChild(draggedElement);
    }
}

// Función para crear un nuevo ingrediente
function createIngrediente(nombre, foto, precio, tipo) {
    const formData = new FormData();  // Crea un objeto FormData para enviar los datos del formulario.
    formData.append('nombre', nombre);  // Añade el nombre del ingrediente.
    formData.append('foto', foto);  // Añade el archivo de la foto.
    formData.append('precio', precio);  // Añade el precio del ingrediente.
    formData.append('tipo', tipo);  // Añade el tipo del ingrediente.

    // Envia los datos del ingrediente a la API para crearlo
    return fetch('./Api/ApiIngredientes.php', {
        method: 'POST',
        body: formData  // Envia el formulario con los datos del ingrediente.
    })
        .then(response => response.json())  // Convierte la respuesta en formato JSON.
        .then(data => {
            console.log('Ingrediente creado:', data);  // Muestra en consola el ingrediente creado.
            return data;  // Devuelve el ingrediente creado.
        })
        .catch(error => console.error('Error al crear ingrediente:', error));  // Captura errores en el proceso.
}

// Función para relacionar el ingrediente con los alérgenos seleccionados
function relateIngredienteAlergenos(ingredienteId, alergenos) {
    const formData = new FormData();  // Crea un objeto FormData para enviar los datos de la relación.
    formData.append('ingrediente_id', ingredienteId);  // Añade el ID del ingrediente.
    formData.append('alergenos', JSON.stringify(alergenos));  // Convierte el array de alérgenos a JSON y lo añade.

    // Envia los datos a la API para establecer la relación entre ingrediente y alérgenos
    return fetch('./Api/ApiIngredientesAlergenos.php', {
        method: 'POST',
        body: formData  // Envia el formulario con los datos de la relación.
    })
        .then(response => response.json())  // Convierte la respuesta en formato JSON.
        .then(data => {
            console.log('Relación establecida:', data);  // Muestra la relación establecida en consola.
        })
        .catch(error => console.error('Error al relacionar alérgenos:', error));  // Captura errores en el proceso.
}

// Enviar el formulario
form.addEventListener('submit', async function (event) {
    event.preventDefault();  // Prevenir el envío por defecto del formulario.

    // Obtener los datos del formulario
    const nombre = document.getElementById('nombre').value;
    const fotoFile = document.getElementById('foto').files[0];  // Obtener el archivo de imagen seleccionado.
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
        foto: fotoFile.name,  // Envía solo el nombre del archivo
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
            body: JSON.stringify(ingredienteData)  // Envía el JSON al servidor.
        });

        // Verificamos si la respuesta fue exitosa
        if (!response.ok) {
            const errorMessage = await response.json();  // Obtener texto de la respuesta si hay error.
            throw new Error(`Error ${response.status}: ${errorMessage}`);
        }

        const data = await response.text();  // Obtiene la respuesta del servidor.
        console.log(data);  // Muestra la respuesta en consola.

        // Limpiar los campos del formulario y la lista de alérgenos seleccionados
        form.reset();
        list2.innerHTML = '';
        location.reload(true); // Recargar la página
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
    document.getElementById('foto').click();  // Simula un clic en el input de tipo "file"
});

// Evento para mostrar la vista previa de la imagen seleccionada
document.getElementById('foto').addEventListener('change', mostrarVistaPrevia);

// Función para mostrar la vista previa de la imagen
function mostrarVistaPrevia(event) {
    const file = event.target.files[0];  // Obtener el archivo seleccionado.

    if (file) {
        const reader = new FileReader();  // Crear un lector de archivos.
        reader.onload = function (e) {
            const previewContainer = document.querySelector('.preview-container');
            previewContainer.style.backgroundImage = `url(${e.target.result})`;  // Establece la vista previa como fondo.
            previewContainer.style.backgroundSize = 'cover';
            previewContainer.style.backgroundPosition = 'center';

            const span = previewContainer.querySelector('span');
            if (span) span.style.display = 'none';  // Oculta el texto inicial si se muestra la vista previa.
        };
        reader.readAsDataURL(file);  // Lee el archivo como Data URL.
    } else {
        const previewContainer = document.querySelector('.preview-container');
        previewContainer.style.backgroundImage = '';  // Reinicia el fondo si no hay archivo.
        const span = previewContainer.querySelector('span');
        if (span) span.style.display = 'block';  // Muestra el texto inicial si no se seleccionó imagen.
    }
}
