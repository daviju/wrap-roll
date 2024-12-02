<?php

class RepositorioKebab {
    private $con;

    public function __construct($con){
        $this->con = $con;
    }

    // CREATE
    public function create($kebab) {
        $con = Database::getConection();

        try {
            $con->beginTransaction();

            $sql ="INSERT INTO Kebab (nombre, foto, precio) 
                    VALUES (:nombre, :foto, :precio)";
            $stmt = $con->prepare($sql);

            $stmt->bindValue(':nombre', $kebab->nombre);
            $stmt->bindValue(':foto', $kebab->foto);
            $stmt->bindValue(':precio', $kebab->precio);

            // Insertar kebab
            if (!$stmt->execute()) {
                throw new Exception("Error al insertar el kebab.");
            }

            // Obtener el id del kebab insertado
            $nuevoID = $con->lastInsertId();

            // Asociar alérgenos al nuevo kebab
            $kebab->ID_Kebab = $nuevoID;
            $resultadoIngredientes = self::insertKebabHasIngredientes($kebab);

            if ($resultadoIngredientes === null) {
                throw new Exception("Error al asociar ingredientes al kebab.");
            }

            $con->commit();
            return $nuevoID;

        } catch (Exception $e) {
            if ($con->inTransaction()) {
                $con->rollBack();
            }

            echo json_encode(["error" => "Error al crear el kebab: " . $e->getMessage()]);
            return null;
        }
    }

    public static function insertKebabHasIngredientes($kebab){
        $con = Database::getConection();

        try {
            $sql = "INSERT INTO kebabingredientes(Kebab_idKebab, Ingredientes_idIngredientes) 
                    VALUES (:idKebab, :idIngredientes)";

            $stmt = $con->prepare($sql);
            
            foreach ($kebab->ingredientes as $ingrediente_id) {
                $stmt->bindValue(':idKebab', $kebab->ID_Kebab, PDO::PARAM_INT); // Asume que es un número
                $stmt->bindValue(':idIngredientes', $ingrediente_id, PDO::PARAM_INT); // Asume que es un número
                $stmt->execute();
            }

            return $kebab->ingredientes;
        } catch (Exception $e) {
            if ($con->inTransaction()) {
                $con->rollBack();
            }
             // Lanzar excepción o registrar error
            throw new Exception("Error al asociar ingredientes al kebab: " . $e->getMessage());
        }
    } 

    // FIND BY ID
    public function findById($id) {
        $stm = $this->con->prepare("SELECT * 
                                    FROM Kebab 
                                    WHERE idKebab = :id");
                                    
        $stm->execute(['id' => $id]);
        
        $kebab = null;
        $registro = $stm->fetch();

        if ($registro) {
            $kebab = new Kebab(
                $registro['idKebab'],
                $registro['nombre'],
                $registro['foto'],
                $registro['precio']
            );
        }
        return $kebab;
    }

    // FIND ALL
    public function findAll(): array {
        $stm = $this->con->prepare("SELECT * FROM Kebab");
        $stm->execute();

        $kebabs = [];
        while ($registro = $stm->fetch()) {
            $kebab = new Kebab(
                $registro['idKebab'],
                $registro['nombre'],
                $registro['foto'],
                $registro['precio']
            );
            $kebabs[] = $kebab;
        }
        return $kebabs;
    }

    // UPDATE
    public function update($kebab) {
        $stm = $this->con->prepare("UPDATE Kebab SET nombre = :nombre, foto = :foto, precio = :precio WHERE idKebab = :idKebab");

        $stm->execute([
            'idKebab' => $kebab->getIDKebab(),
            'nombre' => $kebab->getNombre(),
            'foto' => $kebab->getFoto(),
            'precio' => $kebab->getPrecio()
        ]);

        return $stm->rowCount() > 0;
    }

    // DELETE
    public function delete($id): bool {
        try {
            // Eliminar los ingredientes asociados antes de eliminar el kebab
            $this->eliminarIngredientes($id);

            // Eliminar el kebab
            $stm = $this->con->prepare("DELETE FROM Kebab WHERE idKebab = :id");
            $stm->execute(['id' => $id]);

            return $stm->rowCount() > 0;
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al eliminar el kebab: " . $e->getMessage()]);
            return false;
        }
    }

    // Método para eliminar los ingredientes asociados a un kebab
    private function eliminarIngredientes($kebabId) {
        try {
            $sql = "DELETE FROM kebabingredientes WHERE Kebab_idKebab = :Kebab_idKebab";
            $stm = $this->con->prepare($sql);
            $stm->execute(['Kebab_idKebab' => $kebabId]);
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al eliminar los ingredientes asociados: " . $e->getMessage()]);
        }
    }
}
?>
