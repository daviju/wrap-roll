/*
    Funciones para manejar la cuenta del usuario

    Métodos:
        inicializarCuenta(): Inicializa la cuenta del usuario y muestra su perfil, email, monedero y dirección.
        mostrarErrorUsuario(mensaje): Muestra un mensaje de error en caso de que no se pueda cargar la información del usuario.
        mostrarModal(): Muestra el modal para añadir dinero al monedero.
        guardarCantidad(): Guarda la cantidad ingresada para añadir al monedero del usuario y actualiza la información en la base de datos.
        cerrarModal(): Cierra el modal de añadir dinero al monedero.

    TODO: Implementar la inicialización de la cuenta y las funcionalidades del monedero
        * inicializarCuenta: Carga los datos del usuario (foto, nombre, email, monedero y dirección) y los muestra en la interfaz.
        * mostrarErrorUsuario: Muestra un mensaje de error en caso de que no se pueda obtener la información del usuario.
        * mostrarModal: Muestra el modal de añadir dinero al monedero.
        * guardarCantidad: Permite al usuario añadir una cantidad al monedero y actualiza la información en el servidor.
        * cerrarModal: Cierra el modal de añadir dinero al monedero.
        
    Detalles:
        * El monedero es un valor numérico que se actualiza cuando el usuario añade dinero.
        * La dirección del usuario se obtiene a través de una API externa (http://www.daviju.es/Api/ApiDireccion.php).
        * Se utiliza la función `fetch` para obtener la información de la API y actualizar los datos del usuario.
        * Los datos del usuario se actualizan en el servidor usando una petición `PUT` a './Api/ApiUser.php'.
*/

