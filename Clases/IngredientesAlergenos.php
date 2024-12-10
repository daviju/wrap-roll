<?php
/*
    Clase IngredientesAlergenos

    Descripción:
        La clase `IngredientesAlergenos` establece una relación entre los ingredientes y los alérgenos que pueden contener. Es una clase de asociación que se utiliza para vincular un ingrediente específico con uno o más alérgenos en el sistema.

    Atributos:
        - `ID_Ingredientes`: Identificador único del ingrediente asociado.
        - `ID_Alergenos`: Identificador único del alérgeno asociado al ingrediente.

    Métodos:
        - `__construct($ID_Ingredientes, $ID_Alergenos)`: Constructor que inicializa los atributos de la clase con los valores proporcionados, estableciendo la relación entre el ingrediente y el alérgeno.
        - `__toString()`: Método que devuelve una representación en formato de cadena de la instancia de la clase, mostrando el `ID_Ingredientes` y el `ID_Alergenos`.
        - `getIDIngredientes()`: Retorna el `ID_Ingredientes`, el identificador del ingrediente asociado.
        - `getIDAlergenos()`: Retorna el `ID_Alergenos`, el identificador del alérgeno asociado.
        - `setIDIngredientes($ID_Ingredientes)`: Establece el valor de `ID_Ingredientes`.
        - `setIDAlergenos($ID_Alergenos)`: Establece el valor de `ID_Alergenos`.

    Propósito:
        Esta clase se utiliza para gestionar las asociaciones entre ingredientes y alérgenos, permitiendo a los usuarios conocer qué alérgenos están presentes en cada ingrediente. Esto es fundamental para la gestión de información sobre la seguridad alimentaria y para ofrecer un servicio adecuado a personas con alergias.

    Ejemplo de uso:
        Crear un objeto de tipo `IngredientesAlergenos` y acceder a sus métodos:
        ```php
        $asociacion = new IngredientesAlergenos(1, 2);
        echo $asociacion->getIDIngredientes();   // Muestra 1
        echo $asociacion->getIDAlergenos();      // Muestra 2
        ```

    TODO:
        * Validar que los `ID_Ingredientes` y `ID_Alergenos` existan en las bases de datos correspondientes antes de crear la asociación.
        * Agregar un método para obtener los alérgenos asociados a un ingrediente específico.
*/

class IngredientesAlergenos {

    // Atributos
    public $ID_Ingredientes;
    public $ID_Alergenos;


    // Constructor
    public function __construct($ID_Ingredientes, $ID_Alergenos){
        $this->ID_Ingredientes = $ID_Ingredientes;
        $this->ID_Alergenos = $ID_Alergenos;
    }


    // To String
    public function __toString() {
        return "IngredientesAlergenos [ID_Ingredientes = $this->ID_Ingredientes, ID_Alergenos = $this->ID_Alergenos]";
    }


    // Métodos Getters
    public function getIDIngredientes() {
        return $this->ID_Ingredientes;
    }

    public function getIDAlergenos() {
        return $this->ID_Alergenos;
    }
    
    
    // Métodos Setters
    public function setIDIngredientes($ID_Ingredientes) {
        $this->ID_Ingredientes = $ID_Ingredientes;
    }

    public function setIDAlergenos($ID_Alergenos) {
        $this->ID_Alergenos = $ID_Alergenos;
    }
}
?>
