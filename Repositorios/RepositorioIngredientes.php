<?php
require_once '../helper/gbd.php';  // Cambia la ruta si es necesario
require_once '../Clases/Ingredientes.php';

class RepositorioIngredientes {

    private $conn;

    // CREAR CONEXION
    public function __construct() {
        $database = new Database(); // Usando la clase Database de gbd.php
        $this->conn = $database->getConnection();
    }

    // CREATE
    public function create($ingrediente) {
        $query = "INSERT INTO Ingredientes (idIngredientes, nombre, alergenos) VALUES (:idIngredientes, :nombre, :alergenos)";

        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":idIngredientes", $ingrediente->getIDIngredientes());
        $stmt->bindParam(":nombre", $ingrediente->getNombre());
        $alergenos = implode(',', $ingrediente->getAlergenos());
        $stmt->bindParam(":alergenos", $alergenos);
        
        return $stmt->execute();
    }

    // FIND BY ID
    public function findById($id) {
        $query = "SELECT * FROM Ingredientes WHERE idIngredientes = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $alergenos = explode(',', $row['alergenos']);
            return new Ingredientes($row['idIngredientes'], $row['nombre'], $alergenos);
        }
        
        return null;
    }

    // FIND ALL
    public function findAll() {
        $query = "SELECT * FROM Ingredientes";

        $stmt = $this->conn->prepare($query);
        
        $stmt->execute();
        
        $ingredientes = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $alergenos = explode(',', $row['alergenos']);
            $ingredientes[] = new Ingredientes($row['idIngredientes'], $row['nombre'], $alergenos);
        }
        
        return $ingredientes;
    }

    // UPDATE
    public function update($ingrediente) {
        $query = "UPDATE Ingredientes SET nombre = :nombre, alergenos = :alergenos WHERE idIngredientes = :idIngredientes";

        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":idIngredientes", $ingrediente->getIDIngredientes());
        $stmt->bindParam(":nombre", $ingrediente->getNombre());
        $alergenos = implode(',', $ingrediente->getAlergenos());
        $stmt->bindParam(":alergenos", $alergenos);
        
        return $stmt->execute();
    }

    // DELETE
    public function delete($id) {
        $query = "DELETE FROM Ingredientes WHERE idIngredientes = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":id", $id);
        
        return $stmt->execute();
    }
}
?>
