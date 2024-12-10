<?php
/*
    Clase KebabIngredientes

    Descripción:
        La clase `KebabIngredientes` representa una relación entre los kebabs y los ingredientes que los componen. Esta clase actúa como una tabla intermedia entre las entidades `Kebab` e `Ingrediente`, almacenando las asociaciones entre ellos. Es útil para gestionar los ingredientes que forman parte de un kebab específico en el sistema.

    Atributos:
        - `ID_Kebab`: Identificador del kebab relacionado.
        - `ID_Ingrediente`: Identificador del ingrediente relacionado con el kebab.

    Métodos:
        - `__construct($ID_Kebab, $ID_Ingrediente)`: Constructor que inicializa los atributos de la clase, permitiendo definir el `ID_Kebab` y el `ID_Ingrediente` que representan la relación entre un kebab y un ingrediente.
        - `__toString()`: Método que devuelve una representación en formato de cadena de la instancia de `KebabIngredientes`, mostrando el `ID_Kebab` y `ID_Ingrediente`.
        - `getIDKebab()`: Retorna el `ID_Kebab`, el identificador del kebab.
        - `getIDIngrediente()`: Retorna el `ID_Ingrediente`, el identificador del ingrediente.
        - `setIDKebab($ID_Kebab)`: Establece el valor del `ID_Kebab`.
        - `setIDIngrediente($ID_Ingrediente)`: Establece el valor del `ID_Ingrediente`.

    Propósito:
        Esta clase es fundamental para gestionar las relaciones entre los kebabs y sus ingredientes en un sistema de pedidos o gestión de menú, donde se necesita asociar varios ingredientes a un kebab específico. Actúa como una tabla de asociación en una base de datos relacional.

    Ejemplo de uso:
        Crear un objeto de tipo `KebabIngredientes` y acceder a sus métodos:
        ```php
        $kebabIngrediente = new KebabIngredientes(1, 5); // Relaciona el kebab con ID 1 y el ingrediente con ID 5
        echo $kebabIngrediente->getIDKebab();  // Muestra 1
        echo $kebabIngrediente->getIDIngrediente();  // Muestra 5
        ```

    TODO:
        * Validar las asociaciones entre kebabs e ingredientes para asegurar que un ingrediente no esté repetido para el mismo kebab.
        * Considerar la posibilidad de añadir más atributos si se necesitan propiedades adicionales para la relación entre kebabs e ingredientes (por ejemplo, cantidades o modificaciones específicas para un ingrediente en particular en un kebab).
*/

class KebabIngredientes {

    // Atributos
    public $ID_Kebab;
    public $ID_Ingrediente;

    
    // Constructor
    public function __construct($ID_Kebab, $ID_Ingrediente) {
        $this->ID_Kebab = $ID_Kebab;
        $this->ID_Ingrediente = $ID_Ingrediente;
    }


    // To String
    public function __toString() {
        return "KebabIngredientes [ID_Kebab = $this->ID_Kebab, ID_Ingrediente = $this->ID_Ingrediente]";
    }


    // Métodos Getters
    public function getIDKebab() {
        return $this->ID_Kebab;
    }

    public function getIDIngrediente() {
        return $this->ID_Ingrediente;
    }


    // Métodos Setters
    public function setIDKebab($ID_Kebab) {
        $this->ID_Kebab = $ID_Kebab;
    }

    public function setIDIngrediente($ID_Ingrediente) {
        $this->ID_Ingrediente = $ID_Ingrediente;
    }
}
?>
