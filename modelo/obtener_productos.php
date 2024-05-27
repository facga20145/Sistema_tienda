<?php
require 'm_conexion.php';

$query = "SELECT * FROM producto WHERE estado = 1";
$result = mysqli_query($conn, $query);

$productos = array();
while ($row = mysqli_fetch_assoc($result)) {
    $productos[] = $row;
}

if (empty($productos)) {
    echo json_encode(["error" => "No products found"]);
} else {
    echo json_encode($productos);
}

mysqli_close($conn);
?>
