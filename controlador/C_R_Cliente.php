<?php
require_once '../modelo/M_R_Cliente.php';

class RegistroController {
    private $personaModel;

    public function __construct() {
        $this->personaModel = new PersonaModel();
    }

    public function registrar() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            try {
                // Recolectar y sanitizar los datos del formulario
                $dni = htmlspecialchars($_POST['dni']);
                $nombreUsuario = htmlspecialchars($_POST['nombreUsuario']);
                $contrasena = $_POST['contrasena'];  // La contraseña será hasheada en el modelo
                $nombre = htmlspecialchars($_POST['nombre']);
                $apellido = htmlspecialchars($_POST['apellido']);
                $telefono = htmlspecialchars($_POST['telefono']);
                $correo = htmlspecialchars($_POST['correo']);
                $direccion = htmlspecialchars($_POST['direccion']);
                $genero = htmlspecialchars($_POST['genero']);
                $fechaNacimiento = htmlspecialchars($_POST['fechaNacimiento']);

                // Llamar al método en el modelo para insertar el cliente
                $this->personaModel->insertarCliente($dni, $nombreUsuario, $contrasena, $nombre, $apellido, $telefono, $correo, $direccion, $genero, $fechaNacimiento);

                // Redireccionar al usuario a la página de login tras el registro exitoso
                header("Location: ../Vista/V_I_Sesion/login.html");
                exit();
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Solicitud inválida.";
        }
    }
}

// Crear una instancia del controlador y llamar al método registrar
$controller = new RegistroController();
$controller->registrar();
?>
