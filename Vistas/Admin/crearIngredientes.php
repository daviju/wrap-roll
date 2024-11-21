<link rel="stylesheet" href="./css/crearIngredientesStyle.css">

<div class="drag-drop-container">
    <div class="container">
        <h2>Crear Ingrediente</h2>
        <form id="drag-drop-form" method="post">
            <!-- Contenedor dividido en dos columnas -->
            <div class="input-container">
                <!-- Columna izquierda -->
                <div class="left-column">
                    <div class="input-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" required placeholder="Introduce el nombre del ingrediente"> 
                    </div>
                    <div class="input-group">
                        <label for="foto">Foto:</label>
                        <input type="file" id="foto" name="foto" required> 
                    </div>
                </div>

                <!-- Columna derecha -->
                <div class="right-column">
                    <div class="input-group">
                        <label for="precio">Precio:</label>
                        <input type="text" id="precio" name="precio" required placeholder="Introduce el precio del ingrediente"> 
                    </div>
                    <div class="input-group">
                        <label for="tipo">Tipo:</label>
                        <textarea id="tipo" name="tipo" required placeholder="Introduce si el ingrediente va a ser obligatorio o no"></textarea>
                    </div>
                </div>
            </div>

            <hr>

            <div class="list-container">
                <div class="list" id="list2">
                    <h3>Alergenos Seleccionados</h3>
                    <ul>
                        <!-- Items will be dropped here -->
                    </ul>
                </div>

                <div class="list" id="list1">
                    <h3>Alergenos</h3>
                    <ul>
                        <li draggable="true">Item 1</li>
                        <li draggable="true">Item 2</li>
                        <li draggable="true">Item 3</li>
                        <li draggable="true">Item 4</li>
                    </ul>
                </div>
            </div>
            <button type="submit" class="btn">Crear</button>
        </form>
    </div>

    <div class="space-filler"></div> <!-- Contenedor vacío para el espacio -->
</div>

