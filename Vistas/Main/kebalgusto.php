<link rel="stylesheet" href="./css/kebabGustoStyle.css">

<div class="drag-drop-container">
    <div class="container">
        <h2>Personaliza tu Kebab</h2>
        <form id="drag-drop-form" method="post">
            <!-- Contenedor dividido en dos columnas -->
            <div class="input-container">
                <!-- Columna izquierda -->
                <div class="left-column">
                    <div class="input-group">
                        <label for="nombre">Precio Calculado:</label>
                        <input type="text" id="precio" name="precio" required placeholder="El precio tu Kebab se calculará en base a tus ingredientes"> 
                    </div>
                </div>

                <!-- Columna derecha -->
                <div class="right-column">
                    <div class="input-group">
                        <label for="precio">Alergenos:</label>
                        <input type="text" id="precio" name="precio" required placeholder="Alergenos que contiene tu Kebab en base a tus ingredientes"> 
                    </div>
                </div>
            </div>

            <hr>

            <div class="list-container">
                <!-- Lista de Ingredientes seleccionados -->
                <div class="list" id="list2">
                    <h3>Ingredientes Seleccionados</h3>
                    <div class="list-items">
                        <!-- Los Ingredientes seleccionados se colocarán aquí -->
                    </div>
                </div>

                <!-- Lista de alérgenos disponibles -->
                <div class="list" id="list1">
                    <h3>Ingredientes</h3>
                    <div class="list-items">
                        <!-- Los Ingredientes disponibles se cargarán aquí -->
                    </div>
                </div>
            </div>

            <button type="submit" class="btn">Añadir al Carrito</button>
            <button type="reset" class="btnReset">Borrar</button>
            <button type="submit" class="btnSalir">Salir</button>
        </form>
    </div>
</div>