<?php

class RepositorioIngredientesAlergenos {
    public static $con;

    // CREATE
    public static function create($ingredienteAlergeno) {
        try {
            $con = Database::getConection();
            $sqlaco = "INSERT INTO Ingredientes_Alergenos (Ingredientes_idIngredientes, Alergenos_idAlergenos) 
                       VALUES (:idIngredientes, :idAlergenos)";

            $stm = $con->prepare($sqlaco);
            $stm->execute([
                'idIngredientes' => $ingredienteAlergeno->getIDIngredientes(),
                'idAlergenos' => $ingredienteAlergeno->getIDAlergenos(),
            ]);

            return $stm->rowCount() > 0;
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al crear el ingrediente-alergeno: " . $e->getMessage()]);
            return false;
        }
    }

    // FIND BY ID
    public static function findById($idIngredientes, $idAlergenos) {
        try {
            $con = Database::getConection();
            $sqlaco = "SELECT * FROM Ingredientes_Alergenos 
                       WHERE Ingredientes_idIngredientes = :idIngredientes 
                       AND Alergenos_idAlergenos = :idAlergenos";

            $stm = $con->prepare($sqlaco);
            $stm->execute([
                'idIngredientes' => $idIngredientes,
                'idAlergenos' => $idAlergenos,
            ]);

            return $stm->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al obtener el ingrediente-alergeno: " . $e->getMessage()]);
            return null;
        }
    }

    // FIND ALL
    public static function findAll(): array {
        try {
            $con = Database::getConection();
            $sqlaco = "SELECT * FROM Ingredientes_Alergenos";
            $stm = $con->prepare($sqlaco);
            $stm->execute();

            $ingredientesAlergenos = [];
            while ($registro = $stm->fetch(PDO::FETCH_ASSOC)) {
                $ingredienteAlergeno = new IngredientesAlergenos(
                    $registro['Ingredientes_idIngredientes'],
                    $registro['Alergenos_idAlergenos']
                );
                array_push($ingredientesAlergenos, $ingredienteAlergeno);
            }

            return $ingredientesAlergenos;
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al obtener los ingredientes-alergenos: " . $e->getMessage()]);
            return [];
        }
    }

    // FIND ALL BY INGREDIENTE ID
    public static function findAllByIngredienteId($idIngredientes): array {
        try {
            $con = Database::getConection();
            $sqlaco = "SELECT * FROM Ingredientes_Alergenos 
                       WHERE Ingredientes_idIngredientes = :idIngredientes";
            $stm = $con->prepare($sqlaco);
            $stm->execute([
                'idIngredientes' => $idIngredientes,
            ]);

            $ingredientesAlergenos = [];
            while ($registro = $stm->fetch(PDO::FETCH_ASSOC)) {
                $ingredienteAlergeno = new IngredientesAlergenos(
                    $registro['Ingredientes_idIngredientes'],
                    $registro['Alergenos_idAlergenos']
                );
                array_push($ingredientesAlergenos, $ingredienteAlergeno);
            }

            return $ingredientesAlergenos;
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al obtener los ingredientes-alergenos por ID: " . $e->getMessage()]);
            return [];
        }
    }

    // UPDATE
    public static function update($ingredienteAlergeno) {
        try {
            $con = Database::getConection();
            $sqlaco = "UPDATE Ingredientes_Alergenos 
                       SET Alergenos_idAlergenos = :idAlergenos 
                       WHERE Ingredientes_idIngredientes = :idIngredientes";

            $stm = $con->prepare($sqlaco);
            $stm->execute([
                'idIngredientes' => $ingredienteAlergeno->getIDIngredientes(),
                'idAlergenos' => $ingredienteAlergeno->getIDAlergenos(),
            ]);

            return $stm->rowCount() > 0;
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al actualizar el ingrediente-alergeno: " . $e->getMessage()]);
            return false;
        }
    }

    // DELETE
    public static function delete($idIngredientes, $idAlergenos): bool {
        try {
            $con = Database::getConection();
            $sqlaco = "DELETE FROM Ingredientes_Alergenos 
                       WHERE Ingredientes_idIngredientes = :idIngredientes 
                       AND Alergenos_idAlergenos = :idAlergenos";

            $stm = $con->prepare($sqlaco);
            $stm->execute([
                'idIngredientes' => $idIngredientes,
                'idAlergenos' => $idAlergenos,
            ]);

            return $stm->rowCount() > 0;
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al eliminar el ingrediente-alergeno: " . $e->getMessage()]);
            return false;
        }
    }
}

?>
