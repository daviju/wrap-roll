<?php

class RepositorioKebabIngredientes {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    // Método para crear una relación entre Kebab e Ingrediente
    public static function create(KebabIngredientes $kebabIngredientes) {
        $con = Database::getConection();
        try {
            $sql = "INSERT INTO KebabIngredientes (Kebab_idKebab, Ingredientes_idIngredientes) 
                    VALUES (:idKebab, :idIngrediente)";
            $stm = $con->prepare($sql);

            $stm->bindValue(':idKebab', $kebabIngredientes->getIDKebab());
            $stm->bindValue(':idIngrediente', $kebabIngredientes->getIDIngrediente());

            return $stm->execute();
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al crear la relación: " . $e->getMessage()]);
            return false;
        }
    }

    // Método para obtener una relación por los IDs de Kebab e Ingrediente
    public static function findByIds($idKebab, $idIngrediente) {
        $con = Database::getConection();
        try {
            $sql = "SELECT * FROM KebabIngredientes 
                    WHERE Kebab_idKebab = :idKebab AND Ingredientes_idIngredientes = :idIngrediente";
            $stm = $con->prepare($sql);
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


    public static function findByIdKebab($idKebab) {
        $con = Database::getConection();
        try {
            // SQL para obtener todas las relaciones con un ID de Kebab específico
            $sql = "SELECT * FROM KebabIngredientes 
                    WHERE Kebab_idKebab = :idKebab";
            $stm = $con->prepare($sql);
            $stm->execute(['idKebab' => $idKebab]);
            $registros = $stm->fetchAll(PDO::FETCH_ASSOC);
    
            // Verificamos si se encontraron registros
            if ($registros) {
                // Creamos un array con los objetos KebabIngredientes
                $kebabIngredientes = [];
                foreach ($registros as $registro) {
                    $kebabIngredientes[] = new KebabIngredientes(
                        $registro['Kebab_idKebab'],
                        $registro['Ingredientes_idIngredientes']
                    );
                }
                return $kebabIngredientes;
            } else {
                echo json_encode(["error" => "No se encontraron relaciones para el kebab con ID $idKebab."]);
                return null;
            }
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al obtener las relaciones: " . $e->getMessage()]);
            return null;
        }
    }
    

    // Método para obtener todas las relaciones
    public static function findAll() {
        $con = Database::getConection();
        try {
            $sql = "SELECT * FROM KebabIngredientes";
            $stm = $con->prepare($sql);
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
    public static function update(KebabIngredientes $kebabIngredientes) {
        $con = Database::getConection();
        try {
            $sql = "UPDATE KebabIngredientes 
                    SET Ingredientes_idIngredientes = :idIngrediente 
                    WHERE Kebab_idKebab = :idKebab";
            $stm = $con->prepare($sql);

            $stm->bindValue(':idKebab', $kebabIngredientes->getIDKebab());
            $stm->bindValue(':idIngrediente', $kebabIngredientes->getIDIngrediente());

            return $stm->execute();
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al actualizar la relación: " . $e->getMessage()]);
            return false;
        }
    }

    // Método para eliminar una relación
    public static function delete($idKebab, $idIngrediente) {
        $con = Database::getConection();
        try {
            $sql = "DELETE FROM KebabIngredientes 
                    WHERE Kebab_idKebab = :idKebab AND Ingredientes_idIngredientes = :idIngrediente";
            $stm = $con->prepare($sql);
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
