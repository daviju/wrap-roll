<?php
/*
    Clase Alergenos

    Descripción:
        La clase `Alergenos` representa un alérgeno dentro de la aplicación. Un alérgeno es una sustancia que puede causar una reacción alérgica en los usuarios, y esta clase gestiona las propiedades y métodos relacionados con la información de los alérgenos.

    Atributos:
        - `ID_Alergenos`: Identificador único del alérgeno.
        - `tipo`: El tipo o nombre del alérgeno (por ejemplo, "Gluten", "Frutos secos", etc.).
        - `foto`: URL o ruta a una imagen representativa del alérgeno.

    Métodos:
        - `__construct($ID_Alergenos, $tipo, $foto)`: Constructor de la clase que inicializa los atributos del alérgeno.
        - `__toString()`: Método que devuelve una representación en formato de cadena de la instancia del alérgeno, incluyendo su `ID_Alergenos`, `tipo` y `foto`.
        - `getIDAlergenos()`: Retorna el `ID_Alergenos`.
        - `getTipo()`: Retorna el tipo del alérgeno.
        - `getFoto()`: Retorna la foto del alérgeno.
        - `setIDAlergenos($ID_Alergenos)`: Establece el valor del `ID_Alergenos`.
        - `setTipo($tipo)`: Establece el valor del `tipo`.
        - `setFoto($foto)`: Establece el valor de la `foto`.

    Propósito:
        Esta clase permite manejar los datos de los alérgenos en el sistema, proporcionándoles una estructura organizada y métodos para acceder y modificar sus propiedades.

    Ejemplo de uso:
        Crear un objeto de tipo `Alergenos` y acceder a sus métodos:
        ```php
        $alergeno = new Alergenos(1, "Gluten", "ruta/a/la/imagen.jpg");
        echo $alergeno->getTipo();  // Muestra "Gluten"
        echo $alergeno;             // Muestra la representación de la clase, algo como: Alergeno [ID_Alergenos = 1, tipo = Gluten, foto = ruta/a/la/imagen.jpg]
        ```

    TODO:
        * Agregar validación de los datos de entrada para asegurarse de que los valores para los alérgenos sean adecuados antes de ser establecidos.
*/

class Alergenos {

    // Atributos
    public $ID_Alergenos;

    public $tipo;
    public $foto;


    // Constructor
    public function __construct($ID_Alergenos, $tipo, $foto) {
        $this->ID_Alergenos = $ID_Alergenos;
        
        $this->tipo = $tipo;
        $this->foto = $foto;
    }


    // To String
    public function __toString() {
        return "Alergeno [ID_Alergenos = $this->ID_Alergenos, tipo = $this->tipo, foto = $this->foto]";
    }


    // Métodos Getters
    public function getIDAlergenos() {
        return $this->ID_Alergenos;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getFoto() {
        return $this->foto;
    }

    
    // Métodos Setters
    public function setIDAlergenos($ID_Alergenos) {
        $this->ID_Alergenos = $ID_Alergenos;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }
}
?>
