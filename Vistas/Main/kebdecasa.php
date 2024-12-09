<?php
// Verifica si el usuario esta en la sesion
$userData = isset($_SESSION['user']) ? $_SESSION['user'] : null;

// El valor de la sesión con el rol del usuario lo pasasmos al JS
$role = isset($_SESSION['user']) ? $_SESSION['user']->rol : '';

// El ID del usuario en la sesión
$userId = isset($_SESSION['user']) ? $_SESSION['user']->idUsuario : '';
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

    // Pasamos los datos del usuario a JavaScript si está logueado
    const userData = <?php echo json_encode($userData); ?>;

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
        // Primero, obtener el carrito actual del usuario desde el servidor
        fetch(`./Api/ApiUser.php?idUsuario=${userData.idUsuario}`)
            .then(response => response.json())
            .then(usuario => {
                if (usuario) {
                    console.log("Usuario obtenido del servidor:", usuario);

                    let carrito = usuario.carrito;

                    console.log("Carrito obtenido del servidor:", carrito);

                    // Asegurarse de que el carrito esté en formato de array
                    if (typeof carrito === "string") {
                        try {
                            carrito = JSON.parse(carrito);

                            console.log("Carrito convertido a array:", carrito);

                        } catch (error) {
                            console.error("Error al parsear el carrito:", error);
                            carrito = [];
                        }
                    }

                    if (!Array.isArray(carrito)) {
                        console.error("El carrito no es un array válido. Inicializando uno nuevo.");
                        carrito = [];
                    }

                    // Crear la nueva línea de pedido
                    fetch(`./Api/ApiKebabIngredientes.php?ID_Kebab=${kebab.ID_Kebab}`)
                        .then(response => response.json())
                        .then(ingredientesData => {
                            if (Array.isArray(ingredientesData)) { // Verificar que ingredientesData sea un array

                                const nuevaLineaPedido = {
                                    ID_LineaPedido: null,
                                    linea_pedidos: {
                                        cantidad: 1,
                                        nombre: kebab.nombre,
                                        precio: kebab.precio,
                                        ingredientes: ingredientesData
                                    },
                                    ID_Pedido: null
                                };

                                // Comprobar si el kebab ya existe en el carrito
                                let existente = carrito.find(item => item.linea_pedidos.nombre === kebab.nombre);

                                if (existente) {
                                    // Incrementar la cantidad si ya existe
                                    existente.linea_pedidos.cantidad += 1;
                                } else {
                                    // Añadir el nuevo kebab al carrito
                                    carrito.push(nuevaLineaPedido);
                                }

                                // Actualizar el carrito en el servidor
                                const usuarioActualizado = {
                                    ...usuario, // Usar el usuario obtenido del servidor
                                    carrito: JSON.stringify(carrito) // Guardar el carrito como JSON string
                                };

                                console.log("Carrito actualizado:", usuarioActualizado);

                                fetch('./Api/ApiUser.php', {
                                        method: 'PUT',
                                        headers: {
                                            'Content-Type': 'application/json'
                                        },
                                        body: JSON.stringify(usuarioActualizado)
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            console.log("Carrito actualizado en el servidor.");
                                        } else {
                                            console.error("Error al actualizar el carrito en el servidor.");
                                        }
                                    })
                                    .catch(error => {
                                        console.error("Error al enviar el carrito al servidor:", error);
                                    });

                                alert('Kebab añadido al carrito.');
                            } else {
                                console.error("Error al cargar los ingredientes del kebab.");
                            }
                        })
                        .catch(error => {
                            console.error("Error al cargar los ingredientes:", error);
                        });
                } else {
                    console.error("Error al obtener los datos del usuario.");
                }
            })
            .catch(error => {
                console.error("Error al cargar los datos del usuario desde el servidor:", error);
            });
    }
</script>