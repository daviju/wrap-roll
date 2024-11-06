<?php

class RepositorioPedido {
    private $con;

    public function __construct($con){
        $this->con = $con;
    }

    // CREATE
    public function create($pedido) {
        $stm = $this->con->prepare("INSERT INTO Pedidos (idPedidos, estado, preciototal, fecha_hora, direccion, Usuario_idUsuario) 
                                    VALUES (:idPedidos, :estado, :preciototal, :fecha_hora, :direccion, :idUsuario)");
        
        $stm->execute([
            'idPedidos' => $pedido->getIDPedido(),
            'estado' => $pedido->getEstado(),
            'direccion' => $pedido->getDireccion(),
            'preciototal' => $pedido->getPrecioTotal(),
            'fecha_hora' => $pedido->getFechaHora(),
            'idUsuario' => $pedido->getIDUsuario()
        ]);

        return $stm->rowCount() > 0;
    }

    // FIND BY ID
    public function findById($id){
        $stm = $this->con->prepare("SELECT * FROM Pedidos 
                                    WHERE idPedidos = :id");

        $stm->execute(['id' => $id]);
        
        $registro = $stm->fetch();

        if ($registro) {
            return new Pedido(
                $registro['idPedidos'],
                $registro['estado'],
                $registro['direccion'],
                $registro['preciototal'],
                $registro['fecha_hora'],
                $registro['Usuario_idUsuario']
            );
        }

        return null;
    }

    // FIND ALL
    public function findAll(): array {
        $stm = $this->con->prepare("SELECT * FROM Pedidos");
        $stm->execute();

        $pedidos = [];

        while ($registro = $stm->fetch()) {
            $pedidos[] = new Pedido(
                $registro['idPedidos'],
                $registro['estado'],
                $registro['direccion'],
                $registro['preciototal'],
                $registro['fecha_hora'],
                $registro['Usuario_idUsuario']
            );
        }
        
        return $pedidos;
    }

    // UPDATE
    public function update($pedido) {
        $stm = $this->con->prepare("UPDATE Pedidos SET estado = :estado, preciototal = :preciototal, direccion = :direccion, Usuario_idUsuario = :idUsuario 
                                    WHERE idPedidos = :idPedidos");

        $stm->execute([
            'idPedidos' => $pedido->getIDPedido(),
            'estado' => $pedido->getEstado(),
            'direccion' => $pedido->getDireccion(),
            'preciototal' => $pedido->getPrecioTotal(),
            'idUsuario' => $pedido->getIDUsuario()
        ]);

        return $stm->rowCount() > 0;
    }

    // DELETE
    public function delete($id): bool {
        $stm = $this->con->prepare("DELETE FROM Pedidos 
                                    WHERE idPedidos = :id");

        $stm->execute(['id' => $id]);

        return $stm->rowCount() > 0;
    }
}
