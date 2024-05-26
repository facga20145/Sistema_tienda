<?php
require_once 'm_conexion.php'; 

class EmpresaModel {
    private $conn;

    public function __construct() {
        $this->conn = $GLOBALS['conn'];
    }

    // Método para insertar un nuevo usuario y cliente en la base de datos
    public function insertarEmpresa($nombreEmpresa, $direccion, $telefono, $email,$contrasena) {
        // Primer paso: insertar el usuario
        $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);
        $fecha_creacion = date('Y-m-d');

        $stmtEmpresa = $this->conn->prepare("INSERT INTO empresa(nombreEmpresa,direccion,telefono,email,fecha_creacion,contrasena) VALUES (?, ?,?,?,?,?)");

        $stmtEmpresa->bind_param("ssssss", $nombreEmpresa, $direccion, $telefono, $email, $fecha_creacion, $contrasenaHash);
        
        if (!$stmtEmpresa->execute()) {
            throw new Exception("Error al insertar usuario: " . $stmtEmpresa->error);
        }
        return true;

    }
}
?>
