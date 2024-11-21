document.addEventListener('DOMContentLoaded', function() {
    // Referencias a los elementos HTML
    const form = document.getElementById('drag-drop-form');
    const list1 = document.getElementById('list1').querySelector('ul');
    const list2 = document.getElementById('list2').querySelector('ul');
    const btn = document.querySelector('.btn');

    // Cargar los alérgenos disponibles al cargar la página
    loadAlergenos();

    // Función para cargar los alérgenos desde ApiAlergenos.php
    function loadAlergenos() {
        fetch('./ApiAlergenos.php')
            .then(response => response.json())
            .then(data => {
                // Añadimos los alérgenos a la lista de "Ingredientes Disponibles"
                data.forEach(alergeno => {
                    const li = document.createElement('li');
                    li.textContent = alergeno.nombre;
                    li.draggable = true;
                    li.dataset.id = alergeno.id;
                    list1.appendChild(li);

                    // Añadir la funcionalidad de arrastrar (dragstart) y soltar (dragend)
                    li.addEventListener('dragstart', handleDragStart);
                    li.addEventListener('dragend', handleDragEnd);
                });
            })
            .catch(error => console.error('Error al cargar alérgenos:', error));
    }

    // Función para manejar el inicio del arrastre
    function handleDragStart(event) {
        // Guardar la referencia del item que está siendo arrastrado
        event.dataTransfer.setData('text/plain', event.target.dataset.id);
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
        const alergenoId = event.dataTransfer.getData('text/plain');
        const draggedElement = document.querySelector(`[data-id='${alergenoId}']`);

        // Si se suelta sobre la lista de alérgenos seleccionados
        if (targetList === list2 && !list2.contains(draggedElement)) {
            const clone = draggedElement.cloneNode(true);
            targetList.appendChild(clone);
            draggedElement.setAttribute('draggable', 'false'); // Desactivar el arrastre de este elemento
        }

        // Si se suelta sobre la lista de alérgenos disponibles
        if (targetList === list1 && !list1.contains(draggedElement)) {
            list1.appendChild(draggedElement);
            draggedElement.setAttribute('draggable', 'true'); // Volver a activar el arrastre
        }
    }

    // Función para crear un nuevo ingrediente a través de ApiIngredientes.php
    function createIngrediente(nombre, foto, precio, tipo) {
        const formData = new FormData();
        formData.append('nombre', nombre);
        formData.append('foto', foto);
        formData.append('precio', precio);
        formData.append('tipo', tipo);

        return fetch('./ApiIngredientes.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => data) // Devuelve el ingrediente creado
        .catch(error => console.error('Error al crear ingrediente:', error));
    }

    // Función para relacionar el ingrediente con los alérgenos seleccionados
    function relateIngredienteAlergenos(ingredienteId, alergenos) {
        const formData = new FormData();
        formData.append('ingrediente_id', ingredienteId);
        formData.append('alergenos', JSON.stringify(alergenos)); // Convertimos el array a JSON

        return fetch('./ApiIngrentesAlergenos.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log('Relación establecida:', data);
            // Puedes mostrar algún mensaje de éxito o redirigir al usuario
        })
        .catch(error => console.error('Error al relacionar alérgenos:', error));
    }

    // Lógica para enviar el formulario
    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevenir el envío por defecto del formulario

        const nombre = document.getElementById('nombre').value;
        const foto = document.getElementById('foto').files[0]; // Se toma el archivo de imagen
        const precio = document.getElementById('precio').value;
        const tipo = document.getElementById('tipo').value;

        // Creamos el ingrediente
        createIngrediente(nombre, foto, precio, tipo)
            .then(ingrediente => {
                // Una vez creado el ingrediente, relacionamos los alérgenos
                const selectedAlergenos = Array.from(list2.querySelectorAll('li')).map(li => li.dataset.id);
                relateIngredienteAlergenos(ingrediente.id, selectedAlergenos);
            })
            .catch(error => console.error('Error al crear ingrediente:', error));
    });

    // Asignar los manejadores de eventos para las listas
    list1.addEventListener('dragover', handleDragOver);
    list1.addEventListener('drop', (event) => handleDrop(event, list1));

    list2.addEventListener('dragover', handleDragOver);
    list2.addEventListener('drop', (event) => handleDrop(event, list2));
});
