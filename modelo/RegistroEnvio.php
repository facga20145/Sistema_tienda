<?php
// Habilitar la visualización de errores de PHP
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stylegenie";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
} else {
    echo "Conexión exitosa a la base de datos.<br>";
}

// Verificar si se recibieron datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mostrar datos recibidos por el formulario (solo para depuración)
    echo "Datos recibidos del formulario:<br>";
    var_dump($_POST);

    // Obtener datos del formulario y sanitizarlos
    $nombreCompleto = $conn->real_escape_string($_POST['nombreCompleto']);
    $correoElectronico = $conn->real_escape_string($_POST['correoElectronico']);
    $numeroTelefono = $conn->real_escape_string($_POST['numeroTelefono']);
    $metodoEnvio = $conn->real_escape_string($_POST['metodoEnvio']);
    $notasAdicionales = $conn->real_escape_string($_POST['notasAdicionales']);

    // Mostrar datos sanitizados (solo para depuración)
    echo "Datos sanitizados: <br>";
    echo "Nombre Completo: $nombreCompleto<br>";
    echo "Correo Electrónico: $correoElectronico<br>";
    echo "Número de Teléfono: $numeroTelefono<br>";
    echo "Método de Envío: $metodoEnvio<br>";
    echo "Notas Adicionales: $notasAdicionales<br>";

    // Preparar la consulta SQL
    $sql = $conn->prepare("INSERT INTO registro_envios (nombre_completo, correo_electronico, numero_telefono, metodo_envio, notas_adicionales) 
            VALUES (?, ?, ?, ?, ?)");
    if ($sql === false) {
        die("Error en la preparación de la consulta SQL: " . $conn->error);
    }

    $sql->bind_param("sssss", $nombreCompleto, $correoElectronico, $numeroTelefono, $metodoEnvio, $notasAdicionales);

    // Ejecutar la consulta y verificar el resultado
    if ($sql->execute() === TRUE) {
        echo "Registro completado exitosamente.<br>";
        // Redirigir al usuario a la página de registro
        echo "<script>alert('Registro completado exitosamente'); window.location.href = '/RegistreEntrega/view/MV_Pago/index.html';</script>";
    } else {
        // Mostrar el error en caso de que la consulta falle
        echo "Error al registrar: " . $conn->error . "<br>";
    }

    $sql->close();
} else {
    echo "No se recibieron datos del formulario.<br>";
}

// Cerrar la conexión
$conn->close();
?>
