<?php

class RepositorioIngredientes {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    // Método para obtener un alérgeno por ID
    public function findById($id) {
        try {
            $sql = "SELECT * FROM Alergenos WHERE idAlergenos = :id";
            $stm = $this->con->prepare($sql);
            $stm->execute(['id' => $id]);
            $registro = $stm->fetch(PDO::FETCH_ASSOC);

            if ($registro) {
                return new Alergenos(
                    $registro['idAlergenos'],
                    $registro['tipo'],
                    $registro['foto']
                );
            } else {
                echo json_encode(["error" => "Alergeno no encontrado."]);
                return null;
            }
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al obtener el alérgeno: " . $e->getMessage()]);
            return null;
        }
    }

    // Método para crear un nuevo alérgeno
    public function create(Alergenos $alergeno) {
        try {
            $sql = "INSERT INTO Alergenos (idAlergenos, tipo, foto)
                    VALUES (:idAlergenos, :tipo, :foto)";
            $stm = $this->con->prepare($sql);

            $stm->bindValue(':idAlergenos', $alergeno->getIDAlergenos());
            $stm->bindValue(':tipo', $alergeno->getTipo());
            $stm->bindValue(':foto', $alergeno->getFoto());

            return $stm->execute();
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al crear el alérgeno: " . $e->getMessage()]);
            return false;
        }
    }

    // Método para actualizar un alérgeno
    public function update(Alergenos $alergeno) {
        try {
            $sql = "UPDATE Alergenos SET tipo = :tipo, foto = :foto
                    WHERE idAlergenos = :idAlergenos";
            $stm = $this->con->prepare($sql);

            $stm->bindValue(':idAlergenos', $alergeno->getIDAlergenos());
            $stm->bindValue(':tipo', $alergeno->getTipo());
            $stm->bindValue(':foto', $alergeno->getFoto());

            return $stm->execute();
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al actualizar el alérgeno: " . $e->getMessage()]);
            return false;
        }
    }

    // Método para eliminar un alérgeno
    public function delete($id) {
        try {
            $sql = "DELETE 
                    FROM Alergenos 
                    WHERE idAlergenos = :id";
                    
            $stm = $this->con->prepare($sql);
            $stm->execute(['id' => $id]);
            return $stm->rowCount() > 0;
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al eliminar el alérgeno: " . $e->getMessage()]);
            return false;
        }
    }

    // Método para obtener todos los alérgenos
    public function findAll() {
        try {
            $sql = "SELECT * FROM Alergenos";
            $stm = $this->con->prepare($sql);
            $stm->execute();
            $alergenos = [];

            while ($registro = $stm->fetch(PDO::FETCH_ASSOC)) {
                $alergenos[] = new Alergenos(
                    $registro['idAlergenos'],
                    $registro['tipo'],
                    $registro['foto']
                );
            }

            return $alergenos;
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al obtener los alérgenos: " . $e->getMessage()]);
            return [];
        }
    }
}

?>
