<?php
require_once 'Database.php';
require_once '../Clases/kebab.php';

class KebabRepository {

    private $conn;

    // CREAR CONEXION
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // CREATE
    public function create($kebab) {
        $query = "INSERT INTO Kebab (idKebab, nombre, foto, precio) VALUES (:idKebab, :nombre, :foto, :precio)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":idKebab", $kebab->getIDKebab());
        $stmt->bindParam(":nombre", $kebab->getNombre());
        $stmt->bindParam(":foto", $kebab->getFoto());
        $stmt->bindParam(":precio", $kebab->getPrecio());
        
        return $stmt->execute();
    }

    // FIND BY ID
    public function findById($id) {
        $query = "SELECT * FROM Kebab WHERE idKebab = :id";

        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(":id", $id);
        
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            return new Kebab($row['idKebab'], $row['nombre'], $row['foto'], $row['precio']);
        }
    
        return null;
    }

    // FIND ALL
    public function findAll() {
        $query = "SELECT * FROM Kebab";
    
        $stmt = $this->conn->prepare($query);
    
        $stmt->execute();
    
        $kebabs = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $kebabs[] = new Kebab($row['idKebab'], $row['nombre'], $row['foto'], $row['precio']);
        }
        
        return $kebabs;
    }

    // UPDATE
    public function update($kebab) {
        $query = "UPDATE Kebab SET nombre = :nombre, foto = :foto, precio = :precio WHERE idKebab = :idKebab";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":idKebab", $kebab->getIDKebab());
        $stmt->bindParam(":nombre", $kebab->getNombre());
        $stmt->bindParam(":foto", $kebab->getFoto());
        $stmt->bindParam(":precio", $kebab->getPrecio());
        
        return $stmt->execute();
    }

    // DELETE
    public function delete($id) {
        $query = "DELETE FROM Kebab WHERE idKebab = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":id", $id);
        
        return $stmt->execute();
    }
}
?>
