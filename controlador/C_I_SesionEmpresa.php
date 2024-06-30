<?php
require_once '../modelo/M_I_SesionEmpresa.php';

class LoginEmpresaController {
    private $SEmpresaModel;

    public function __construct() {
        $this->SEmpresaModel = new SEmpresaModel();
    }

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $contraseña = $_POST['contrasena'];

            $empresaId = $this->SEmpresaModel->verificarUsuario($email, $contraseña);
            if ($empresaId) {
                session_start();
                $_SESSION['empresaID'] = $empresaId;
                header("Location: ../vista/V_R_Productos/index.html");
                exit();
            } else {
                echo "Error en las credenciales.";
            }
        }
    }
}

$controller = new LoginEmpresaController();
$controller->login();
?>