/*
    Funciones para manejar la cuenta del usuario

    Métodos:
        inicializarCuenta(): Inicializa la cuenta del usuario cargando y mostrando los datos del perfil, como nombre, correo, monedero y dirección.
        mostrarErrorUsuario(mensaje): Muestra un mensaje de error en la interfaz si no se puede cargar la información del usuario desde el servidor.
        mostrarModal(): Muestra el modal para permitir al usuario añadir dinero a su monedero.
        guardarCantidad(): Guarda la cantidad ingresada por el usuario para añadirla al monedero y actualiza la información del monedero en la base de datos del servidor.
        cerrarModal(): Cierra el modal de añadir dinero al monedero una vez que se ha completado la acción o el usuario cancela.

    TODO: Implementar la inicialización de la cuenta y las funcionalidades del monedero
        * inicializarCuenta: Esta función debe cargar los datos del usuario (foto, nombre, email, saldo del monedero y dirección) mediante solicitudes a las APIs correspondientes. Los datos deben ser mostrados en la interfaz de usuario.
        * mostrarErrorUsuario: Si hay un error al cargar los datos del usuario desde el servidor o la API, esta función debe mostrar un mensaje adecuado informando al usuario de la falla.
        * mostrarModal: Esta función debe hacer visible el modal donde el usuario podrá ingresar la cantidad de dinero que desea añadir a su monedero. Es importante que el modal se presente de forma amigable y clara.
        * guardarCantidad: Permite al usuario ingresar una cantidad en el modal, y cuando lo haga, la cantidad debe ser enviada al servidor para actualizar el saldo de su monedero. Se hace a través de una petición `PUT` a la API correspondiente, asegurando que la base de datos se mantenga actualizada con el nuevo saldo.
        * cerrarModal: Cierra el modal de añadir dinero al monedero, ya sea porque el usuario completó la acción o decidió cancelarla.

    Detalles:
        * El monedero del usuario es un valor numérico que representa el saldo disponible. Se debe actualizar cada vez que el usuario agregue dinero, reflejando los cambios inmediatamente en la interfaz.
        * La dirección del usuario se obtiene mediante una llamada a la API externa ubicada en "http://www.daviju.es/Api/ApiDireccion.php", que devuelve las direcciones del usuario. Esta información debe ser presentada adecuadamente para que el usuario pueda verla o modificarla si es necesario.
        * Se utiliza `fetch` para hacer peticiones HTTP a la API para obtener y enviar datos. Los datos del usuario (nombre, email, monedero, etc.) se envían al servidor usando una solicitud `PUT` a './Api/ApiUser.php' para actualizar la base de datos.
        * Es importante que las funciones de manejo de errores estén bien implementadas para poder proporcionar una experiencia de usuario fluida, mostrando mensajes claros cuando ocurran errores en la carga o actualización de datos.
*/

document.addEventListener("DOMContentLoaded", async () => {
    const cartContainer = document.getElementById("cart-container");
    const userId = cartContainer.dataset.userId;

    // Verificar si el ID de usuario está disponible
    if (!userId) {
        console.error("No se pudo obtener el ID del usuario.");
        return;
    }

    try {
        // Inicialización de datos y direcciones
        await obtenerDatosUsuario(userId);
        await cargarDireccionesDesdeApi(userId); // Cargar direcciones desde la API

        // Enlazar el evento al botón de tramitar el pedido
        const tramitarBtn = document.getElementById("order-btn");
        
        if (tramitarBtn) {
            tramitarBtn.addEventListener("click", async () => {
                // Llamar a la función para tramitar el pedido
                await tramitarPedido(userId);
            });
        } else {
            console.error("Botón 'order-btn' no encontrado en el DOM.");
        }
    } catch (error) {
        console.error("Error al inicializar los datos:", error);
    }
});


// Función para obtener datos del usuario y cargar el carrito
async function obtenerDatosUsuario(userId) {
    try {
        const response = await fetch(`./Api/ApiUser.php?idUsuario=${userId}`); // Llamar a la API para obtener datos del usuario
        if (!response.ok) throw new Error("Error al obtener los datos del usuario."); // Verificar si la solicitud fue exitosa
        const userData = await response.json(); // Obtener los datos del usuario

        console.log("Datos del usuario obtenidos:", userData);

        // Procesar carrito
        let carrito = userData.carrito;

        // Si el carrito está en formato JSON string, conviértelo a un array
        if (typeof carrito === "string") { 
            try {
                carrito = JSON.parse(carrito); // Intentar parsear el string a un array
            } catch (error) {
                console.error("Error al parsear el carrito:", error);
                carrito = []; // Si falla, crear un array vacío
            }
        }

        console.log("Carrito procesado:", carrito); // Imprimir el carrito procesado
        cargarCarrito(carrito, userId); // Cargar el carrito en la tabla

        // Monedero
        const userMonedero = parseFloat(userData.monedero) || 0; // Obtener el monedero del usuario
        mostrarMonedero(userMonedero); // Mostrar el monedero
    } catch (error) {
        console.error("Error al obtener los datos del usuario:", error);
    }
}