function inicializarCuenta() {
    if (!userData || !userData.idUsuario) {  // Asegurándonos de que el ID del usuario esté disponible
        console.error("Usuario no disponible en la sesión o falta ID.");
        mostrarErrorUsuario("No se pudo cargar la información del usuario.");
        return;
    }

    const infoCuenta = document.getElementById("info-cuenta");
    infoCuenta.innerHTML = ""; // Limpiar el contenedor

    // Crear tarjeta de perfil
    const card = document.createElement("div");
    card.classList.add("card");

    const perfilHeader = document.createElement("div");
    perfilHeader.classList.add("perfil-header");

    // Foto del usuario
    const fotoPerfil = document.createElement("div");
    fotoPerfil.id = "foto-perfil";
    fotoPerfil.classList.add("foto-perfil");

    // Verifica si hay foto del usuario, si no se asigna una foto predeterminada
    const fotoUrl = userData.foto ? `http://localhost/SERVIDOR/wrap&roll/images/${userData.foto}` : "./images/usuarioBase.png";
    fotoPerfil.style.backgroundImage = `url('${fotoUrl}')`;

    perfilHeader.appendChild(fotoPerfil);

    // Nombre del usuario
    const nombreUsuario = document.createElement("h2");
    nombreUsuario.id = "nombre-usuario";
    nombreUsuario.textContent = userData.nombre || "Usuario desconocido";
    perfilHeader.appendChild(nombreUsuario);

    card.appendChild(perfilHeader);

    // Email
    const email = document.createElement("p");
    email.classList.add("email");
    email.innerHTML = `<strong id="email-usuario">${userData.email || "Correo no disponible"}</strong>`;
    card.appendChild(email);

    // Monedero
    const monedero = document.createElement("p");
    monedero.classList.add("monedero");
    monedero.innerHTML = `<strong>Monedero:</strong> <span id="monedero-usuario">${userData.monedero?.toFixed(2) || "0.00"} €</span>`;
    card.appendChild(monedero);

    // Obtener la dirección del usuario desde la API
    const userId = userData.idUsuario;  // Asegurándonos de usar el idUsuario
    if (!userId) {
        console.error("El ID del usuario no está definido.");
        mostrarErrorUsuario("ID de usuario no disponible.");
        return;
    }

    fetch(`http://www.daviju.es/Api/ApiDireccion.php?idUsuario=${userId}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
                return;
            }

            // Si hay direcciones, tomar la primera o mostrar mensaje si no tiene direcciones
            const direccionUsuario = data.length > 0 ? data[0] : {
                nombrevia: "No especificada",
                numero: "No especificado",
                tipovia: "No especificado",
                puerta: "No especificado",
                escalera: "No especificado",
                planta: "No especificado",
                localidad: "No especificada"
            };

            // Dirección (ahora se añaden todos los campos)
            const direccion = document.createElement("p");
            direccion.classList.add("direccion");
            direccion.innerHTML = `
                <strong>Dirección:</strong>
                <span id="direccion-usuario">
                    ${direccionUsuario.tipovia} ${direccionUsuario.nombrevia}, ${direccionUsuario.numero} ${direccionUsuario.puerta ? ', Puerta: ' + direccionUsuario.puerta : ''} 
                    ${direccionUsuario.escalera ? ', Escalera: ' + direccionUsuario.escalera : ''} 
                    ${direccionUsuario.planta ? ', Planta: ' + direccionUsuario.planta : ''} 
                    ${direccionUsuario.localidad ? ', ' + direccionUsuario.localidad : ''}
                </span>`;
            card.appendChild(direccion); // La dirección se añade aquí, justo después del monedero
        })
        .catch(error => {
            console.error("Error al obtener la dirección:", error);
        });

    // Botones (se añaden después de la dirección)
    const botones = document.createElement("div");
    botones.classList.add("botones");

    const btnEditar = document.createElement("button");
    btnEditar.classList.add("btn-editar");
    btnEditar.textContent = "Editar Datos de Cuenta";
    botones.appendChild(btnEditar);

    const btnMonedero = document.createElement("button");
    btnMonedero.id = "btn-monedero";
    btnMonedero.classList.add("btn-monedero");
    btnMonedero.textContent = "Añadir Dinero al Monedero";
    botones.appendChild(btnMonedero);

    card.appendChild(botones);

    infoCuenta.appendChild(card);
}

// Función para mostrar errores en el contenedor
function mostrarErrorUsuario(mensaje) {
    const infoCuenta = document.getElementById("info-cuenta");
    infoCuenta.innerHTML = `<p>${mensaje}</p>`;
}

// Función para mostrar el modal
function mostrarModal() {
    document.getElementById("modal-monedero").style.display = "flex";
}

function guardarCantidad() {
    const cantidad = parseFloat(document.getElementById("cantidad").value);
    if (cantidad && cantidad > 0) {
        const monederoElemento = document.getElementById("monedero-usuario");
        const saldoActual = parseFloat(monederoElemento.textContent.replace("€", "").trim()) || 0;
        const nuevoSaldo = saldoActual + cantidad;

        // Actualizar el monedero en el DOM
        monederoElemento.textContent = `${nuevoSaldo.toFixed(2)} €`;

        // Crear un nuevo objeto con los datos del usuario y el monedero actualizado
        const usuarioActualizado = {
            ...userData, // Copia todos los datos del usuario original // USO spread operator
            monedero: nuevoSaldo // Cambia solo el monedero
        };

        console.log("Usuario actualizado:", usuarioActualizado);

        fetch('./Api/ApiUser.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(usuarioActualizado)
        })
            .then(response => response.text()) // Usamos .text() para obtener la respuesta como texto
            .then(data => {
                console.log(data); // Ver qué es lo que está devolviendo el servidor
                try {
                    const responseJson = JSON.parse(data); // Intentamos parsear la respuesta
                    console.log("Respuesta de la API:", responseJson);
                } catch (e) {
                    console.error("Error al parsear la respuesta:", e);
                }
            })
            .catch(error => {
                console.error("Error al actualizar el dinero:", error);
            });
    } else {
        alert("Por favor, ingrese una cantidad válida.");
    }
    cerrarModal();
}


// Función para cerrar el modal
function cerrarModal() {
    document.getElementById("modal-monedero").style.display = "none";
}

// Event listeners
document.addEventListener("DOMContentLoaded", function () {
    inicializarCuenta();

    document.body.addEventListener("click", function (event) {
        if (event.target.id === "btn-monedero") {
            mostrarModal();
        }
        if (event.target.id === "btn-guardar-cantidad") {
            guardarCantidad();
        }
        if (event.target.id === "btn-cerrar-modal") {
            cerrarModal();
        }
    });
});
