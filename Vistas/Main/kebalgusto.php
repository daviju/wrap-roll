<link rel="stylesheet" href="./css/kebabgustoStyle.css">

<div class="drag-drop-container">
    <div class="container">
        <h2>Crear Kebab</h2>
        <form id="drag-drop-form" method="post">
            <!-- Contenedor dividido en dos columnas -->
            <div class="input-container">
                <!-- Columna izquierda -->
                <div class="left-column">
                    <div class="input-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" required placeholder="Introduce el nombre del kebab"> 
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
                        <input type="text" id="precio" name="precio" required placeholder="Introduce el precio del kebab"> 
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

            <hr>

            <div class="alergenos">
                <h3>Alergenos</h3>
                <div class="alergenos-container">
                    <!-- Los alérgenos se cargarán aqui -->
                </div>
            </div>

            <button type="submit" class="btn">Enviar al Carrito</button>
        </form>
    </div>
</div>

<script src="./js/clasesjs/crearKebabGusto.js" defer></script>
