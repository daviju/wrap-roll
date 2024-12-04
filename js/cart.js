// Función para cargar las direcciones del usuario desde la API
async function loadAddresses(userId) {
    try {
        const response = await fetch(`http://www.daviju.es/Api/ApiDireccion.php?idUsuario=${userId}`);
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
                option.textContent = `${address.tipovia} ${address.nombrevia}, ${address.numero}` +
                                     `${address.puerta ? ', Puerta: ' + address.puerta : ''}` +
                                     `${address.escalera ? ', Escalera: ' + address.escalera : ''}` +
                                     `${address.planta ? ', Planta: ' + address.planta : ''}` +
                                     `${address.localidad ? ', ' + address.localidad : ''}`;
                addressSelect.appendChild(option);
            });
        }
    } catch (error) {
        console.error("Error al cargar las direcciones:", error);
    }
}

// Función para cargar el carrito desde el localStorage
function cargarCarrito() {
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    const cartItemsContainer = document.getElementById('cart-items');
    let totalPrice = 0;

    // Limpiar la tabla antes de mostrar los nuevos items
    cartItemsContainer.innerHTML = '';

    carrito.forEach(item => {
        const lineaPedido = JSON.parse(item.linea_pedidos); // Obtener el objeto JSON

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

        // Sumar el precio total para calcular el total
        totalPrice += precioTotal;
    });

    // Actualizar el precio total
    document.getElementById('total-price').textContent = `${totalPrice.toFixed(2)}€`;

    // Calcular el crédito restante después de tramitar
    const currentCredit = parseFloat(document.getElementById('current-credit').textContent.replace('€', ''));
    const remainingCredit = currentCredit - totalPrice;

    // Mostrar el crédito restante
    document.getElementById('remaining-credit').textContent = `${remainingCredit.toFixed(2)}€`;
}

// Función para actualizar el carrito en el localStorage
function actualizarCarrito() {
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    localStorage.setItem('carrito', JSON.stringify(carrito));
    cargarCarrito(); // Volver a cargar el carrito actualizado
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

        // Mostrar mensaje de éxito
        alert("Pedido procesado correctamente");
    } else {
        // Si no tiene suficiente crédito, mostrar un mensaje de error
        alert("No tienes suficiente crédito para tramitar el pedido.");
    }
});

// Obtener el ID del usuario desde el atributo data
document.addEventListener('DOMContentLoaded', async () => {
    const cartContainer = document.getElementById('cart-container');
    const userId = cartContainer.getAttribute('data-user-id');

    if (userId) {
        // Cargar las direcciones desde la API
        await loadAddresses(userId);
    } else {
        console.error('No se pudo obtener el ID del usuario.');
    }

    // Cargar el carrito desde el localStorage
    cargarCarrito();
});
