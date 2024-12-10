<?php
/*
    Clase Direccion

    Descripción:
        La clase `Direccion` representa una dirección asociada a un usuario. Contiene los atributos necesarios para almacenar los detalles completos de una dirección, como el nombre de la vía, el número, la escalera, entre otros.

    Atributos:
        - `ID_Direccion`: Identificador único de la dirección.
        - `nombrevia`: Nombre de la vía (calle, avenida, etc.).
        - `numero`: Número de la dirección (número de puerta, bloque, etc.).
        - `tipovia`: Tipo de vía (calle, avenida, plaza, etc.).
        - `puerta`: Número de puerta o referencia adicional de ubicación.
        - `escalera`: Información sobre la escalera, si aplica.
        - `planta`: Información sobre la planta, si aplica.
        - `localidad`: Localidad o ciudad de la dirección.
        - `ID_Usuario`: Identificador del usuario al que pertenece la dirección.

    Métodos:
        - `__construct($ID_Direccion, $nombrevia, $numero, $tipovia, $puerta, $escalera, $planta, $localidad, $ID_Usuario)`: Constructor que inicializa los atributos de la clase con los valores proporcionados.
        - `__toString()`: Método que devuelve una representación en formato de cadena de la instancia de la clase, concatenando todos los atributos de la dirección.
        - `getIDDireccion()`: Retorna el `ID_Direccion`.
        - `getNombrevia()`: Retorna el `nombrevia`.
        - `getNumero()`: Retorna el `numero`.
        - `getTipovia()`: Retorna el `tipovia`.
        - `getPuerta()`: Retorna el `puerta`.
        - `getEscalera()`: Retorna el `escalera`.
        - `getPlanta()`: Retorna el `planta`.
        - `getLocalidad()`: Retorna el `localidad`.
        - `getID_Usuario()`: Retorna el `ID_Usuario`.
        - `setIDDireccion($ID_Direccion)`: Establece el valor del `ID_Direccion`.
        - `setNombrevia($nombrevia)`: Establece el valor del `nombrevia`.
        - `setNumero($numero)`: Establece el valor del `numero`.
        - `setTipovia($tipovia)`: Establece el valor del `tipovia`.
        - `setPuerta($puerta)`: Establece el valor del `puerta`.
        - `setIDUsuario($ID_Usuario)`: Establece el valor del `ID_Usuario`.

    Propósito:
        Esta clase se utiliza para representar las direcciones de los usuarios en el sistema. Es útil tanto para mostrar direcciones en formularios como para almacenar y gestionar direcciones en la base de datos asociadas a los usuarios.

    Ejemplo de uso:
        Crear un objeto de tipo `Direccion` y acceder a sus métodos:
        ```php
        $direccion = new Direccion(1, "Calle Ficticia", "123", "Calle", "A", "2", "3", "Madrid", 10);
        echo $direccion->getNombrevia();    // Muestra "Calle Ficticia"
        echo $direccion;                    // Muestra la dirección completa concatenada
        ```

    TODO:
        * Validar los datos antes de asignarlos a los atributos, asegurándose de que la dirección tenga el formato adecuado.
        * Agregar métodos adicionales para trabajar con direcciones, como validar la existencia de la dirección en la base de datos o calcular la distancia entre direcciones.
*/

Class Direccion {

    // Atributos
    public $ID_Direccion;

    public $nombrevia;
    public $numero;
    public $tipovia;
    public $puerta;
    public $escalera;
    public $planta;
    public $localidad;

    public $ID_Usuario;


    // Constructor
    public function __construct($ID_Direccion, $nombrevia, $numero, $tipovia, $puerta, $escalera, $planta, $localidad, $ID_Usuario) {
        $this->ID_Direccion = $ID_Direccion;
    
        $this->nombrevia = $nombrevia;
        $this->numero = $numero;
        $this->tipovia = $tipovia;
        $this->puerta = $puerta;
        $this->escalera = $escalera;
        $this->planta = $planta;
        $this->localidad = $localidad;
        
        $this->ID_Usuario = $ID_Usuario;
    }


    // To String
    public function __toString() {
        return $this->ID_Direccion . " " . $this->nombrevia . " " . $this->numero . " " . $this->tipovia . " " . $this->puerta . " " . $this->escalera . " " . $this->planta . " " . $this->localidad . " " . $this->ID_Usuario;
    }


    // Métodos Getters
    public function getIDDireccion() {
        return $this->ID_Direccion;
    }
    
    public function getNombrevia() {
        return $this->nombrevia;
    }
    
    public function getNumero() {
        return $this->numero;
    }
    
    public function getTipovia() {
        return $this->tipovia;
    }
    
    public function getPuerta() {
        return $this->puerta;
    }
    
    public function getEscalera() {
        return $this->escalera;
    }
    
    public function getPlanta() {
        return $this->planta;
    }

    public function getLocalidad() {
        return $this->localidad;
    }

    public function getID_Usuario() {
        return $this->ID_Usuario;
    }


    // Métodos Setters
    public function setIDDireccion($ID_Direccion) {
        $this->ID_Direccion = $ID_Direccion;
    }
    
    public function setNombrevia($nombrevia) {
        $this->nombrevia = $nombrevia;
    }
    
    public function setNumero($numero) {
        $this->numero = $numero;
    }
    
    public function setTipovia($tipovia) {
        $this->tipovia = $tipovia;
    }
    
    public function setPuerta($puerta) {
        $this->puerta = $puerta;
    }

    public function setIDUsuario($ID_Usuario) {
        $this->ID_Usuario = $ID_Usuario;
    }
}