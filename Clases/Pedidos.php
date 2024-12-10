<?php
/*
    Clase Pedido

    Descripción:
        La clase `Pedido` representa un pedido realizado por un usuario en el sistema de ventas. Contiene información clave sobre el pedido, como su estado, el precio total, la fecha y hora en que se realizó, y el identificador del usuario que realizó el pedido. Esta clase se utiliza para gestionar la información de un pedido dentro de una aplicación de ventas o restaurante.

    Atributos:
        - `ID_Pedido`: Identificador único del pedido.
        - `estado`: Estado actual del pedido (por ejemplo, "pendiente", "en preparación", "enviado", etc.).
        - `preciototal`: El precio total del pedido.
        - `fecha_hora`: Fecha y hora en que se realizó el pedido.
        - `ID_Usuario`: Identificador del usuario que realizó el pedido.

    Métodos:
        - `__construct($ID_Pedido, $estado, $preciototal, $fechaHora, $ID_Usuario)`: Constructor que inicializa los atributos de la clase con los valores proporcionados. Acepta el identificador del pedido (`ID_Pedido`), el estado del pedido (`estado`), el precio total (`preciototal`), la fecha y hora del pedido (`fechaHora`), y el identificador del usuario (`ID_Usuario`).
        - `__toString()`: Método que devuelve una representación en formato de cadena de la instancia del pedido, mostrando `ID_Pedido`, `estado`, `preciototal`, `fecha_hora`, y `ID_Usuario`.
        - `getIDPedido()`: Retorna el `ID_Pedido`, el identificador único del pedido.
        - `getEstado()`: Retorna el estado actual del pedido.
        - `getPrecioTotal()`: Retorna el precio total del pedido.
        - `getFechaHora()`: Retorna la fecha y hora en que se realizó el pedido.
        - `getIDUsuario()`: Retorna el `ID_Usuario`, el identificador del usuario que realizó el pedido.
        - `setIDPedido($ID_Pedido)`: Establece el valor del `ID_Pedido`.
        - `setEstado($estado)`: Establece el valor del `estado` del pedido.
        - `setPrecioTotal($preciototal)`: Establece el valor del `preciototal`.
        - `setFechaHora($fecha_hora)`: Establece el valor de `fecha_hora`.
        - `setIDUsuario($ID_Usuario)`: Establece el valor del `ID_Usuario`.

    Propósito:
        La clase `Pedido` es esencial para gestionar los pedidos dentro de una tienda o restaurante, permitiendo almacenar información sobre cada pedido, como su estado, precio total, y el usuario que realizó la compra. Esta clase puede ser utilizada para mostrar el historial de pedidos, actualizar el estado de los pedidos y calcular el precio total en un sistema de ventas.

    Ejemplo de uso:
        Crear un objeto de tipo `Pedido` y acceder a sus métodos:
        ```php
        $pedido = new Pedido(1, "pendiente", 25.50, "2024-12-10 12:30", 101);
        echo $pedido->getIDPedido();  // Muestra 1
        echo $pedido->getEstado();  // Muestra "pendiente"
        echo $pedido->getPrecioTotal();  // Muestra 25.50
        echo $pedido->getFechaHora();  // Muestra "2024-12-10 12:30"
        ```

    TODO:
        * Validar que el formato de la fecha y hora en `fecha_hora` sea correcto y consistente.
        * Mejorar el manejo del `estado` del pedido para incluir valores más específicos, como "cancelado", "enviado", etc.
        * Implementar métodos adicionales para calcular descuentos o impuestos, si es necesario.
*/

class Pedido {

    // Atributos
    public $ID_Pedido;

    public $estado;
    public $preciototal;
    public $fecha_hora;
    
    public $ID_Usuario;

    // Constructor
    public function __construct($ID_Pedido, $estado, $preciototal, $fechaHora, $ID_Usuario) {
        $this->ID_Pedido = $ID_Pedido;
        $this->estado = $estado;
        $this->preciototal = $preciototal;
        $this->fecha_hora = $fechaHora;  // Asegúrate de que la variable de fecha coincida
        $this->ID_Usuario = $ID_Usuario;
    }

    // To String
    public function __toString() {
        return "Pedido [ID_Pedido = $this->ID_Pedido, estado = $this->estado, precio total = $this->preciototal, fecha y hora = $this->fecha_hora, ID_Usuario = $this->ID_Usuario]";
    }

    // Métodos Getters
    public function getIDPedido() {
        return $this->ID_Pedido;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getPrecioTotal() {
        return $this->preciototal;
    }

    public function getFechaHora() {
        return $this->fecha_hora;
    }

    public function getIDUsuario() {
        return $this->ID_Usuario;
    }

    // Métodos Setters
    public function setIDPedido($ID_Pedido) {
        $this->ID_Pedido = $ID_Pedido;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setPrecioTotal($preciototal) {
        $this->preciototal = $preciototal;
    }

    public function setFechaHora($fecha_hora) {
        $this->fecha_hora = $fecha_hora;
    }

    public function setIDUsuario($ID_Usuario) {
        $this->ID_Usuario = $ID_Usuario;
    }
}
?>
