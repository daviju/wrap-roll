<link rel="stylesheet" href="./css/indexLoginStyle.css">

<div class="container">
    <div class="login-container">
        <h2>Iniciar Sesión</h2>

        <form action="./../../Metodos/login.php" method="post">
            <div class="input-group">
                <label for="username">Correo Electrónico</label>
                <input type="email" id="username" name="username" required placeholder="Correo Electrónico">
            </div>

            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required placeholder="Contraseña">
            </div>

            <button type="submit" class="btn">Ingresar</button>

            <!-- Si hay error, mostrar el mensaje debajo del input de contraseña -->
            <?php if (isset($loginError) && $loginError): ?>
                <div class="error-message"><?php echo $loginError; ?></div>
            <?php endif; ?>

            <div class="links">
                <a href="#">¿Olvidaste tu contraseña?</a>
                <a href="../Register/indexRegister.php">Crear cuenta</a>
            </div>
        </form>
    </div>
</div>
