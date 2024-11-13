<?php

class AlergenosUsuario {

    // Atributos
    private $id_alergenos;
    private $id_usuarios;

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
