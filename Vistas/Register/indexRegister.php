<link rel="stylesheet" href="../../css/indexRegisterStyle.css">

<div class="container">
    <div class="register-container">
        <h2>Crear Cuenta</h2>
        <form id="registro-form" action="#" method="post" enctype="multipart/form-data">
            <div class="form-columns">
                <div class="column">
                    <div class="input-group">
                        <label for="name">Nombre</label>
                        <input type="text" id="name" name="nombre" required placeholder="Nombre">
                    </div>
                    <div class="input-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" id="email" name="email" required placeholder="Correo Electrónico">
                    </div>
                    <div class="input-group">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="contrasena" required placeholder="Contraseña">
                    </div>
                </div>

                <div class="separator"></div> <!-- Separador visual -->

                <div class="column">
                    <div class="input-group">
                        <label for="wallet">Monedero (€)</label>
                        <input type="number" id="wallet" name="monedero" required placeholder="Cantidad inicial" min="0">
                    </div>
                    <div class="input-group">
                        <label for="phone">Teléfono</label>
                        <input type="tel" id="phone" name="telefono" required placeholder="Teléfono">
                    </div>
                    <div class="input-group">
                        <label for="photo">Foto de perfil</label>
                        <input type="file" id="photo" name="foto" accept="image/*">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn">Registrarse</button>
            <div class="links">
                <a href="../Login/indexLogin.php">¿Ya tienes una cuenta? Iniciar sesión</a>
            </div>
        </form>
    </div>
</div>

<script src="./js/Register.js"></script>
