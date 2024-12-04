<?php
// Obtenemos los datos del usuario desde la sesión
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
?>

<link rel="stylesheet" href="./css/indexCuentaStyle.css">

<!-- Contenedor donde se cargarán los datos -->
<section id="info-cuenta">
    <!-- Aquí se cargarán los datos -->
    <div class="card">
        <div class="perfil-header">
            <!-- Foto del perfil -->
            <div id="foto-perfil" class="foto-perfil"></div>
            <h2 id="nombre-usuario"></h2>
        </div>

        <p id="email-usuario" class="email"></p>
        <p id="monedero-usuario" class="monedero"></p>
        <!-- Dirección (se añade dinámicamente) -->
        <p id="direccion-usuario" class="direccion"></p>

        <div class="botones">
            <button id="btn-editar" class="btn-editar">Editar Datos de Cuenta</button>
            <button id="btn-monedero" class="btn-monedero">Añadir Dinero al Monedero</button>
        </div>
    </div>
</section>

<!-- Modal para ingresar dinero -->
<div id="modal-monedero" class="modal">
    <div class="modal-content">
        <h3>Cuantía de dinero a ingresar</h3>
        <input type="number" id="cantidad" placeholder="Ingrese la cantidad">
        <button id="btn-guardar-cantidad">Aceptar</button>
        <button id="btn-cerrar-modal">Cerrar</button>
    </div>
</div>

<script>
    // Pasamos los datos del usuario desde PHP a JavaScript
    const userData = <?php echo json_encode($user); ?>;
</script>

<script src="./js/indexCuenta.js"></script>