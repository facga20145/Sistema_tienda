<?php
require_once 'm_conexion.php'; 

class PersonaModel {
    private $conn;

    public function __construct() {
        $this->conn = $GLOBALS['conn'];
    }

<<<<<<< HEAD
    // Método para insertar un nuevo cliente en la base de datos
=======
    // Método para insertar un nuevo cliente en la base de datos y crear un carrito para el cliente
>>>>>>> aeaa91bd3b9e65cabd155ca7591047b0da16df8c
    public function insertarCliente($dni, $nombreUsuario, $contrasena, $nombre, $apellido, $telefono, $correo, $direccion, $genero, $fechaNacimiento) {
        // Hashear la contraseña
        $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

        // Fecha de registro actual
        $fechaRegistro = date('Y-m-d');

        // Puntos de fidelidad iniciales
        $puntosFidelidad = 0; 

<<<<<<< HEAD
        // Preparar la consulta para insertar en la tabla cliente
        $stmtCliente = $this->conn->prepare("INSERT INTO cliente (dni, nombreUsuario, contrasena, puntosFidelidad, fechaRegistro, nombre, apellido, telefono, correo, direccion, genero, fechaNacimiento) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmtCliente->bind_param("sssissssssss", $dni, $nombreUsuario, $contrasenaHash, $puntosFidelidad, $fechaRegistro, $nombre, $apellido, $telefono, $correo, $direccion, $genero, $fechaNacimiento);
        
        if (!$stmtCliente->execute()) {
            throw new Exception("Error al insertar cliente: " . $stmtCliente->error);
=======
        // Iniciar la transacción
        $this->conn->begin_transaction();

        try {
            // Insertar el cliente en la base de datos
            $stmtCliente = $this->conn->prepare("INSERT INTO cliente (dni, nombreUsuario, contrasena, puntosFidelidad, fechaRegistro, nombre, apellido, telefono, correo, direccion, genero, fechaNacimiento) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmtCliente->bind_param("sssissssssss", $dni, $nombreUsuario, $contrasenaHash, $puntosFidelidad, $fechaRegistro, $nombre, $apellido, $telefono, $correo, $direccion, $genero, $fechaNacimiento);
            
            if (!$stmtCliente->execute()) {
                throw new Exception("Error al insertar cliente: " . $stmtCliente->error);
            }

            // Obtener el ID del cliente recién insertado
            $clienteID = $this->conn->insert_id;

            // Crear un carrito para el nuevo cliente
            $stmtCarrito = $this->conn->prepare("INSERT INTO carrito (clienteID, fechaCreacion, Estado) VALUES (?, NOW(), 1)");
            $stmtCarrito->bind_param("i", $clienteID);
            
            if (!$stmtCarrito->execute()) {
                throw new Exception("Error al crear carrito para el cliente: " . $stmtCarrito->error);
            }

            // Confirmar la transacción
            $this->conn->commit();

            return true;
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $this->conn->rollback();
            throw $e;
>>>>>>> aeaa91bd3b9e65cabd155ca7591047b0da16df8c
        }
    }
}
?>
