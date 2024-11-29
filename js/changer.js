document.addEventListener("DOMContentLoaded", function () { // Esperamos a que el DOM este listo
    // Añadimos estilos dinámicos
    const style = document.createElement("style");
    style.innerHTML = `
        #main-content {
            transition: opacity 0.5s ease-in-out;
            opacity: 1;
        }
        #main-content.fade-out {
            opacity: 0;
        }
        #main-content.fade-in {
            opacity: 1;
        }
    `;
    document.head.appendChild(style); // Agregamos el estilo al head

    // Toggle menú desplegable de usuario
    const userMenu = document.querySelector(".user-menu"); // Obtenemos el menú
    if (userMenu) {
        userMenu.addEventListener("click", function (event) {
            const dropdown = userMenu.querySelector(".dropdown-menu");
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
            event.stopPropagation();
        });

        // Cerrar el menú desplegable al hacer clic fuera
        document.addEventListener("click", function (event) {
            if (!userMenu.contains(event.target)) {
                const dropdown = userMenu.querySelector(".dropdown-menu");
                if (dropdown) dropdown.style.display = "none";
            }
        });
    }
});

