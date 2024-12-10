<?php
/*
    Clase Kebab

    Descripción:
        La clase `Kebab` representa un kebab en el sistema, con atributos que definen sus características, como el nombre, foto, precio e ingredientes asociados. Esta clase es útil para gestionar y mostrar información sobre los diferentes tipos de kebabs disponibles en el menú, junto con los ingredientes que los componen.

    Atributos:
        - `ID_Kebab`: Identificador único del kebab.
        - `nombre`: Nombre del kebab.
        - `foto`: URL o ruta de la foto que representa el kebab.
        - `precio`: Precio del kebab.
        - `ingredientes`: Lista de ingredientes asociados al kebab.

    Métodos:
        - `__construct($ID_Kebab, $nombre, $foto, $precio, $ingredientes = [])`: Constructor que inicializa los atributos de la clase, permitiendo definir el ID, nombre, foto, precio e ingredientes de un kebab.
        - `__toString()`: Método que devuelve una representación en formato de cadena de la instancia del kebab, mostrando el `ID_Kebab`, `nombre`, `foto`, `precio` e `ingredientes`.
        - `getIDKebab()`: Retorna el `ID_Kebab`, el identificador único del kebab.
        - `getNombre()`: Retorna el nombre del kebab.
        - `getFoto()`: Retorna la URL o ruta de la foto del kebab.
        - `getPrecio()`: Retorna el precio del kebab.
        - `getIngredientes()`: Retorna la lista de ingredientes asociados al kebab.
        - `setIDKebab($ID_Kebab)`: Establece el valor del `ID_Kebab`.
        - `setNombre($nombre)`: Establece el valor del nombre del kebab.
        - `setFoto($foto)`: Establece el valor de la foto del kebab.
        - `setPrecio($precio)`: Establece el valor del precio del kebab.
        - `setIngredientes($ingredientes)`: Establece la lista de ingredientes asociados al kebab.

    Propósito:
        Esta clase es fundamental para la gestión de los kebabs dentro de un sistema de pedidos en línea o un sistema de gestión de inventario de alimentos, donde cada kebab tiene un precio, una foto y una lista de ingredientes que se pueden modificar según sea necesario.

    Ejemplo de uso:
        Crear un objeto de tipo `Kebab` y acceder a sus métodos:
        ```php
        $kebab = new Kebab(1, "Kebab Clásico", "ruta_a_foto.jpg", 5.99, ["Carne", "Lechuga", "Tomate"]);
        echo $kebab->getNombre();    // Muestra "Kebab Clásico"
        echo $kebab->getPrecio();    // Muestra 5.99
        echo $kebab->getIngredientes(); // Muestra ["Carne", "Lechuga", "Tomate"]
        ```

    TODO:
        * Validar los datos del kebab, como el precio y los ingredientes, para asegurar que no haya valores incorrectos o vacíos.
        * Incluir un método para agregar o eliminar ingredientes a la lista de ingredientes de un kebab.
*/

class Kebab {
    
    // Atributos
    public $ID_Kebab;
    public $nombre;
    public $foto;
    public $precio;

    public $ingredientes = [];

    // Constructor
    public function __construct($ID_Kebab, $nombre, $foto, $precio, $ingredientes = []) {
        $this->ID_Kebab = $ID_Kebab;
        $this->nombre = $nombre;
        $this->foto = $foto;
        $this->precio = $precio;
        $this->ingredientes = $ingredientes;
    }


    // To String
    public function __toString() {
        return "Kebab [ID_Kebab = $this->ID_Kebab, nombre = $this->nombre, foto = $this->foto, precio = $this->precio, ingredientes = " . implode(", ", $this->ingredientes) . "]";
    }


    // Métodos Getters
    public function getIDKebab() {
        return $this->ID_Kebab;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getFoto() {
        return $this->foto;
    }

    public function getPrecio(){
        return $this->precio;
    }

    public function getIngredientes() {
        return $this->ingredientes;
    }


    // Métodos Setters
    public function setIDKebab($ID_Kebab) {
        $this->ID_Kebab = $ID_Kebab;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }

    public function setPrecio($precio){
        $this->precio = $precio;
    }

    public function setIngredientes($ingredientes) {
        $this->ingredientes = $ingredientes;
    }
    
}
?>
