document.addEventListener("DOMContentLoaded", async () => {
    const cartContainer = document.getElementById("cart-container");

    // Obtenemos el ID del usuario desde el atributo data-user-id
    const userId = cartContainer.dataset.userId;
    console.log("Cargando datos para el usuario con ID:", userId);

    if (!userId) {
        console.error("No se pudo obtener el ID del usuario. Asegúrate de que está configurado en el HTML.");
        return;
    }

    try {
        // Obtener datos del usuario y cargar carrito y monedero
        await obtenerDatosUsuario(userId);
    } catch (error) {
        console.error("Error al cargar los datos del usuario:", error);
    }

    // Cargar direcciones si están disponibles
    const direcciones = getDireccionesFromData(cartContainer);
    cargarDirecciones(direcciones);
});

// Función para obtener las direcciones desde el atributo data-direcciones
function getDireccionesFromData(cartContainer) {
    let direcciones = [];
    try {
        direcciones = JSON.parse(cartContainer.dataset.direcciones || "[]");
        console.log("Direcciones iniciales cargadas:", direcciones);
    } catch (error) {
        console.error("Error al procesar data-direcciones:", error);
    }
    return direcciones;
}

// Función para obtener datos del usuario y cargar el carrito
async function obtenerDatosUsuario(userId) {
    try {
        const response = await fetch(`./Api/ApiUser.php?idUsuario=${userId}`);
        if (!response.ok) throw new Error("Error al obtener los datos del usuario.");
        const userData = await response.json();

        console.log("Datos del usuario obtenidos:", userData);

        // Procesar carrito
        let carrito = userData.carrito;

        // Si el carrito está en formato JSON string, conviértelo a un array
        if (typeof carrito === "string") {
            try {
                carrito = JSON.parse(carrito);
            } catch (error) {
                console.error("Error al parsear el carrito:", error);
                carrito = [];
            }
        }

        console.log("Carrito procesado:", carrito);
        cargarCarrito(carrito);

        // Monedero
        const userMonedero = parseFloat(userData.monedero) || 0;
        mostrarMonedero(userMonedero);

        // Direcciones adicionales (fallback si no se cargaron inicialmente)
        await loadAddresses(userId);
    } catch (error) {
        console.error("Error al obtener los datos del usuario:", error);
    }
}


// Función para mostrar el monedero
function mostrarMonedero(monedero) {
    const monederoElement = document.getElementById("current-credit");
    if (!monederoElement) {
        console.error("Elemento del monedero no encontrado en el DOM.");
        return;
    }

    monederoElement.textContent = `${monedero.toFixed(2)}€`;

    // También actualizamos el crédito restante al inicializar el monedero
    const totalPriceElement = document.getElementById("total-price");
    const totalPrice = parseFloat(totalPriceElement.textContent.replace("€", "")) || 0;
    actualizarCreditoRestante(totalPrice);
}

// Función para calcular y mostrar el crédito después de tramitar
function actualizarCreditoRestante(totalPrice) {
    const monederoElement = document.getElementById("current-credit");
    const remainingCreditElement = document.getElementById("remaining-credit");

    if (!monederoElement || !remainingCreditElement) {
        console.error("Elementos para calcular el crédito restante no encontrados en el DOM.");
        return;
    }

    const currentCredit = parseFloat(monederoElement.textContent.replace("€", "")) || 0;
    const remainingCredit = currentCredit - totalPrice;

    // Actualizar el DOM con el crédito restante
    remainingCreditElement.textContent = `${remainingCredit.toFixed(2)}€`;
}

// Función para cargar el carrito en la tabla
function cargarCarrito(carrito) {
    console.log("Ejecutando cargarCarrito con:", carrito);
    const cartItemsContainer = document.getElementById("cart-items");
    const totalPriceElement = document.getElementById("total-price");

    if (!cartItemsContainer) {
        console.error("No se encontró el contenedor del carrito en el DOM.");
        return;
    }

    // Limpiamos el contenido existente
    cartItemsContainer.innerHTML = "";

    let totalPrice = 0;

    carrito.forEach((item) => {
        console.log("Procesando item del carrito:", item);

        const { cantidad, nombre, precio, ingredientes } = item.linea_pedidos;

        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${cantidad}</td>
            <td>
                <div>
                    <strong>${nombre}</strong>
                    <small>${ingredientes.join(", ")}</small>
                </div>
            </td>
            <td>${(precio * cantidad).toFixed(2)}€</td>
        `;

        // Añadir al total
        totalPrice += precio * cantidad;

        cartItemsContainer.appendChild(row);
    });

    // Actualizar el total a pagar en el DOM
    totalPriceElement.textContent = `${totalPrice.toFixed(2)}€`;

    // Actualizar el crédito después de tramitar
    actualizarCreditoRestante(totalPrice);
}


// Función para cargar direcciones en el selector
function cargarDirecciones(direcciones) {
    const addressSelector = document.getElementById("address");
    if (!addressSelector) {
        console.error("Elemento del selector de direcciones no encontrado en el DOM.");
        return;
    }

    // Limpiamos las opciones existentes
    addressSelector.innerHTML = "";

    direcciones.forEach((direccion) => {
        const option = document.createElement("option");
        option.value = direccion.id;
        option.textContent = direccion.descripcion;
        addressSelector.appendChild(option);
    });

    if (direcciones.length === 0) {
        console.warn("No hay direcciones disponibles para cargar.");
    }
}
