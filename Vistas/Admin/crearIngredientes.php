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
                        <div class="preview-container">
                            <span>Subir o arrastrar imagen aquí</span>
                            <input type="file" id="foto" name="foto" required accept="image/*" style="display: none;">
                        </div>

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
                <!-- Lista de alérgenos seleccionados -->
                <div class="list" id="list2">
                    <h3>Alergenos Seleccionados</h3>
                    <div class="list-items">
                        <!-- Los alérgenos seleccionados se colocarán aquí -->
                    </div>
                </div>

                <!-- Lista de alérgenos disponibles -->
                <div class="list" id="list1">
                    <h3>Alergenos</h3>
                    <div class="list-items">
                        <!-- Los alérgenos disponibles se cargarán aquí -->
                    </div>
                </div>
            </div>

            <button type="submit" class="btn">Crear</button>
        </form>
    </div>
</div>

<script src="./js/clasesjs/crearIngredientes.js" defer></script>