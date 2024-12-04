<?php

class RepositorioLineaPedido
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }

    // CREATE
    public static function create($linea)
    {
        $con = Database::getConection();
        $sqlaco = "INSERT INTO LineaPedido (idLineaPedido, linea_pedidos, Pedidos_idPedidos) 
                   VALUES (:idLineaPedido, :linea_pedidos, :idPedido)";

        $stm = $con->prepare($sqlaco);

        $stm->execute([
            'idLineaPedido' => $linea->getIDLineaPedido(),
            'linea_pedidos' => json_encode($linea->getLineaPedidos()), // Encode linea_pedidos -> JSON
            'idPedido' => $linea->getIDPedido(),
        ]);

        return $stm->rowCount() > 0;
    }

    // FIND BY ID
    public static function findById($id)
    {
        $con = Database::getConection();
        $sqlaco = "SELECT * FROM LineaPedido 
                    WHERE idLineaPedido = :id";

        $stm = $con->prepare($sqlaco);
        $stm->execute(['id' => $id]);

        $registro = $stm->fetch();

        if ($registro) {
            return new LineaPedido(
                $registro['idLineaPedido'],
                json_decode($registro['linea_pedidos'], true), // Decode linea_pedidos -> JSON
                $registro['Pedidos_idPedidos']
            );
        }

        return null;
    }

    // FIND ALL
    public static function findAll(): array
    {
        $con = Database::getConection();
        $sqlaco = "SELECT * FROM LineaPedido";

        $stm = $con->prepare($sqlaco);
        $stm->execute();

        $lineas = [];

        while ($registro = $stm->fetch()) {
            $lineas[] = new LineaPedido(
                $registro['idLineaPedido'],
                json_decode($registro['linea_pedidos'], true), // Decode linea_pedidos -> JSON
                $registro['Pedidos_idPedidos'],
            );
        }

        return $lineas;
    }

    // UPDATE
    public static function update($linea)
    {
        $con = Database::getConection();
        $sqlaco = "UPDATE LineaPedido 
                    SET linea_pedidos = :linea_pedidos, Pedidos_idPedidos = :idPedido 
                   WHERE idLineaPedido = :idLineaPedido";

        $stm = $con->prepare($sqlaco);

        $stm->execute([
            'idLineaPedido' => $linea->getIDLineaPedido(),
            'linea_pedidos' => json_encode($linea->getLineaPedidos()), // Encode linea_pedidos -> JSON
            'idPedido' => $linea->getIDPedido(),
        ]);

        return $stm->rowCount() > 0;
    }

    // DELETE
    public static function delete($id): bool
    {
        $con = Database::getConection();
        $sqlaco = "DELETE FROM LineaPedido 
                    WHERE idLineaPedido = :id";

        $stm = $con->prepare($sqlaco);
        $stm->execute(['id' => $id]);

        return $stm->rowCount() > 0;
    }
}
