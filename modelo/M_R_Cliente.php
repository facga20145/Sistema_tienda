<?php
require_once 'm_conexion.php'; 

class PersonaModel {
    private $conn;

    public function __construct() {
        $this->conn = $GLOBALS['conn'];
    }

    // Método para insertar un nuevo cliente en la base de datos
    public function insertarCliente($dni, $nombreUsuario, $contrasena, $nombre, $apellido, $telefono, $correo, $direccion, $genero, $fechaNacimiento) {
        // Hashear la contraseña
        $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

        // Fecha de registro actual
        $fechaRegistro = date('Y-m-d');

        // Puntos de fidelidad iniciales
        $puntosFidelidad = 0; 

        // Preparar la consulta para insertar en la tabla cliente
        $stmtCliente = $this->conn->prepare("INSERT INTO cliente (dni, nombreUsuario, contrasena, puntosFidelidad, fechaRegistro, nombre, apellido, telefono, correo, direccion, genero, fechaNacimiento) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmtCliente->bind_param("sssissssssss", $dni, $nombreUsuario, $contrasenaHash, $puntosFidelidad, $fechaRegistro, $nombre, $apellido, $telefono, $correo, $direccion, $genero, $fechaNacimiento);
        
        if (!$stmtCliente->execute()) {
            throw new Exception("Error al insertar cliente: " . $stmtCliente->error);
        }

        return true;
    }
}
?>
