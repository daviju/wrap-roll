<?php

class RepositorioUsuario {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    // Método para obtener un usuario por ID
    public function findById($id) {
        try {
            $sql = "SELECT * FROM Usuario WHERE idUsuario = :id";
            $stm = $this->con->prepare($sql);
            $stm->execute(['id' => $id]);
            $registro = $stm->fetch(PDO::FETCH_ASSOC);

            if ($registro) {
                return new Usuario(
                    $registro['idUsuario'],
                    $registro['nombre'],
                    $registro['foto'],
                    $registro['contraseña'],
                    $registro['monedero'],
                    $registro['telefono'],
                    json_decode($registro['carrito'], true),
                    $registro['rol'],
                    $registro['email']
                );
            } else {
                echo json_encode(["error" => "Usuario no encontrado."]);
                return null;
            }
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al obtener el usuario: " . $e->getMessage()]);
            return null;
        }
    }

    // Método para verificar un usuario por email y contraseña
    public function verifyUser($email, $password) {
        try {
            $usuario = $this->findUserByEmail($email);
            if ($usuario && password_verify($password, $usuario['contraseña'])) {
                return new Usuario(
                    $usuario['idUsuario'],
                    $usuario['nombre'],
                    $usuario['foto'],
                    $usuario['contraseña'],
                    $usuario['monedero'],
                    $usuario['telefono'],
                    json_decode($usuario['carrito'], true),
                    $usuario['rol'],
                    $usuario['email']
                );
            }
            return null;
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al verificar el usuario: " . $e->getMessage()]);
            return null;
        }
    }

    // Método para obtener un usuario por email
    public function findUserByEmail($email) {
        try {
            $sql = "SELECT * FROM Usuario WHERE email = :email";
            $stm = $this->con->prepare($sql);
            $stm->execute(['email' => $email]);
            return $stm->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al obtener el usuario: " . $e->getMessage()]);
            return null;
        }
    }

    // Método para crear un nuevo usuario
    public function create(Usuario $usuario) {
        try {
            $carrito = json_encode($usuario->getCarrito());
            $sql = "INSERT INTO Usuario (nombre, foto, contraseña, monedero, telefono, email, carrito, rol)
                    VALUES (:nombre, :foto, :contraseña, :monedero, :telefono, :email, :carrito, :rol)";
            $stm = $this->con->prepare($sql);
    
            $stm->bindValue(':nombre', $usuario->getNombre());
            $stm->bindValue(':foto', $usuario->getFoto());
            $stm->bindValue(':contraseña', $usuario->getContraseña());
            $stm->bindValue(':monedero', $usuario->getMonedero());
            $stm->bindValue(':telefono', $usuario->getTelefono());
            $stm->bindValue(':email', $usuario->getEmail());
            $stm->bindValue(':carrito', $carrito);
            $stm->bindValue(':rol', $usuario->getRol());
    
            /*
            // Imprimir valores para depuración
            print_r([
                ':nombre' => $usuario->getNombre(),
                ':foto' => $usuario->getFoto(),
                ':contraseña' => $usuario->getContraseña(),
                ':monedero' => $usuario->getMonedero(),
                ':telefono' => $usuario->getTelefono(),
                ':email' => $usuario->getEmail(),
                ':carrito' => $carrito,
                ':rol' => $usuario->getRol()
            ]);
            exit; // Detener la ejecución después de imprimir los valores para depuración
            */

            return $stm->execute();
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al crear el usuario: " . $e->getMessage()]);
            return false;
        }
    }
    
    
    // Método para actualizar un usuario
    public function update(Usuario $usuario) {
        try {
            $carrito = json_encode($usuario->getCarrito());
            $sql = "UPDATE Usuario SET nombre = :nombre, foto = :foto, contraseña = :contraseña,
                    monedero = :monedero, telefono = :telefono, email = :email, carrito = :carrito, rol = :rol
                    WHERE idUsuario = :idUsuario";
            $stm = $this->con->prepare($sql);

            $stm->bindValue(':idUsuario', $usuario->getIDUsuario());
            $stm->bindValue(':nombre', $usuario->getNombre());
            $stm->bindValue(':foto', $usuario->getFoto());
            $stm->bindValue(':contraseña', $usuario->getContraseña());
            $stm->bindValue(':monedero', $usuario->getMonedero());
            $stm->bindValue(':email', $usuario->getEmail());
            $stm->bindValue(':carrito', json_encode($usuario->getCarrito() ?? []));
            $stm->bindValue(':rol', $usuario->getRol());

            return $stm->execute();
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al actualizar el usuario: " . $e->getMessage()]);
            return false;
        }
    }

    // Método para eliminar un usuario
    public function delete($id) {
        try {
            $sql = "DELETE FROM Usuario WHERE idUsuario = :id";
            $stm = $this->con->prepare($sql);
            $stm->execute(['id' => $id]);
            return $stm->rowCount() > 0;
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al eliminar el usuario: " . $e->getMessage()]);
            return false;
        }
    }

    // Método para obtener todos los usuarios
    public function findAll() {
        try {
            $sql = "SELECT * FROM Usuario";
            $stm = $this->con->prepare($sql);
            $stm->execute();
            $usuarios = [];

            while ($registro = $stm->fetch(PDO::FETCH_ASSOC)) {
                $usuarios[] = new Usuario(
                    $registro['idUsuario'],
                    $registro['nombre'],
                    $registro['foto'],
                    $registro['contraseña'],
                    $registro['monedero'],
                    $registro['telefono'],
                    json_decode($registro['carrito'], true),
                    $registro['rol'],
                    $registro['email']
                );
            }

            return $usuarios;
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al obtener los usuarios: " . $e->getMessage()]);
            return [];
        }
    }
}

?>
