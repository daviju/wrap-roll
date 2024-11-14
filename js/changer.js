document.addEventListener("DOMContentLoaded", function() {
    // Insertar CSS dinámicamente
    const style = document.createElement('style');
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
    document.head.appendChild(style);  // Añadir el estilo al head del documento

    document.querySelectorAll(".navbar a").forEach(function(link) {
        link.addEventListener("click", function(event) {
            event.preventDefault();
            loadContent(link.getAttribute("href"));
        });
    });
});

function loadContent(page) {
    let mainContent = document.getElementById("main-content");

    // Primero añadimos la clase de fade-out
    mainContent.classList.add("fade-out");

    // Esperamos a que termine la animación para cambiar el contenido
    setTimeout(function() {
        switch(page) {
            case "#inicio":
                fetch('Vistas/Main/inisio.php')
                    .then(response => response.text())
                    .then(data => {
                        mainContent.innerHTML = data;
                        // Una vez cargado el nuevo contenido, aplicamos fade-in
                        setTimeout(() => {
                            mainContent.classList.remove("fade-out");
                            mainContent.classList.add("fade-in");
                        }, 50); // Tiempo pequeño para asegurar la transición
                    })
                    .catch(error => console.error('Error al cargar inisio.php:', error));
                break;

            case "#nosotros":
                fetch('Vistas/Main/sobrenosotros.php')
                    .then(response => response.text())
                    .then(data => {
                        mainContent.innerHTML = data;
                        setTimeout(() => {
                            mainContent.classList.remove("fade-out");
                            mainContent.classList.add("fade-in");
                        }, 50);
                    })
                    .catch(error => console.error('Error al cargar sobrenosotros.php:', error));
                break;

            case "#contacto":
                fetch('Vistas/Main/contacto.php')
                    .then(response => response.text())
                    .then(data => {
                        mainContent.innerHTML = data;
                        setTimeout(() => {
                            mainContent.classList.remove("fade-out");
                            mainContent.classList.add("fade-in");
                        }, 50);
                    })
                    .catch(error => console.error('Error al cargar contacto.php:', error));
                break;

            case "#cart":
                fetch('../app/views/AdminKebab.php')
                    .then(response => response.text())
                    .then(data => {
                        mainContent.innerHTML = data;
                        setTimeout(() => {
                            mainContent.classList.remove("fade-out");
                            mainContent.classList.add("fade-in");
                        }, 50);
                    })
                    .catch(error => console.error('Error al cargar carrito.php:', error));
                break;

            case "#adminKebab":
                fetch('../app/views/AdminKebab.php')
                    .then(response => response.text())
                    .then(data => {
                        mainContent.innerHTML = data;
                        setTimeout(() => {
                            mainContent.classList.remove("fade-out");
                            mainContent.classList.add("fade-in");
                        }, 50);
                    })
                    .catch(error => console.error('Error al cargar administrar-kebab.php:', error));
                break;

            default:
                fetch('../Vistas/Main/inisio.php')
                    .then(response => response.text())
                    .then(data => {
                        mainContent.innerHTML = data;
                        setTimeout(() => {
                            mainContent.classList.remove("fade-out");
                            mainContent.classList.add("fade-in");
                        }, 50);
                    })
                    .catch(error => console.error('Error al cargar inisio.php:', error));
                break;
        }
    }, 500); // Espera el tiempo de fade-out antes de cambiar el contenido
}
