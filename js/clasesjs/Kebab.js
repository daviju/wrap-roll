document.addEventListener("DOMContentLoaded", function() {
    // Log para confirmar que el script se está ejecutando
    console.log("Página cargada, intentando cargar kebabs...");

    // Hacemos la solicitud a la API
    fetch('./Api/ApiKebab.php')
    .then(response => {
        console.log("Respuesta recibida de la API:", response);  // Log para verificar si la respuesta es correcta
        
        if (!response.ok) {
            throw new Error('Error al cargar los datos');
        }
        return response.json();
    })
    .then(kebabs => {
        // Mostrar los datos recibidos en la consola
        console.log("Datos de kebabs:", kebabs);  // Esto nos mostrará el array de kebabs en la consola
        mostrarKebabs(kebabs);  // Llamamos a la función para mostrar los kebabs
    })
    .catch(error => {
        // Si ocurre un error en la solicitud o en la conversión de JSON
        console.error('Error al cargar los kebabs:', error);
    });
});

// Función para mostrar los kebabs en la página
function mostrarKebabs(kebabs) {
    // Seleccionamos el contenedor de los productos
    const productGrid = document.querySelector('.product-grid');
    productGrid.innerHTML = ''; // Limpiamos cualquier contenido previo

    // Recorremos todos los kebabs recibidos
    kebabs.forEach(kebab => {
        // Creamos el contenedor para cada kebab
        const productItem = document.createElement('a');
        productItem.classList.add('product-item');

        // Creamos el contenedor para la imagen del kebab
        const sidebarImage = document.createElement('div');
        sidebarImage.classList.add('sidebar-image');
        sidebarImage.style.backgroundImage = `url('./images/${kebab.foto}')`;  // Ruta de la imagen
        productItem.appendChild(sidebarImage);

        // Creamos el nombre del kebab
        const kebabName = document.createElement('h3');
        kebabName.textContent = kebab.nombre;
        productItem.appendChild(kebabName);

        // Creamos el precio del kebab
        const kebabPrice = document.createElement('p');
        kebabPrice.textContent = `${kebab.precio} €`;
        productItem.appendChild(kebabPrice);

        // Añadimos el kebab al grid de productos
        productGrid.appendChild(productItem);
    });
}
