<?php
// Suponiendo que tienes una sesión con el rol del usuario, pasamos el valor a JS
$role = isset($_SESSION['user']) ? $_SESSION['user']->rol : '';
?>

<link rel="stylesheet" href="./css/kebdecasaStyle.css">

<div class="menu-container">
    <h2>Nuestros Kebabs</h2>
    <div class="product-grid">
        <!-- Los kebabs se agregarán dinámicamente aquí -->
    </div>

    <div class="space-filler"></div> <!-- Contenedor vacío para el espacio -->
</div>

<script>
    // Pasamos la variable de rol a JavaScript
    const userRole = '<?php echo $role; ?>';

    // Se crea un carrito vacío en el localStorage (puedes usar sessionStorage también)
    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

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

    // Función para mostrar los kebabs en la página
    function mostrarKebabs(kebabs) {
        const contenedor = document.querySelector('.product-grid');
        contenedor.innerHTML = ''; // Limpiar el contenedor antes de agregar los nuevos kebabs

        kebabs.forEach(kebab => {
            const tarjeta = document.createElement('a');
            tarjeta.classList.add('product-item');
            tarjeta.setAttribute('data-id', kebab.ID_Kebab);

            // Crear estructura HTML de la tarjeta
            const sidebarImage = document.createElement('div');
            sidebarImage.classList.add('sidebar-image');

            // Verifica si hay una foto del kebab, si no asigna una imagen predeterminada
            const kebabImageUrl = kebab.foto ? `./images/${kebab.foto}` : "./images/kebabBase.png";
            sidebarImage.style.backgroundImage = `url('${kebabImageUrl}')`;


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
                        const ingredientesNombres = ingredientesData.join(', ');
                        ingredientesList.textContent += ingredientesNombres;
                    } else {
                        ingredientesList.textContent += 'Sin ingredientes disponibles';
                    }
                })
                .catch(error => {
                    console.error("Error al cargar los ingredientes:", error);
                    ingredientesList.textContent += 'Error al cargar los ingredientes';
                })
                .finally(() => {
                    // Agregar todo al item de kebab después de la carga de los ingredientes
                    tarjeta.appendChild(sidebarImage);
                    tarjeta.appendChild(kebabName);
                    tarjeta.appendChild(kebabPrice);
                    tarjeta.appendChild(ingredientesList);

                    // Mostrar el botón "Añadir al carrito" si el usuario está logueado
                    if (userRole) {
                        const botonCarrito = document.createElement('button');
                        botonCarrito.classList.add('boton-carrito');
                        botonCarrito.textContent = 'Añadir al carrito';
                        botonCarrito.addEventListener('click', () => añadirAlCarrito(kebab));
                        tarjeta.appendChild(botonCarrito);
                    }

                    // Agregar los botones si el usuario es admin
                    if (userRole === 'Admin') {
                        const botonesContainer = document.createElement('div');
                        botonesContainer.classList.add('botones-container');

                        const botonModificar = document.createElement('button');
                        botonModificar.classList.add('boton-modificar');
                        botonModificar.textContent = 'Modificar';

                        const botonBorrar = document.createElement('button');
                        botonBorrar.classList.add('boton-borrar');
                        botonBorrar.textContent = 'Borrar';

                        botonesContainer.appendChild(botonModificar);
                        botonesContainer.appendChild(botonBorrar);

                        tarjeta.appendChild(botonesContainer);
                    }

                    // Insertar el item de kebab en el contenedor
                    contenedor.appendChild(tarjeta);
                });
        });
    }

    // Función para añadir un kebab al carrito
    function añadirAlCarrito(kebab) {
        // Obtener los ingredientes asociados al kebab usando fetch
        fetch(`./Api/ApiKebabIngredientes.php?ID_Kebab=${kebab.ID_Kebab}`)
            .then(response => response.json())
            .then(ingredientesData => {
                if (Array.isArray(ingredientesData)) {
                    // Crear el objeto de la línea de pedido con el formato que requiere tu clase LineaPedido
                    const lineaPedido = {
                        kebabId: kebab.ID_Kebab,
                        nombre: kebab.nombre,
                        precio: kebab.precio,
                        cantidad: 1, // Cantidad predeterminada
                        ingredientes: ingredientesData, // Aquí se usan los ingredientes obtenidos
                        pedidosId: null // El id de Pedido es nulo por ahora
                    };

                    // Crear el JSON para el atributo linea_pedidos
                    const lineaPedidosJSON = {
                        cantidad: lineaPedido.cantidad,
                        nombre: lineaPedido.nombre,
                        precio: lineaPedido.precio,
                        ingredientes: lineaPedido.ingredientes
                    };

                    // Crear el objeto LineaPedido
                    const nuevaLineaPedido = {
                        ID_LineaPedido: null, // El ID de la línea de pedido aún no lo tenemos
                        linea_pedidos: JSON.stringify(lineaPedidosJSON), // Convertimos el objeto a JSON
                        ID_Pedido: null // El ID del pedido aún es nulo
                    };

                    // Guardar la línea de pedido en el carrito (localStorage)
                    carrito.push(nuevaLineaPedido);
                    localStorage.setItem('carrito', JSON.stringify(carrito));

                    console.log(nuevaLineaPedido);
                    console.log(carrito);
                    console.log(lineaPedido);
                    console.log(lineaPedidosJSON);

                    alert('Kebab añadido al carrito.');
                } else {
                    console.error("Error al cargar los ingredientes del kebab.");
                }
            })
            .catch(error => {
                console.error("Error al cargar los ingredientes:", error);
            });
    }
</script>