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
                // Obtener los alérgenos asociados a este ingrediente
                $sqlAlergenos = "SELECT a.idAlergenos, a.tipo, a.foto
                                 FROM Alergenos a
                                 JOIN Ingredientes_Alergenos ia ON a.idAlergenos = ia.Alergenos_idAlergenos
                                 WHERE ia.Ingredientes_idIngredientes = :id";
                                 
                $stmAlergenos = $this->con->prepare($sqlAlergenos);
                $stmAlergenos->execute(['id' => $id]);
                $alergenos = $stmAlergenos->fetchAll(PDO::FETCH_ASSOC);

                return new Ingredientes(
                    $registro['idIngredientes'],
                    $registro['nombre'],
                    $registro['precio'],
                    $registro['tipo'],
                    $registro['foto'],
                    $alergenos // Devuelve los alérgenos asociados
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

    // Método para crear un nuevo ingrediente con sus alérgenos
    public function create(Ingredientes $ingrediente) {
        try {
            $sql = "INSERT INTO Ingredientes (nombre, precio, tipo, foto)
                    VALUES (:nombre, :precio, :tipo, :foto)";
            $stm = $this->con->prepare($sql);

            $stm->bindValue(':nombre', $ingrediente->getNombre());
            $stm->bindValue(':precio', $ingrediente->getPrecio());
            $stm->bindValue(':tipo', $ingrediente->getTipo());
            $stm->bindValue(':foto', $ingrediente->getFoto());

            if ($stm->execute()) {
                $ingredienteId = $this->con->lastInsertId();

                // Insertar los alérgenos asociados
                foreach ($ingrediente->getAlergenos() as $idAlergeno) {
                    $this->asignarAlergeno($ingredienteId, $idAlergeno);
                }

                return $ingredienteId;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al crear el ingrediente: " . $e->getMessage()]);
            return false;
        }
    }

    // Método para asignar un alérgeno a un ingrediente
public function asignarAlergeno($ingredienteId, $alergenoId) {
    try {
        // Verificar si el alérgeno existe en la base de datos
        $sqlCheck = "SELECT COUNT(*) FROM Alergenos WHERE idAlergenos = :alergenoId";
        $stmCheck = $this->con->prepare($sqlCheck);
        $stmCheck->bindValue(':alergenoId', $alergenoId);
        $stmCheck->execute();
        $count = $stmCheck->fetchColumn();

        if ($count == 0) {
            echo json_encode(["error" => "El alérgeno con ID $alergenoId no existe."]);
            return false;
        }

        // Si el alérgeno existe, insertar la relación
        $sql = "INSERT INTO Ingredientes_Alergenos (Ingredientes_idIngredientes, Alergenos_idAlergenos)
                VALUES (:ingrediente_id, :alergeno_id)";
        $stm = $this->con->prepare($sql);
        $stm->bindValue(':ingrediente_id', $ingredienteId);
        $stm->bindValue(':alergeno_id', $alergenoId);
        $stm->execute();

        return true;
    } catch (PDOException $e) {
        echo json_encode(["error" => "Error al asignar alérgeno: " . $e->getMessage()]);
        return false;
    }
}


    // Método para actualizar un ingrediente y sus alérgenos
    public function update(Ingredientes $ingrediente) {
        try {
            $sql = "UPDATE Ingredientes SET nombre = :nombre, precio = :precio, tipo = :tipo, foto = :foto
                    WHERE idIngredientes = :id";
            $stm = $this->con->prepare($sql);

            $stm->bindValue(':id', $ingrediente->getIDIngredientes());
            $stm->bindValue(':nombre', $ingrediente->getNombre());
            $stm->bindValue(':precio', $ingrediente->getPrecio());
            $stm->bindValue(':tipo', $ingrediente->getTipo());
            $stm->bindValue(':foto', $ingrediente->getFoto());

            if ($stm->execute()) {
                // Actualizar los alérgenos del ingrediente
                $this->eliminarAlergenos($ingrediente->getIDIngredientes());
                foreach ($ingrediente->getAlergenos() as $idAlergeno) {
                    $this->asignarAlergeno($ingrediente->getIDIngredientes(), $idAlergeno);
                }

                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al actualizar el ingrediente: " . $e->getMessage()]);
            return false;
        }
    }

    // Método para eliminar un ingrediente y sus alérgenos
    public function delete($id) {
        try {
            // Eliminar los alérgenos antes de eliminar el ingrediente
            $this->eliminarAlergenos($id);

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
                // Obtener los alérgenos asociados a cada ingrediente
                $sqlAlergenos = "SELECT a.idAlergenos, a.tipo, a.foto
                                 FROM Alergenos a
                                 JOIN Ingredientes_Alergenos ia ON a.idAlergenos = ia.Alergenos_idAlergenos
                                 WHERE ia.Ingredientes_idIngredientes = :id";
                $stmAlergenos = $this->con->prepare($sqlAlergenos);
                $stmAlergenos->execute(['id' => $registro['idIngredientes']]);
                $alergenos = $stmAlergenos->fetchAll(PDO::FETCH_ASSOC);

                $ingredientes[] = new Ingredientes(
                    $registro['idIngredientes'],
                    $registro['nombre'],
                    $registro['precio'],
                    $registro['tipo'],
                    $registro['foto'],
                    $alergenos
                );
            }

            return $ingredientes;
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al obtener los ingredientes: " . $e->getMessage()]);
            return [];
        }
    }


    public function eliminarAlergenos($ingredienteId)
    {
        try {
            $sql = "DELETE FROM Ingredientes_Alergenos 
                    WHERE Ingredientes_idIngredientes = :idIngredientes";
            
            $stm = $this->con->prepare($sql);
            $stm->execute(['ingrediente_id' => $ingredienteId]);

        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al eliminar alérgenos asociados: " . $e->getMessage()]);
        }
    }

    // Método para eliminar un ingrediente
    public function eliminar($id)
    {
        try {
            $this->eliminarAlergenos($id);
            $sql = "DELETE FROM Ingredientes 
                    WHERE idIngredientes = :id";

            $stm = $this->con->prepare($sql);
            return $stm->execute(['id' => $id]);
            
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al eliminar el ingrediente: " . $e->getMessage()]);
            return false;
        }
    }
}

?>
