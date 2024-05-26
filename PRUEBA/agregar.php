<?php
require 'm_conexion.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descripcion = $_POST['descripcion'];
    $image = '';

    if (isset($_FILES["foto"])) {
        $file = $_FILES["foto"];
        $nombre = $file["name"];
        $tipo = $file["type"];
        $ruta_provisional = $file["tmp_name"];
        $size = $file["size"];
        $dimensiones = getimagesize($ruta_provisional);
        $width = $dimensiones[0];
        $height = $dimensiones[1];
        $carpeta = "fotografias/";

        if ($tipo != 'image/jpg' && $tipo != 'image/jpeg' && $tipo != 'image/png' && $tipo != 'image/gif') {
            echo "Error, el archivo no es una imagen";
            exit;
        } else if ($size > 3 * 1024 * 1024) {
            echo "Error, el tamaño máximo permitido es 3MB";
            exit;
        } else {
            $src = $carpeta . $nombre;
            if (move_uploaded_file($ruta_provisional, $src)) {
                $image = $src;
            } else {
                echo "Error al mover el archivo.";
                exit;
            }
        }
    }

    $query = "INSERT INTO categoria (descripcion, foto) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ss', $descripcion, $image);

    if (mysqli_stmt_execute($stmt)) {
        echo "Producto guardado exitosamente";
        header('Location: form.html');
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo "Método no permitido";
}
?>
