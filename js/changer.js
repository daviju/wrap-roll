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

    function handleNavigation(event) {
        event.preventDefault();
        loadContent(event.target.getAttribute("href"));
    }

    document.querySelectorAll(".navbar a, .icons a, .new-card a, .new-card a span").forEach(function (link) {
        link.addEventListener("click", handleNavigation);
    });    

    // Event listener global para enlaces dentro de main-content
    document.getElementById('main-content').addEventListener('click', function (event) {
        if (event.target.tagName === 'A' && event.target.getAttribute("href").startsWith("#")) {
            handleNavigation(event);
        }
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

            case "#ing":
                fetch('Vistas/Admin/modIngredientes.php')
                    .then(response => response.text())
                    .then(data => {
                        mainContent.innerHTML = data;
                        animateFadeIn(mainContent);

                        // Cargar script adicional dinámico
                        let modIngScript = document.createElement("script");
                        modIngScript.src = "js/clasesjs/Ingredientes.js";
                        document.body.appendChild(modIngScript);
                    })
                    .catch(error => console.error('Error al cargar modIngredientes.php:', error));
                break;
                
            case "#crearIng":
                fetch('Vistas/Admin/crearIngredientes.php')
                    .then(response => response.text())
                    .then(data => {
                        mainContent.innerHTML = data;
                        animateFadeIn(mainContent);
                        console.log('Cargando...');
                        // Cargar script adicional dinámico
                        let crearIngScript = document.createElement("script");
                        crearIngScript.src = "js/clasesjs/crearIngredientes.js";
                        document.body.appendChild(crearIngScript);
                    })
                    .catch(error => console.error('Error al cargar crearIngredientes.php:', error));
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
