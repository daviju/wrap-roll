<link rel="stylesheet" href="./css/indexCuentaStyle.css">

    <section id="info-cuenta">
        <div class="card">
            <div class="perfil-header">
                <div class="foto-perfil"></div>
                <h2>Nombre del Usuario</h2>
            </div>
            <p class="email"><strong>usuario@correo.com</strong></p>
            <p class="monedero"><strong>Monedero:</strong> $0.00</p>
            <div class="botones">
                <button class="btn-editar">Editar Datos de Cuenta</button>
                <button id="btn-monedero" class="btn-monedero">Añadir Dinero al Monedero</button>
                <button class="btn-alergias">Añadir Alergias</button>
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

<script src="./js/indexCuenta.js"></script>