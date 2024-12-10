<?php
/*
    Clase AlergenosUsuario

    Descripción:
        La clase `AlergenosUsuario` representa una relación entre un alérgeno y un usuario en el sistema. Se utiliza para gestionar la asociación entre los alérgenos que pueden afectar a un usuario específico.

    Atributos:
        - `id_alergenos`: Identificador único del alérgeno asociado.
        - `id_usuarios`: Identificador único del usuario asociado.

    Métodos:
        - `__construct($id_alergenos, $id_usuarios)`: Constructor de la clase que inicializa los atributos con los valores proporcionados.
        - `__toString()`: Método que devuelve una representación en formato de cadena de la instancia de la clase, incluyendo `id_alergenos` e `id_usuarios`.
        - `getIdAlergenos()`: Retorna el `id_alergenos`.
        - `getIdUsuarios()`: Retorna el `id_usuarios`.
        - `setIdAlergenos($id_alergenos)`: Establece el valor del `id_alergenos`.
        - `setIdUsuarios($id_usuarios)`: Establece el valor del `id_usuarios`.

    Propósito:
        Esta clase se utiliza para almacenar la relación entre un usuario y los alérgenos a los que es sensible. Es útil para gestionar qué alérgenos afectan a cada usuario y para almacenar dicha relación en la base de datos.

    Ejemplo de uso:
        Crear un objeto de tipo `AlergenosUsuario` y acceder a sus métodos:
        ```php
        $alergenoUsuario = new AlergenosUsuario(1, 10);
        echo $alergenoUsuario->getIdAlergenos();  // Muestra 1
        echo $alergenoUsuario->getIdUsuarios();   // Muestra 10
        echo $alergenoUsuario;                    // Muestra AlergenosUsuario [id_alergenos = 1, id_usuarios = 10]
        ```

    TODO:
        * Validar la existencia de los identificadores `id_alergenos` e `id_usuarios` antes de establecerlos.
*/

class AlergenosUsuario {

    // Atributos
    public $id_alergenos;
    public $id_usuarios;

    // Constructor
    public function __construct($id_alergenos, $id_usuarios) {
        $this->id_alergenos = $id_alergenos;
        $this->id_usuarios = $id_usuarios;
    }

    // To String
    public function __toString() {
        return "AlergenosUsuario [id_alergenos = $this->id_alergenos, id_usuarios = $this->id_usuarios]";
    }

    // Métodos Getters
    public function getIdAlergenos() {
        return $this->id_alergenos;
    }

    public function getIdUsuarios() {
        return $this->id_usuarios;
    }

    // Métodos Setters
    public function setIdAlergenos($id_alergenos) {
        $this->id_alergenos = $id_alergenos;
    }

    public function setIdUsuarios($id_usuarios) {
        $this->id_usuarios = $id_usuarios;
    }
}

?>
