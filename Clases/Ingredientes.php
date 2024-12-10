<?php
/*
    Clase Ingredientes

    Descripción:
        La clase `Ingredientes` representa un ingrediente utilizado en la creación de kebabs. Contiene información sobre su nombre, precio, tipo, foto y una lista de alérgenos asociados. Esta clase se utiliza para gestionar los ingredientes que se pueden añadir a un kebab.

    Atributos:
        - `ID_Ingredientes`: Identificador único del ingrediente.
        - `nombre`: Nombre del ingrediente (por ejemplo, "Pollo", "Ternera", etc.).
        - `precio`: Precio del ingrediente.
        - `tipo`: Tipo del ingrediente (por ejemplo, "Carne", "Verdura", etc.).
        - `foto`: URL de la imagen asociada al ingrediente.
        - `alergenos`: Array que contiene los alérgenos asociados al ingrediente.

    Métodos:
        - `__construct($ID_Ingredientes, $nombre, $precio, $tipo, $foto, $alergenos = [])`: Constructor que inicializa los atributos de la clase con los valores proporcionados.
        - `__toString()`: Método que devuelve una representación en formato de cadena de la instancia de la clase, incluyendo todos los atributos del ingrediente y sus alérgenos.
        - `getIDIngredientes()`: Retorna el `ID_Ingredientes`.
        - `getNombre()`: Retorna el `nombre`.
        - `getPrecio()`: Retorna el `precio`.
        - `getTipo()`: Retorna el `tipo`.
        - `getFoto()`: Retorna la `foto`.
        - `getAlergenos()`: Retorna los `alergenos` asociados al ingrediente.
        - `setIDIngredientes($ID_Ingredientes)`: Establece el valor de `ID_Ingredientes`.
        - `setNombre($nombre)`: Establece el valor de `nombre`.
        - `setPrecio($precio)`: Establece el valor de `precio`.
        - `setTipo($tipo)`: Establece el valor de `tipo`.
        - `setFoto($foto)`: Establece el valor de `foto`.
        - `setAlergenos($alergenos)`: Establece el valor de `alergenos`.

    Propósito:
        Esta clase se utiliza para representar los ingredientes disponibles en el sistema, que los usuarios pueden agregar a sus kebabs. Los ingredientes pueden tener asociados alérgenos, lo que permite gestionar la información de manera detallada y ofrecer un servicio personalizado y seguro para los clientes con alergias alimentarias.

    Ejemplo de uso:
        Crear un objeto de tipo `Ingredientes` y acceder a sus métodos:
        ```php
        $ingrediente = new Ingredientes(1, "Pollo", 2.50, "Carne", "url_de_imagen", ["Gluten", "Soja"]);
        echo $ingrediente->getNombre();      // Muestra "Pollo"
        echo $ingrediente;                   // Muestra la representación completa del ingrediente
        ```

    TODO:
        * Validar los alérgenos para asegurarse de que sean valores válidos.
        * Implementar una función para calcular el precio total de los ingredientes en un kebab, teniendo en cuenta los precios individuales.
        * Mejorar la gestión de imágenes para los ingredientes (por ejemplo, permitir la carga dinámica de imágenes en el sistema).
*/

class Ingredientes {
    
    // Atributos
    public $ID_Ingredientes;

    public $nombre;
    public $precio;
    public $tipo;
    public $foto;

    public $alergenos = [];


    // Constructor
    public function __construct($ID_Ingredientes, $nombre, $precio, $tipo, $foto, $alergenos = []) {
        $this->ID_Ingredientes = $ID_Ingredientes;
        
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->tipo = $tipo;
        $this->foto = $foto;
        $this->alergenos = $alergenos;
    }


    // To String
    public function __toString() {
        return "Ingrediente [ID_Ingredientes = $this->ID_Ingredientes, nombre = $this->nombre, precio = $this->precio, tipo = $this->tipo, foto = $this->foto, alergenos = [" . implode(", ", $this->alergenos) . "]";
    }
    


    // Métodos para obtener los valores de los atributos
    public function getIDIngredientes() {
        return $this->ID_Ingredientes;
    }


    public function getNombre() {
        return $this->nombre;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getFoto() {
        return $this->foto;
    }

    public function getAlergenos() {
        return $this->alergenos;
    }
    

    // Métodos para establecer los valores de los atributos
    public function setIDIngredientes($ID_Ingredientes) {
        $this->ID_Ingredientes = $ID_Ingredientes;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }

    public function setAlergenos($alergenos) {
        $this->alergenos = $alergenos;
    }
}
?>
