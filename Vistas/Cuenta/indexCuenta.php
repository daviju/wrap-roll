<?php
// Obtenemos los datos del usuario desde la sesión
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
?>

<link rel="stylesheet" href="./css/indexCuentaStyle.css">

<!-- Contenedor donde se cargarán los datos -->
<section id="info-cuenta">
    <!-- El contenido se cargará dinámicamente -->
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
