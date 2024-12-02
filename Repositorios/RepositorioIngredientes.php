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

    public function create($ingrediente) {
        $con = Database::getConection();
    
        try {
            $con->beginTransaction();
    
            // Insertar ingrediente
            $sql = "INSERT INTO ingredientes(nombre, precio, tipo, foto) 
                    VALUES (:nombre, :precio, :tipo, :foto)";
            $stmt = $con->prepare($sql);
    
            $stmt->bindValue(':nombre', $ingrediente->nombre);
            $stmt->bindValue(':precio', $ingrediente->precio);
            $stmt->bindValue(':tipo', $ingrediente->tipo);
            $stmt->bindValue(':foto', $ingrediente->foto);
    
            if (!$stmt->execute()) {
                throw new Exception("Error al insertar el ingrediente.");
            }
    
            $nuevoID = $con->lastInsertId();
    
            // Asociar alérgenos al nuevo ingrediente
            $ingrediente->ID_Ingredientes = $nuevoID;
            $resultadoAlergenos = self::insertIngredienteHasAlergenos($ingrediente);
    
            if ($resultadoAlergenos === null) {
                throw new Exception("Error al asociar alérgenos al ingrediente.");
            }
    
            $con->commit();
            return $nuevoID;
    
        } catch (Exception $e) {
            // Manejar errores y asegurarse de revertir la transacción
            if ($con->inTransaction()) {
                $con->rollBack();
            }
            echo json_encode(["error" => "Error al crear el ingrediente: " . $e->getMessage()]);
            return null;
        }
    }

    public static function insertIngredienteHasAlergenos($ingrediente) {
        $con = Database::getConection();
        try {
            $sql = 'INSERT INTO ingredientes_alergenos(Ingredientes_idIngredientes, Alergenos_idAlergenos) 
                    VALUES (:ingrediente_id, :alergeno_id)';
            $stmt = $con->prepare($sql);
    
            foreach ($ingrediente->alergenos as $alergeno_id) {
                $stmt->bindValue(':ingrediente_id', $ingrediente->ID_Ingredientes, PDO::PARAM_INT);
                $stmt->bindValue(':alergeno_id', $alergeno_id, PDO::PARAM_INT); // Asume que es un número
                $stmt->execute();
            }                    
    
            return $ingrediente->alergenos;
        } catch (Exception $e) {
            if ($con->inTransaction()) {
                $con->rollBack();
            }
            echo json_encode(["error" => "Error al asociar alérgenos: " . $e->getMessage()]);
            return null;
        }
    }
    

    // Método para actualizar un ingrediente y sus alérgenos
    public function update(Ingredientes $ingrediente) {
        try {
            $this->con->beginTransaction();

            // Actualizar el ingrediente
            $sql = "UPDATE Ingredientes 
                    SET nombre = :nombre, precio = :precio, tipo = :tipo, foto = :foto 
                    WHERE idIngredientes = :id";
            $stm = $this->con->prepare($sql);

            $stm->bindValue(':id', $ingrediente->getIDIngredientes());
            $stm->bindValue(':nombre', $ingrediente->getNombre());
            $stm->bindValue(':precio', $ingrediente->getPrecio());
            $stm->bindValue(':tipo', $ingrediente->getTipo());
            $stm->bindValue(':foto', $ingrediente->getFoto());

            if (!$stm->execute()) {
                $this->con->rollBack();
                return false;
            }

            // Eliminar alérgenos actuales del ingrediente
            $this->eliminarAlergenos($ingrediente->getIDIngredientes());

            // Reasignar los alérgenos utilizando insertIngredienteHasAlergenos
            $resultadoAlergenos = self::insertIngredienteHasAlergenos((object)[
                'id' => $ingrediente->getIDIngredientes(),
                'alergenos' => array_map(function ($idAlergeno) {
                    return (object)['id' => $idAlergeno];
                }, $ingrediente->getAlergenos())
            ]);

            if ($resultadoAlergenos === null) {
                $this->con->rollBack();
                return false;
            }

            $this->con->commit();
            return true;

        } catch (PDOException $e) {
            $this->con->rollBack();
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
