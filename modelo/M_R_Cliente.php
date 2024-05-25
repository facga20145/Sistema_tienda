<?php
require_once 'm_conexion.php'; 

class PersonaModel {
    private $conn;

    public function __construct() {
        $this->conn = $GLOBALS['conn'];
    }

    // Método para insertar un nuevo usuario y cliente en la base de datos
    public function insertarCliente($dni, $nombreUsuario, $contrasena, $nombre, $apellido, $telefono, $correo, $direccion, $genero, $fechaNacimiento) {
        // Primer paso: insertar el usuario
        $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);
        $stmtUsuario = $this->conn->prepare("INSERT INTO usuario (nombreUsuario, contrasena) VALUES (?, ?)");
        $stmtUsuario->bind_param("ss", $nombreUsuario, $contrasenaHash);
        
        if (!$stmtUsuario->execute()) {
            throw new Exception("Error al insertar usuario: " . $stmtUsuario->error);
        }

        $usuario_id = $this->conn->insert_id; // ID del usuario recién insertado

        // Segundo paso: insertar el cliente
        $fechaRegistro = date('Y-m-d');
        $puntosFidelidad = 0; // Puntos de fidelidad iniciales

        $stmtCliente = $this->conn->prepare("INSERT INTO cliente (usuarioID, dni, nombreUsuario, contrasena, puntosFidelidad, fechaRegistro, nombre, apellido, telefono, correo, direccion, genero, fechaNacimiento) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmtCliente->bind_param("isssissssssss", $usuario_id, $dni, $nombreUsuario, $contrasenaHash, $puntosFidelidad, $fechaRegistro, $nombre, $apellido, $telefono, $correo, $direccion, $genero, $fechaNacimiento);
        
        if (!$stmtCliente->execute()) {
            throw new Exception("Error al insertar cliente: " . $stmtCliente->error);
        }

        return true;
    }
}
?>
