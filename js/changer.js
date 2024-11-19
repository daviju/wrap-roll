document.addEventListener("DOMContentLoaded", function () {
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
    document.head.appendChild(style);

    document.querySelectorAll(".navbar a, .icons a").forEach(function (link) {
        link.addEventListener("click", function (event) {
            event.preventDefault();
            loadContent(link.getAttribute("href"));
        });
    });

    // Toggle menú desplegable de usuario
    const userMenu = document.querySelector(".user-menu");
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

function loadContent(page) {
    let mainContent = document.getElementById("main-content");

    mainContent.classList.add("fade-out");

    setTimeout(function () {
        switch (page) {
            case "#inicio":
                fetch('Vistas/Main/inisio.php')
                    .then(response => response.text())
                    .then(data => {
                        mainContent.innerHTML = data;
                        animateFadeIn(mainContent);
                    })
                    .catch(error => console.error('Error al cargar inisio.php:', error));
                break;

            case "#nosotros":
                fetch('Vistas/Main/sobrenosotros.php')
                    .then(response => response.text())
                    .then(data => {
                        mainContent.innerHTML = data;
                        animateFadeIn(mainContent);
                    })
                    .catch(error => console.error('Error al cargar sobrenosotros.php:', error));
                break;

            case "#contacto":
                fetch('Vistas/Main/contacto.php')
                    .then(response => response.text())
                    .then(data => {
                        mainContent.innerHTML = data;
                        animateFadeIn(mainContent);
                    })
                    .catch(error => console.error('Error al cargar contacto.php:', error));
                break;

            case "#cart":
                fetch('Vistas/Carrrito/indexCarrito.php')
                    .then(response => response.text())
                    .then(data => {
                        mainContent.innerHTML = data;
                        animateFadeIn(mainContent);
                    })
                    .catch(error => console.error('Error al cargar indexCarrito.php:', error));
                break;

            case "#mi-cuenta":
                fetch('Vistas/Cuenta/indexCuenta.php')
                    .then(response => response.text())
                    .then(data => {
                        mainContent.innerHTML = data;
                        animateFadeIn(mainContent);

                        // Cargar script adicional dinámico
                        let userScript = document.createElement("script");
                        userScript.src = "js/indexCuenta.js";
                        document.body.appendChild(userScript);
                    })
                    .catch(error => console.error('Error al cargar indexCuenta.php:', error));
                break;

            case "#casa":
                fetch('Vistas/Main/kebdecasa.php')
                    .then(response => response.text())
                    .then(data => {
                        mainContent.innerHTML = data;
                        animateFadeIn(mainContent);

                        // Cargar script adicional dinámico
                        let kebabScript = document.createElement("script");
                        kebabScript.src = "js/clasesjs/Kebab.js";
                        document.body.appendChild(kebabScript);
                    })
                    .catch(error => console.error('Error al cargar kebdecasa.php:', error));
                break;

            default:
                fetch('Vistas/Main/inisio.php')
                    .then(response => response.text())
                    .then(data => {
                        mainContent.innerHTML = data;
                        animateFadeIn(mainContent);
                    })
                    .catch(error => console.error('Error al cargar inisio.php:', error));
                break;
        }
    }, 500);
}

function animateFadeIn(element) {
    setTimeout(() => {
        element.classList.remove("fade-out");
        element.classList.add("fade-in");
    }, 50);
}
