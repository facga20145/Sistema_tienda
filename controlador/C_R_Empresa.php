<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../modelo/M_R_Empresa.php';

class RegistroController {
    private $EmpresaModel;

    public function __construct() {
        $this->EmpresaModel = new EmpresaModel();
    }

    public function registrar() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            try {
                // Recolectar y sanitizar los datos del formulario

                $nombreEmpresa = htmlspecialchars($_POST['nombreEmpresa']);
                $direccion = htmlspecialchars($_POST['direccion']);
                $telefono = htmlspecialchars($_POST['telefono']);
                $email = htmlspecialchars($_POST['email']);
                $contrasena = $_POST['contrasenha'];  // La contraseña será hasheada en el modelo


                // Llamar al método en el modelo para insertar el cliente
                $this->EmpresaModel->insertarEmpresa($nombreEmpresa, $direccion, $telefono, $email,$contrasena);

                // Redireccionar al usuario a la página de login tras el registro exitoso
                header("Location: ../vista/V_R_Empresa/Empresa_login.html");
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
