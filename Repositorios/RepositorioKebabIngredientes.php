<?php

class RepositorioKebabIngredientes {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    // Método para crear una relación entre Kebab e Ingrediente
    public function create(KebabIngredientes $kebabIngredientes) {
        try {
            $sql = "INSERT INTO KebabIngredientes (Kebab_idKebab, Ingredientes_idIngredientes) 
                    VALUES (:idKebab, :idIngrediente)";
            $stm = $this->con->prepare($sql);

            $stm->bindValue(':idKebab', $kebabIngredientes->getIDKebab());
            $stm->bindValue(':idIngrediente', $kebabIngredientes->getIDIngrediente());

            return $stm->execute();
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al crear la relación: " . $e->getMessage()]);
            return false;
        }
    }

    // Método para obtener una relación por los IDs de Kebab e Ingrediente
    public function findByIds($idKebab, $idIngrediente) {
        try {
            $sql = "SELECT * FROM KebabIngredientes 
                    WHERE Kebab_idKebab = :idKebab AND Ingredientes_idIngredientes = :idIngrediente";
            $stm = $this->con->prepare($sql);
            $stm->execute([
                'idKebab' => $idKebab,
                'idIngrediente' => $idIngrediente
            ]);
            $registro = $stm->fetch(PDO::FETCH_ASSOC);

            if ($registro) {
                return new KebabIngredientes(
                    $registro['Kebab_idKebab'],
                    $registro['Ingredientes_idIngredientes']
                );
            } else {
                echo json_encode(["error" => "Relación no encontrada."]);
                return null;
            }
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al obtener la relación: " . $e->getMessage()]);
            return null;
        }
    }

    // Método para obtener todas las relaciones
    public function findAll() {
        try {
            $sql = "SELECT * FROM KebabIngredientes";
            $stm = $this->con->prepare($sql);
            $stm->execute();
            $kebabsIngredientes = [];

            while ($registro = $stm->fetch(PDO::FETCH_ASSOC)) {
                $kebabsIngredientes[] = new KebabIngredientes(
                    $registro['Kebab_idKebab'],
                    $registro['Ingredientes_idIngredientes']
                );
            }

            return $kebabsIngredientes;
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al obtener las relaciones: " . $e->getMessage()]);
            return [];
        }
    }

    // Método para actualizar una relación
    public function update(KebabIngredientes $kebabIngredientes) {
        try {
            $sql = "UPDATE KebabIngredientes 
                    SET Ingredientes_idIngredientes = :idIngrediente 
                    WHERE Kebab_idKebab = :idKebab";
            $stm = $this->con->prepare($sql);

            $stm->bindValue(':idKebab', $kebabIngredientes->getIDKebab());
            $stm->bindValue(':idIngrediente', $kebabIngredientes->getIDIngrediente());

            return $stm->execute();
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al actualizar la relación: " . $e->getMessage()]);
            return false;
        }
    }

    // Método para eliminar una relación
    public function delete($idKebab, $idIngrediente) {
        try {
            $sql = "DELETE FROM KebabIngredientes 
                    WHERE Kebab_idKebab = :idKebab AND Ingredientes_idIngredientes = :idIngrediente";
            $stm = $this->con->prepare($sql);
            $stm->execute([
                'idKebab' => $idKebab,
                'idIngrediente' => $idIngrediente
            ]);
            return $stm->rowCount() > 0;
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al eliminar la relación: " . $e->getMessage()]);
            return false;
        }
    }
}

?>
