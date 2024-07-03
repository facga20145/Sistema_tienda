<?php
// Datos de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stylegenie";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

// Obtener los datos del formulario
$nombre = $_POST['introducir_nombre'];
$email = $_POST['introducir_email'];
$telefono = $_POST['introducir_telefono'];
$asunto = $_POST['introducir_asunto'];
$mensaje = $_POST['introducir_mensaje'];

// Insertar datos en la base de datos
$sql = "INSERT INTO contactos (nombre, email, telefono, asunto, mensaje) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $nombre, $email, $telefono, $asunto, $mensaje);

if ($stmt->execute()) {
    echo "<script>alert('Registro completado exitosamente'); window.location.href = 'http://localhost/Sistema_tienda/vista/V_V_Catalogo/V_Contactar/Contactar.html';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar conexión
$stmt->close();
$conn->close();
?>