// Función para cargar el carrito en la tabla
function cargarCarrito(carrito, userId) {
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

    carrito.forEach((item, index) => {
        console.log("Procesando item del carrito:", item);

        const { cantidad, nombre, precio, ingredientes } = item.linea_pedidos;

        const row = document.createElement("tr");

        // Generar fila con botón "-"
        row.innerHTML = `
            <td>
                ${cantidad}
                <button class="remove-item" data-index="${index}" data-user-id="${userId}">-</button>
            </td>
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

    // Agregar eventos a los botones "-"
    const removeButtons = document.querySelectorAll(".remove-item");
    removeButtons.forEach((button) => {
        button.addEventListener("click", async (event) => {
            const index = event.target.dataset.index; // Obtener el index
            const userId = event.target.dataset.userId; // Obtener el userId

            // Eliminar el item del carrito
            carrito.splice(index, 1); 

            // Actualizar el carrito en el servidor
            await actualizarCarrito(userId, carrito);

            // Recargar el carrito en la página
            cargarCarrito(carrito, userId);
        });
    });
}

// Función para actualizar el carrito en el servidor
async function actualizarCarrito(userId, carrito) {
    try {
        // Primero obtenemos los datos del usuario
        const response = await fetch(`./Api/ApiUser.php?idUsuario=${userId}`);

        // Verificar si la solicitud fue exitosa
        if (!response.ok) throw new Error("Error al obtener los datos del usuario.");
        
        // Obtenemos los datos del usuario
        const usuario = await response.json();

        console.log("Datos del usuario obtenidos:", usuario);

        // Ahora actualizamos el carrito con el objeto completo del usuario
        const usuarioActualizado = {
            ...usuario, // Usamos el objeto usuario obtenido
            carrito: JSON.stringify(carrito), // Guardamos el carrito como JSON string
        };

        // Hacemos el PUT con el objeto usuario actualizado
        const updateResponse = await fetch(`./Api/ApiUser.php`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(usuarioActualizado),
        });

        if (!updateResponse.ok) { // Verificar si la solicitud fue exitosa
            throw new Error("Error al actualizar el carrito en el servidor.");
        }

        console.log("Carrito actualizado correctamente en el servidor.");
    } catch (error) {
        console.error("Error al actualizar el carrito:", error);
    }
}


// Función para mostrar el monedero
function mostrarMonedero(monedero) {
    const monederoElement = document.getElementById("current-credit");
    if (!monederoElement) {
        console.error("Elemento del monedero no encontrado en el DOM.");
        return;
    }

    monederoElement.textContent = `${monedero.toFixed(2)}€`; // Mostrar el monedero en el DOM

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

// Función para cargar direcciones desde la API
async function cargarDireccionesDesdeApi(userId) {
    try {
        const response = await fetch(`./Api/ApiDireccion.php?idUsuario=${userId}`);
        if (!response.ok) throw new Error("Error al obtener las direcciones del usuario.");

        const direcciones = await response.json();
        console.log("Direcciones obtenidas de la API:", direcciones);

        // Llamamos a la función que carga las direcciones en el selector
        cargarDirecciones(direcciones);
    } catch (error) {
        console.error("Error al obtener las direcciones del usuario:", error);
    }
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
        const {
            ID_Direccion,
            nombrevia,
            numero,
            tipovia,
            puerta,
            escalera,
            planta,
            localidad,
        } = direccion;

        // Validar que los campos requeridos existan
        if (ID_Direccion && nombrevia && numero && tipovia && localidad) {
            // Construir la descripción completa de la dirección
            const descripcion = `${tipovia} ${nombrevia}, ${numero}, Puerta ${puerta || "-"}, Escalera ${escalera || "-"}, Planta ${planta || "-"}, ${localidad}`;

            const option = document.createElement("option");
            option.value = ID_Direccion;
            option.textContent = descripcion;
            addressSelector.appendChild(option);
        } else {
            console.warn("Dirección inválida detectada:", direccion);
        }
    });

    if (direcciones.length === 0) {
        console.warn("No hay direcciones disponibles para cargar.");
    }
}

// Función para tramitar el pedido
async function tramitarPedido(userId) {
    console.log(" ");
    try {
        // Obtener los datos del usuario
        const response = await fetch(`./Api/ApiUser.php?idUsuario=${userId}`);
        if (!response.ok) throw new Error("Error al obtener los datos del usuario.");
        const usuario = await response.json();

        console.log("Datos del usuario obtenidos:", usuario);

        // Obtener el carrito
        let carrito = usuario.carrito;

        // Asegurarse de que el carrito esté en formato array
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

        // Validar que el carrito no esté vacío
        if (carrito.length === 0) {
            alert("Tu carrito está vacío. Agrega productos antes de tramitar el pedido.");
            return;
        }

        // Calcular el precio total del pedido
        let precioTotal = 0;
        carrito.forEach(item => {
            const { cantidad, precio } = item.linea_pedidos;
            precioTotal += cantidad * precio;
        });

        // Verificar si el usuario tiene suficiente saldo en su monedero
        const saldoUsuario = parseFloat(usuario.monedero);
        if (saldoUsuario < precioTotal) {
            alert("No tienes suficiente saldo en tu monedero para tramitar este pedido.");
            return; // Detener la ejecución si no hay saldo suficiente
        }

        // Restar el precio total del monedero del usuario
        const nuevoSaldo = saldoUsuario - precioTotal;

        // Actualizar el monedero del usuario en la API (PUT)
        const usuarioActualizado = {
            ...usuario,
            monedero: nuevoSaldo.toFixed(2) // Asegurarse de que el saldo se mantenga con 2 decimales
        };

        const updateResponse = await fetch('./Api/ApiUser.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(usuarioActualizado),
        });

        if (!updateResponse.ok) {
            throw new Error("Error al actualizar el monedero del usuario.");
        }

        console.log("Monedero actualizado correctamente en el servidor.");

        // Crear el objeto de pedido
        const pedido = {
            estado: "en cola", // Estado inicial del pedido
            preciototal: precioTotal.toFixed(2), // Redondear a 2 decimales
            fecha_hora: formatoFechaMysql(), // Usar la función para formatear la fecha
            ID_Usuario: userId // ID del usuario
        };

        console.log("Objeto de pedido creado:", pedido);

        // Enviar el pedido al servidor
        const pedidoResponse = await fetch('./Api/ApiPedido.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(pedido) // Convertir el pedido a JSON para enviarlo
        });

        // Verificar si la respuesta es válida
        if (!pedidoResponse.ok) {
            throw new Error(`Error al tramitar el pedido: ${pedidoResponse.statusText}`);
        }

        // Obtener la respuesta como texto
        const responseText = await pedidoResponse.text(); // Obtener la respuesta como texto

        try {
            // Intentar parsear la respuesta como JSON
            const pedidoData = JSON.parse(responseText);
            console.log("Pedido tramitado correctamente:", pedidoData);

            if (pedidoData.success) {
                alert("¡Pedido tramitado con éxito!");

                // Vaciar el carrito del usuario tras tramitar el pedido
                await vaciarCarrito(userId);
                location.reload(true); // Recargar la página
            } else {
                alert("Hubo un error al crear el pedido.");
            }
        } catch (error) {
            console.error("Respuesta no es un JSON válido:", responseText);
            alert("Hubo un error al tramitar el pedido. Por favor, inténtalo de nuevo.");
        }
    } catch (error) {
        console.error("Error al tramitar el pedido:", error);
        alert("Hubo un error al tramitar el pedido. Por favor, inténtalo de nuevo.");
    }
}

// Función para vaciar el carrito (opcional)
async function vaciarCarrito(userId) {
    try {
        // Obtener los datos del usuario
        const response = await fetch(`./Api/ApiUser.php?idUsuario=${userId}`);
        if (!response.ok) throw new Error("Error al obtener los datos del usuario.");
        const usuario = await response.json();

        console.log("Datos del usuario obtenidos:", usuario);

        // Vaciar el carrito
        const usuarioActualizado = {
            ...usuario,
            carrito: JSON.stringify([]) // Carrito vacío
        };

        const updateResponse = await fetch(`./Api/ApiUser.php`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(usuarioActualizado)
        });

        if (!updateResponse.ok) {
            throw new Error("Error al vaciar el carrito.");
        }

        console.log("Carrito vaciado correctamente.");

    } catch (error) {
        console.error("Error al vaciar el carrito:", error);
    }
}

// función para formatear la fecha en formato MySQL
function formatoFechaMysql() {
    const fecha = new Date(); // obtengo la fecha actual

    const año = fecha.getFullYear(); // obtengo el año
    const mes = String(fecha.getMonth() + 1).padStart(2, '0'); // obtengo el mes y lo convierto a un string con dos dígitos
    const dia = String(fecha.getDate()).padStart(2, '0'); // obtengo el día y lo convierto a un string con dos dígitos
    const horas = String(fecha.getHours()).padStart(2, '0'); // obtengo las horas y lo convierto a un string con dos dígitos
    const minutos = String(fecha.getMinutes()).padStart(2, '0'); // obtengo los minutos y lo convierto a un string con dos dígitos
    const segundos = String(fecha.getSeconds()).padStart(2, '0'); // obtengo los segundos y lo convierto a un string con dos dígitos

    return `${año}-${mes}-${dia} ${horas}:${minutos}:${segundos}`; // devuelvo la fecha en formato MySQL
}
