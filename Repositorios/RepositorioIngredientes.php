<?php

class RepositorioIngredientes {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    // Método para obtener un ingrediente por ID
    public function findById($id) {
        try {
            $sql = "SELECT * FROM Ingredientes WHERE idIngredientes = :id";
            $stm = $this->con->prepare($sql);
            $stm->execute(['id' => $id]);
            $registro = $stm->fetch(PDO::FETCH_ASSOC);

            if ($registro) {
                return new Ingredientes(
                    $registro['idIngredientes'],
                    $registro['nombre'],
                    $registro['precio'],
                    $registro['tipo'],
                    $registro['foto']
                );
            } else {
                echo json_encode(["error" => "Ingrediente no encontrado."]);
                return null;
            }
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al obtener el ingrediente: " . $e->getMessage()]);
            return null;
        }
    }

    // Método para crear un nuevo ingrediente
    public function create(Ingredientes $ingrediente) {
        try {
            $sql = "INSERT INTO Ingredientes (idIngredientes, nombre, precio, tipo, foto)
                    VALUES (:idIngredientes, :nombre, :precio, :tipo, :foto)";
            $stm = $this->con->prepare($sql);

            $stm->bindValue(':idIngredientes', $ingrediente->getIDIngredientes());
            $stm->bindValue(':nombre', $ingrediente->getNombre());
            $stm->bindValue(':precio', $ingrediente->getPrecio());
            $stm->bindValue(':tipo', $ingrediente->getTipo());
            $stm->bindValue(':foto', $ingrediente->getFoto());

            return $stm->execute();
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al crear el ingrediente: " . $e->getMessage()]);
            return false;
        }
    }

    // Método para actualizar un ingrediente
    public function update(Ingredientes $ingrediente) {
        try {
            $sql = "UPDATE Ingredientes SET nombre = :nombre, precio = :precio, tipo = :tipo, foto = :foto
                    WHERE idIngredientes = :idIngredientes";
            $stm = $this->con->prepare($sql);

            $stm->bindValue(':idIngredientes', $ingrediente->getIDIngredientes());
            $stm->bindValue(':nombre', $ingrediente->getNombre());
            $stm->bindValue(':precio', $ingrediente->getPrecio());
            $stm->bindValue(':tipo', $ingrediente->getTipo());
            $stm->bindValue(':foto', $ingrediente->getFoto());

            return $stm->execute();
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al actualizar el ingrediente: " . $e->getMessage()]);
            return false;
        }
    }

    // Método para eliminar un ingrediente
    public function delete($id) {
        try {
            $sql = "DELETE FROM Ingredientes WHERE idIngredientes = :id";
            $stm = $this->con->prepare($sql);
            $stm->execute(['id' => $id]);
            return $stm->rowCount() > 0;
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al eliminar el ingrediente: " . $e->getMessage()]);
            return false;
        }
    }

    // Método para obtener todos los ingredientes
    public function findAll() {
        try {
            $sql = "SELECT * FROM Ingredientes";
            $stm = $this->con->prepare($sql);
            $stm->execute();
            $ingredientes = [];

            while ($registro = $stm->fetch(PDO::FETCH_ASSOC)) {
                $ingredientes[] = new Ingredientes(
                    $registro['idIngredientes'],
                    $registro['nombre'],
                    $registro['precio'],
                    $registro['tipo'],
                    $registro['foto']
                );
            }

            return $ingredientes;
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al obtener los ingredientes: " . $e->getMessage()]);
            return [];
        }
    }
}

?>
