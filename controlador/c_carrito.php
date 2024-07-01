<?php
session_start();
require_once '../modelo/m_conexion.php';

if (!isset($_SESSION['clienteID'])) {
    echo json_encode(['error' => 'Cliente no autenticado']);
    exit();
}

$clienteID = $_SESSION['clienteID'];
$accion = $_POST['accion'];

$conn = $GLOBALS['conn'];

switch ($accion) {
    case 'agregar':
        $productoID = $_POST['productoID'];
        $cantidad = $_POST['cantidad'];
        $monto = $_POST['monto'];

        // Verificar si el cliente ya tiene un carrito activo
        $query = "SELECT carritoID FROM carrito WHERE clienteID = ? AND estado = 'activo'";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $clienteID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Si tiene un carrito activo, obtener el carritoID
            $row = $result->fetch_assoc();
            $carritoID = $row['carritoID'];
        } else {
            // Si no tiene un carrito activo, crear uno nuevo
            $query = "INSERT INTO carrito (clienteID, fechaCreacion, estado) VALUES (?, NOW(), 'activo')";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('i', $clienteID);
            if (!$stmt->execute()) {
                echo json_encode(['error' => 'Error al crear el carrito']);
                exit();
            }
            $carritoID = $conn->insert_id;
        }

        // Agregar el producto al detalle del carrito
        $query = "INSERT INTO detallecarrito (carritoID, productoID, cantidad, monto) VALUES (?, ?, ?, ?)
                  ON DUPLICATE KEY UPDATE cantidad = cantidad + VALUES(cantidad), monto = monto + VALUES(monto)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('iiid', $carritoID, $productoID, $cantidad, $monto);

        if ($stmt->execute()) {
            echo json_encode(['success' => 'Producto agregado al carrito']);
        } else {
            echo json_encode(['error' => 'Error al agregar el producto al carrito']);
        }
        break;

    // Aquí puedes agregar más casos para otras acciones, como eliminar, mostrar, vaciar, etc.

    default:
        echo json_encode(['error' => 'Acción no válida']);
        break;
}

$conn->close();
?>
