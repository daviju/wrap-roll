document.addEventListener("DOMContentLoaded", function() {
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
    document.head.appendChild(style);

    document.querySelectorAll(".navbar a, .icons a").forEach(function(link) {
        link.addEventListener("click", function(event) {
            event.preventDefault();
            loadContent(link.getAttribute("href"));
        });
    });
});

function loadContent(page) {
    let mainContent = document.getElementById("main-content");

    mainContent.classList.add("fade-out");

    setTimeout(function() {
        switch(page) {
            case "#inicio":
                fetch('Vistas/Main/inisio.php')
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
                fetch('Vistas/Carrrito/indexCarrito.php')
                    .then(response => response.text())
                    .then(data => {
                        mainContent.innerHTML = data;
                        setTimeout(() => {
                            mainContent.classList.remove("fade-out");
                            mainContent.classList.add("fade-in");
                        }, 50);
                    })
                    .catch(error => console.error('Error al cargar indexCarrito.php:', error));
                break;

            case "#user":
                fetch('Vistas/Cuenta/indexCuenta.php')
                    .then(response => response.text())
                    .then(data => {
                        mainContent.innerHTML = data;
                        setTimeout(() => {
                            mainContent.classList.remove("fade-out");
                            mainContent.classList.add("fade-in");
                        }, 50);
                    })
                    .catch(error => console.error('Error al cargar indexCuenta.php:', error));
                break;

            case "#casa":
                fetch('Vistas/Main/kebdecasa.php')
                    .then(response => response.text())
                    .then(data => {
                        mainContent.innerHTML = data;
                        setTimeout(() => {
                            mainContent.classList.remove("fade-out");
                            mainContent.classList.add("fade-in");
                        }, 50);
                    })
                    .catch(error => console.error('Error al cargar kebdecasa.php:', error));
                break;

            default:
                fetch('Vistas/Main/inisio.php')
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
    }, 500);
}
