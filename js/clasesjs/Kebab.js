window.addEventListener('load', cargarKebabs());

// Función para cargar los kebabs desde la API
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

// Función para mostrar las tarjetas de los kebabs en la cuadrícula
function mostrarKebabs(kebabs) {
    const contenedor = document.querySelector('.product-grid');

    // Limpiar tarjetas de kebabs existentes
    const tarjetasKebabs = contenedor.querySelectorAll('.product-item');
    tarjetasKebabs.forEach(tarjeta => tarjeta.remove());

    kebabs.forEach(kebab => {
        const tarjeta = document.createElement('a');
        tarjeta.classList.add('product-item');
        tarjeta.setAttribute('data-id', kebab.id_kebab);

        // Crear estructura HTML de la tarjeta
        const sidebarImage = document.createElement('div');
        sidebarImage.classList.add('sidebar-image');
        sidebarImage.style.backgroundImage = `url('http://localhost/SERVIDOR/wrap&roll/images/${kebab.foto}')`;

        const kebabName = document.createElement('h3');
        kebabName.textContent = kebab.nombre;

        const kebabPrice = document.createElement('p');
        kebabPrice.textContent = `${kebab.precio} €`;

        // Agregar todo al item de kebab
        tarjeta.appendChild(sidebarImage);
        tarjeta.appendChild(kebabName);
        tarjeta.appendChild(kebabPrice);

        // Insertar el item de kebab en el contenedor
        contenedor.appendChild(tarjeta);
    });
}


