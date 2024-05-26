<?php
require 'm_conexion.php';

$query = "SELECT * FROM producto";
$result = mysqli_query($conn, $query);

$productos = [];

while ($row = mysqli_fetch_assoc($result)) {
    $productos[] = $row;
}

echo json_encode($productos);

mysqli_close($conn);
?>
