<link rel="stylesheet" href="./css/crearKebabStyle.css">

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
                        <input type="text" id="nombre" name="nombre" required placeholder="Introduce el nombre del Kebab"> 
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
                        <input type="text" id="precio" name="precio" required placeholder="Introduce el precio del Kebab"> 
                    </div>
                </div>
            </div>

            <hr>

            <div class="list-container">
                <!-- Lista de ingredientes seleccionados -->
                <div class="list" id="list2">
                    <h3>Ingredientes Seleccionados</h3>
                    <div class="list-items">
                        <!-- Los ingredientes seleccionados se colocarán aquí -->
                    </div>
                </div>

                <!-- Lista de ingredientes disponibles -->
                <div class="list" id="list1">
                    <h3>Ingredientes Disponibles</h3>
                    <div class="list-items">
                        <!-- Los ingredientes disponibles se cargarán aquí -->
                    </div>
                </div>
            </div>

            <!-- Contenedor de alérgenos -->
            <div class="alergenos">
                <h3>Alergenos</h3>
                <div class="alergenos-container">
                    <!-- Los alérgenos se cargarán aquí -->
                </div>
            </div>

            <!-- Contenedor del botón "Crear" -->
            <div class="btn-container">
                <button class="btn">Crear</button>
            </div>
        </form>
    </div>
</div>

<script src="./js/clasesjs/crearKebab.js" defer></script>
