<?php
require_once '../modelo/m_conexion.php';
require_once '../modelo/M_R_Producto.php';

class ProductoControlador {
    private $db;
    private $product;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->product = new Product($this->db);
    }

    public function getAllProducts() {
        $stmt = $this->product->read();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($products);
    }

    public function createProduct() {
        $this->product->nombre = $_POST['productName'];
        $this->product->precio = $_POST['productPrice'];
        $this->product->descripcion = $_POST['productDescription'];
        $this->product->categoria = $_POST['productCategory'];
        $this->product->foto = $this->uploadImage();

        if ($this->product->create()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error creating product']);
        }
    }

    public function updateProduct() {
        $this->product->id = $_POST['productId'];
        $this->product->nombre = $_POST['productName'];
        $this->product->precio = $_POST['productPrice'];
        $this->product->descripcion = $_POST['productDescription'];
        $this->product->categoria = $_POST['productCategory'];
        $this->product->foto = $this->uploadImage();

        if ($this->product->update()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error updating product']);
        }
    }

    public function deleteProduct() {
        $this->product->id = $_GET['productId'];

        if ($this->product->delete()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error deleting product']);
        }
    }

    private function uploadImage() {
        if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['productImage'];
            $nombre = $file['name'];
            $tipo = $file['type'];
            $ruta_provisional = $file['tmp_name'];
            $size = $file['size'];
            $dimensiones = getimagesize($ruta_provisional);
            $width = $dimensiones[0];
            $height = $dimensiones[1];
            $carpeta = "../uploads/fotos/";

            if ($tipo != 'image/jpg' && $tipo != 'image/jpeg' && $tipo != 'image/png' && $tipo != 'image/gif') {
                echo json_encode(['success' => false, 'error' => 'Error, el archivo no es una imagen']);
                exit;
            } else if ($size > 3 * 1024 * 1024) {
                echo json_encode(['success' => false, 'error' => 'Error, el tamaño máximo permitido es 3MB']);
                exit;
            } else {
                $src = $carpeta . $nombre;
                if (move_uploaded_file($ruta_provisional, $src)) {
                    return $src;
                } else {
                    echo json_encode(['success' => false, 'error' => 'Error al mover el archivo.']);
                    exit;
                }
            }
        }
        return null;
    }
}
?>
