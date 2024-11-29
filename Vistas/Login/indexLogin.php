<link rel="stylesheet" href="./css/indexLoginStyle.css">

<div class="container">

    <div class="login-container">
        <h2>Iniciar Sesión</h2>

        <form action="./../../Metodos/login.php" method="post"> <!-- ./../Metodos/login.php -->

            <div class="input-group">
                <label for="username">Correo Electrónico</label>
                <input type="email" id="username" name="username" required placeholder="Correo Electrónico">
            </div>

            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required placeholder="Contraseña">
            </div>

            <button type="submit" class="btn">Ingresar</button>

            <div class="links">
                <a href="#">¿Olvidaste tu contraseña?</a>
                <a href="../Register/indexRegister.php">Crear cuenta</a>
            </div>

        </form>
    </div>
</div>

<!--<script src="./js/LogIn.js"></script>-->


<!-- A ver  yo aqui lo que haria si quieres usar js es revisar que este todo bien y luego el submit se lo mandas a php y que te inicie el session se lo metes
 en el action y ya te debe de funcionar -->

<!-- Hay cuando mandes el submit a traves de js le mandas al php con las variables ya revisadas y solo tienes que iniciar session llamando a la funcion
 que hicimos a principio de curso -->

<!-- Vale, voy a hacer eso y de que lo tenga hecho te digo y miramos mas si quieres. Va lujo ahora me avisas cierro aqui