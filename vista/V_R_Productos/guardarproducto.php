<?php
require '../../modelo/m_conexion.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombreProducto = $_POST['productName'];
    $precio = $_POST['productPrice'];
    $descripcion = $_POST['productDescription'];
    $categoriaID = 1;  // Puedes cambiar esto según tu lógica
    $empresaID = 2;  // Puedes cambiar esto según tu lógica
    $image = '';

    echo "<pre>";
print_r($_POST);
print_r($_FILES);
echo "</pre>";
exit;


    if (isset($_FILES["productImage"])) {
        $file = $_FILES["productImage"];
        $nombre = $file["name"];
        $tipo = $file["type"];
        $ruta_provisional = $file["tmp_name"];
        $size = $file["size"];
        $dimensiones = getimagesize($ruta_provisional);
        $width = $dimensiones[0];
        $height = $dimensiones[1];
        $carpeta = "../../fotos/";

        if ($tipo != 'image/jpg' && $tipo != 'image/jpeg' && $tipo != 'image/png' && $tipo != 'image/gif') {
            echo "Error, el archivo no es una imagen";
            exit;
        } else if ($size > 3 * 1024 * 1024) {
            echo "Error, el tamaño máximo permitido es 3MB";
            exit;
        } else {
            $src = $carpeta . $nombre;
            if (move_uploaded_file($ruta_provisional, $src)) {
                $image = "fotos/" . $nombre;
            } else {
                echo "Error al mover el archivo.";
                exit;
            }
        }
    }

    $query = "INSERT INTO producto (categoriaID, empresaID, nombreProducto, descripcionProducto, precio, foto) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'iissds', $categoriaID, $empresaID, $nombreProducto, $descripcion, $precio, $image);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "Producto guardado exitosamente";
        header('Location: index.html');
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo "Método no permitido";
}
?>
