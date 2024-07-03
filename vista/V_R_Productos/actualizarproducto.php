<?php
require '../../modelo/m_conexion.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Depuración: Array para almacenar mensajes de depuración
$debug_messages = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['productId'];
    $productName = $_POST['editProductName'];
    $productPrice = (float)$_POST['editProductPrice'];
    $productDescription = $_POST['editProductDescription'];
    $productCategory = $_POST['editProductCategory'];
    $image = '';

    // Depuración: Mostrar valores recibidos
    $debug_messages[] = "Valores recibidos: productId=$productId, productName=$productName, productPrice=$productPrice, productDescription=$productDescription, productCategory=$productCategory";

    // Procesar la imagen siempre que se proporcione
    if (isset($_FILES['editProductImage']) && $_FILES['editProductImage']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['editProductImage'];
        $nombre = $file['name'];
        $tipo = $file['type'];
        $ruta_provisional = $file['tmp_name'];
        $size = $file['size'];
        $dimensiones = getimagesize($ruta_provisional);
        $width = $dimensiones[0];
        $height = $dimensiones[1];
        $carpeta = "fotos/";

        if ($tipo != 'image/jpg' && $tipo != 'image/jpeg' && $tipo != 'image/png' && $tipo != 'image/gif') {
            $debug_messages[] = "Error, el archivo no es una imagen";
            echo json_encode(['success' => false, 'error' => 'Error, el archivo no es una imagen', 'debug' => $debug_messages]);
            exit;
        } else if ($size > 3 * 1024 * 1024) {
            $debug_messages[] = "Error, el tamaño máximo permitido es 3MB";
            echo json_encode(['success' => false, 'error' => 'Error, el tamaño máximo permitido es 3MB', 'debug' => $debug_messages]);
            exit;
        } else {
            $src = $carpeta . $nombre;
            if (move_uploaded_file($ruta_provisional, $src)) {
                $image = $src;
                $debug_messages[] = "Archivo movido a: $src";
            } else {
                $debug_messages[] = "Error al mover el archivo.";
                echo json_encode(['success' => false, 'error' => 'Error al mover el archivo.', 'debug' => $debug_messages]);
                exit;
            }
        }
    } else {
        // Obtener la ruta de la imagen existente
        $query = "SELECT foto FROM producto WHERE productoID = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $productId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $image);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }

    // Actualizar el producto en la base de datos
    $query = "UPDATE producto SET nombreProducto = ?, descripcionProducto = ?, precio = ?, categoriaID = ?, foto = ? WHERE productoID = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ssdsis', $productName, $productDescription, $productPrice, $productCategory, $image, $productId);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true, 'product' => [
            'productoID' => $productId,
            'nombreProducto' => $productName,
            'precio' => $productPrice,
            'descripcionProducto' => $productDescription,
            'categoriaID' => $productCategory,
            'foto' => $image
        ], 'debug' => $debug_messages]);
    } else {
        $debug_messages[] = 'Error: ' . mysqli_stmt_error($stmt);
        echo json_encode(['success' => false, 'error' => 'Error: ' . mysqli_stmt_error($stmt), 'debug' => $debug_messages]);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
}
?>
