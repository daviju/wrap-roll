// Función para inicializar los datos del usuario
function inicializarCuenta() {
    if (!userData) {
        console.error("Usuario no disponible en la sesión.");
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
    fotoPerfil.style.backgroundImage = userData.foto
        ? `url('http://localhost/SERVIDOR/wrap&roll/images/${userData.foto}')`
        : "url('./images/usuarioBase.png')";

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

    // Dirección
    const direccion = document.createElement("p");
    direccion.classList.add("direccion");
    direccion.innerHTML = `<strong>Dirección:</strong> <span id="direccion-usuario">${userData.direccion || "No especificada"}</span>`;
    card.appendChild(direccion);

    // Botones
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
