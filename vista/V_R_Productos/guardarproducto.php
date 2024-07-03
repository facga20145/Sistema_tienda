<?php
require '../../modelo/m_conexion.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombreProducto = $_POST['productName'];
    $precio = (float)$_POST['productPrice'];
    $descripcion = $_POST['productDescription'];
    $categoriaID = $_POST['productCategory'];
    $empresaID = $_POST['Empresa'];
    $image = '';
    $estado = 1; // Default value for new products

    if (isset($_FILES["productImage"])) {
        $file = $_FILES["productImage"];
        $nombre = $file["name"];
        $tipo = $file["type"];
        $ruta_provisional = $file["tmp_name"];
        $size = $file["size"];
        $dimensiones = getimagesize($ruta_provisional);
        $width = $dimensiones[0];
        $height = $dimensiones[1];
        $carpeta = "fotos/";

        if ($tipo != 'image/jpg' && $tipo != 'image/jpeg' && $tipo != 'image/png' && $tipo != 'image/gif') {
            echo json_encode(["success" => false, "error" => "El archivo no es una imagen"]);
            exit;
        } else if ($size > 3 * 1024 * 1024) {
            echo json_encode(["success" => false, "error" => "El tamaño máximo permitido es 3MB"]);
            exit;
        } else {
            $src = $carpeta . $nombre;
            if (move_uploaded_file($ruta_provisional, $src)) {
                $image = $src;
            } else {
                echo json_encode(["success" => false, "error" => "Error al mover el archivo."]);
                exit;
            }
        }
    }

    $query = "INSERT INTO producto (categoriaID, empresaID, nombreProducto, descripcionProducto, precio, foto, estado) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'iissdsi', $categoriaID, $empresaID, $nombreProducto, $descripcion, $precio, $image, $estado);

    if (mysqli_stmt_execute($stmt)) {
        $productID = mysqli_insert_id($conn); // Obtener el ID del producto insertado
        $producto = [
            "productoID" => $productID,
            "nombreProducto" => $nombreProducto,
            "precio" => $precio,
            "descripcionProducto" => $descripcion,
            "categoriaID" => $categoriaID,
            "foto" => $image,
            "empresaID" => $empresaID,
            "estado" => $estado
        ];
        echo json_encode(["success" => true, "product" => $producto]);
    } else {
        echo json_encode(["success" => false, "error" => "Error: " . mysqli_stmt_error($stmt)]);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo json_encode(["success" => false, "error" => "Método no permitido"]);
}
?>
