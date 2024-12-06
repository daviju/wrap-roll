document.addEventListener('DOMContentLoaded', async () => {
    const cartContainer = document.getElementById('cart-container');
    const userId = cartContainer.getAttribute('data-user-id');
    let carrito = cartContainer.getAttribute('data-carrito');
    const userMonedero = parseFloat(cartContainer.getAttribute('data-monedero')) || 0;

    console.log('Valor de carrito antes de parsear:', carrito); // Ver el valor de carrito antes de parsear
    console.log('Tipo de carrito:', typeof carrito); // Verificar el tipo de dato

    try {
        carrito = JSON.parse(carrito); // Ahora carrito es un array de objetos JSON
        console.log('Carrito después de parsear:', carrito); // Ver el carrito después de parsear
        console.log('Tipo de carrito después de parsear:', typeof carrito); // Verificar el tipo de dato
        console.log('Es un array:', Array.isArray(carrito)); // Verificar si es un array
    
        // Verificar que carrito es un array
        if (!Array.isArray(carrito) || carrito.length === 0) {
            console.error("El carrito no es un array válido o está vacío:", carrito);
            carrito = []; // Si no es un array o está vacío, inicializar como vacío
        }
    } catch (error) {
        console.error("Error al procesar el carrito:", error);
        carrito = []; // Inicializar como vacío en caso de error
    }

    // Mostrar el monedero en la página
    const currentCreditElement = document.getElementById('current-credit');
    if (currentCreditElement) {
        currentCreditElement.textContent = `${userMonedero.toFixed(2)}€`;
    }

    // Cargar las direcciones del usuario
    if (userId) {
        await loadAddresses(userId);
    } else {
        console.error('No se pudo obtener el ID del usuario.');
    }

    // Cargar el carrito
    cargarCarrito(carrito);

    // Función para cargar las direcciones del usuario desde la API
    async function loadAddresses(userId) {
        try {
            const response = await fetch(`./Api/ApiDireccion.php?idUsuario=${userId}`);
            if (!response.ok) throw new Error('No se pudo obtener las direcciones');
            const data = await response.json();
            const addressSelect = document.getElementById('address');
            addressSelect.innerHTML = ''; // Limpiar el select antes de agregar nuevas opciones
            if (data.error) {
                console.error(data.error);
                return;
            }
            // Si no hay direcciones, agrega una opción por defecto
            if (data.length === 0) {
                const option = document.createElement('option');
                option.textContent = 'No hay direcciones disponibles';
                addressSelect.appendChild(option);
            } else {
                // Agregar las direcciones al select
                data.forEach(address => {
                    const option = document.createElement('option');
                    option.textContent = `${address.tipovia} ${address.nombrevia}, ${address.numero}` + `${address.puerta ? ', Puerta: ' + address.puerta : ''}` + `${address.escalera ? ', Escalera: ' + address.escalera : ''}` + `${address.planta ? ', Planta: ' + address.planta : ''}` + `${address.localidad ? ', ' + address.localidad : ''}`;
                    addressSelect.appendChild(option);
                });
            }
        } catch (error) {
            console.error("Error al cargar las direcciones:", error);
        }
    }

    // Función para cargar el carrito
    function cargarCarrito(carrito) {
        const cartItemsContainer = document.getElementById('cart-items');
        let totalPrice = 0;

        // Limpiar la tabla antes de mostrar los nuevos items
        cartItemsContainer.innerHTML = '';

        // Verificar si el carrito está vacío
        if (carrito.length === 0) {
            cartItemsContainer.innerHTML = '<tr><td colspan="3">Tu carrito está vacío.</td></tr>';
            console.log("El carrito está vacío");
            return;
        }

        carrito.forEach(item => {
            const lineaPedido = item.linea_pedidos;

            if (!lineaPedido) {
                console.error("No se pudo procesar 'linea_pedidos':", item);
                return;
            }

            // Crear una fila para cada item del carrito
            const fila = document.createElement('tr');

            // Celda 1: Cantidad con botones +
            const cantidadCelda = document.createElement('td');
            // Crear los botones de cantidad
            const btnMinus = document.createElement('button');
            btnMinus.textContent = '-';
            btnMinus.classList.add('quantity-btn');
            btnMinus.addEventListener('click', () => {
                // Disminuir cantidad
                if (lineaPedido.cantidad > 1) {
                    lineaPedido.cantidad--;
                    actualizarCarrito();
                }
            });

            const btnPlus = document.createElement('button');
            btnPlus.textContent = '+';
            btnPlus.classList.add('quantity-btn');
            btnPlus.addEventListener('click', () => {
                // Aumentar cantidad
                lineaPedido.cantidad++;
                actualizarCarrito();
            });

            const cantidadText = document.createElement('span');
            cantidadText.textContent = lineaPedido.cantidad;

            // Añadir los botones y el texto de cantidad a la celda
            cantidadCelda.appendChild(btnMinus);
            cantidadCelda.appendChild(cantidadText);
            cantidadCelda.appendChild(btnPlus);
            fila.appendChild(cantidadCelda);

            // Celda 2: Kebab (sin precio)
            const kebabCelda = document.createElement('td');
            kebabCelda.textContent = `${lineaPedido.nombre} (${lineaPedido.ingredientes.join(', ')})`;
            fila.appendChild(kebabCelda);

            // Celda 3: Precio
            const precioCelda = document.createElement('td');
            const precioTotal = lineaPedido.cantidad * lineaPedido.precio;
            precioCelda.textContent = `${precioTotal.toFixed(2)}€`;
            fila.appendChild(precioCelda);

            // Agregar la fila a la tabla
            cartItemsContainer.appendChild(fila);

            // Sumar el precio total
            totalPrice += precioTotal;
        });

        // Actualizar el precio total
        const totalPriceElement = document.getElementById('total-price');
        if (totalPriceElement) {
            totalPriceElement.textContent = `${totalPrice.toFixed(2)}€`;
        }

        // Actualizar el monedero restante
        const remainingCredit = userMonedero - totalPrice;
        const remainingCreditElement = document.getElementById('remaining-credit');
        if (remainingCreditElement) {
            remainingCreditElement.textContent = `${remainingCredit.toFixed(2)}€`;
        }
    }

    // Función para actualizar el carrito
    function actualizarCarrito() {
        console.log('Carrito actualizado');
        // Aquí iría el código para actualizar el carrito en el servidor (ej. haciendo una solicitud AJAX)
    }

    // Función para tramitar el pedido
    document.getElementById('order-btn').addEventListener('click', async () => {
        const totalPrice = parseFloat(document.getElementById('total-price').textContent.replace('€', ''));
        const currentCredit = parseFloat(document.getElementById('current-credit').textContent.replace('€', ''));

        // Verificar si el usuario tiene suficiente crédito
        if (currentCredit >= totalPrice) {
            // Si tiene suficiente crédito, actualizar el crédito restante
            const remainingCredit = currentCredit - totalPrice;
            document.getElementById('remaining-credit').textContent = `${remainingCredit.toFixed(2)}€`;
            alert("Pedido realizado con éxito");
            // Aquí podrías agregar la lógica para guardar el pedido en la base de datos
        } else {
            // Si no tiene suficiente crédito
            alert("No tienes suficiente crédito para realizar este pedido.");
        }
    });
});
