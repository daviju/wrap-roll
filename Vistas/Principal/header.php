<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Wrap & Roll</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="./css/estiloso.css" />
</head>

<body>
  <!-- La idea es que tengamos un input hidden desde aqui y tu cojas el id si esta iniciado sesion -->
  <?php
  if (isset($_SESSION['idUsuario'])) {
    echo '<input type="hidden" id="user" value=' . $_SESSION['idUsuario']->id . '>';
  }
  ?>

  <div class="tuskebabs">
    <div class="titulo">
      <div class="logo-titulo">
        <img
          src="./images/Wrap&Roll.png"
          alt="Logo Kebab"
          width="100px"
          height="100px"
          style="border-radius: 50%; object-fit: cover;" />
        <h1 class="titulo-kebab"><strong>Wrap & Roll</strong></h1>
      </div>

      <?php

      if (isset($_SESSION['user'])) {
        if ($_SESSION['user']->rol === 'Cliente') {
          echo '
                <div class="icons">
                  <!-- Menú de usuario con desplegable -->
                  <div class="user-menu">
                      <img
                        src="./images/user.png"
                        alt="Logo Usuario"
                        width="40px"
                        height="40px"
                        style="border-radius: 50%; object-fit: cover;"
                      />
                    <div class="dropdown-menu">
                      <a href="?menu=cuenta">Mi cuenta</a>
                      <a href="?menu=logout">Cerrar sesión</a>
                    </div>
                  </div>

                  <a href="?menu=carrito">
                    <img
                      src="./images/cart.png"
                      alt="Logo carrito"
                      width="40px"
                      height="40px"
                      style="border-radius: 50%; object-fit: cover;"
                    />
                  </a>
                </div>
              </div>

              <nav class="navbar-admin">
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
              ';
        } else if ($_SESSION['user']->rol === 'Admin'){
          echo '
                <div class="icons">
                  <!-- Menú de usuario con desplegable -->
                  <div class="user-menu">
                      <img
                        src="./images/user.png"
                        alt="Logo Usuario"
                        width="40px"
                        height="40px"
                        style="border-radius: 50%; object-fit: cover;"
                      />
                    <div class="dropdown-menu">
                      <a href="?menu=cuenta">Mi cuenta</a>
                      <a href="?menu=logout">Cerrar sesión</a>
                    </div>
                  </div>

                  <a href="?menu=carrito">
                    <img
                      src="./images/cart.png"
                      alt="Logo carrito"
                      width="40px"
                      height="40px"
                      style="border-radius: 50%; object-fit: cover;"
                    />
                  </a>
                </div>
              </div>
              
              <nav class="navbar-admin">
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
              ';
        }
        
      } else {
        echo '
              <nav class="navbar-admin">
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

            <div class="botones-invitado">
              
              <!-- Menú de Invitado -->
                <a href="?menu=login">
                  <button>Iniciar sesion</button>
                </a>

                <a href="?menu=register">
                  <button>Registrarme</button>
                </a>
              </div>
            </div>
                ';
      }
      ?>
        <div class="underline"></div>
      </nav>
    </div>
</body>

</html>