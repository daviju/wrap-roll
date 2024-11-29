window.addEventListener('load', function() {
    const idUsuario = document.getElementById('user') ? document.getElementById('user').value : null;
    const header = document.querySelector('header');

    if (idUsuario) {
        // Hacer una petición AJAX para obtener información
        fetch(`./Api/ApiUser.php?idUsuario=${idUsuario}`)
            .then(response => response.json())
            .then(data => {
                if (data && data.rol) {
                    if (data.rol === "Admin") {
                        header.innerHTML = `
                            <nav class="navbar">
                                <a class="item" href="?menu=inicio">Inicio</a>
                                <div class="item">
                                    Kebabs
                                    <div class="dropdown">
                                        <div>
                                            <a href="?menu=kebabCasa">De la casa</a>
                                            <a href="?menu=kebabGusto">Al gusto</a>
                                        </div>
                                    </div>
                                </div>
                                <a class="item" href="?menu=nosotros">Sobre nosotros</a>
                                <a class="item" href="?menu=contacto">Contacto</a> 
                                <div class="item">
                                    Mantenimiento
                                    <div class="dropdown">
                                        <div>
                                            <a href="?admin=kebab">Kebab</a>
                                            <a href="?admin=ingredientes">Ingredientes</a>
                                            <a href="?admin=alergenos">Alergenos</a>
                                        </div>
                                    </div>
                                </div>
                            </nav>
                        `;
                    } else if (data.rol === "Cliente") {
                        header.innerHTML = `
                            <nav class="navbar">
                                <a class="item" href="?menu=inicio">Inicio</a>
                                <div class="item">
                                    Kebabs
                                    <div class="dropdown">
                                        <div>
                                            <a href="?menu=kebabCasa">De la casa</a>
                                            <a href="?menu=kebabGusto">Al gusto</a>
                                        </div>
                                    </div>
                                </div>
                                <a class="item" href="?menu=nosotros">Sobre nosotros</a>
                                <a class="item" href="?menu=contacto">Contacto</a> 
                            </nav>
                        `;
                    }
                }
            })
            .catch(error => console.error('Error al obtener los datos del usuario:', error));
    }
});
