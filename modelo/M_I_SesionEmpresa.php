<?php
require_once 'm_conexion.php';

class SEmpresaModel {
    private $conn;

    public function __construct() {
        $this->conn = $GLOBALS['conn'];
    }

    public function verificarUsuario($email, $contraseña) {
        $stmt = $this->conn->prepare("SELECT empresaID, contrasena FROM empresa WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($empresa = $result->fetch_assoc()) {
            if (password_verify($contraseña, $empresa['contrasena'])) {
                return $empresa['empresaID'];  // Retorna el ID del usuario si la contraseña es correcta
            }
        }
        return null;  // Retorna null si la autenticación falla
    }
}
?>
