<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="../../css/indexRegisterStyle.css">
</head>
<body>
    <div class="container">
        <div class="image-container">
            <div class="sidebar-image"></div>
        </div>
        <div class="register-container">
            <h2>Crear Cuenta</h2>
            <form action="#" method="post">
                <div class="input-group">
                    <label for="name">Nombre</label>
                    <input type="text" id="name" name="name" required placeholder="Nombre">
                </div>
                <div class="input-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" required placeholder="Correo Electrónico">
                </div>
                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required placeholder="Contraseña">
                </div>
                <button type="submit" class="btn">Registrarse</button>
                <div class="links">
                    <a href="../Login/indexLogin.php">¿Ya tienes una cuenta? Iniciar sesión</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
