<?php
require_once BASE_PATH . '/Model/UsuarioModel.php';
require_once BASE_PATH . '/Model/ProfesionalModel.php';

class UsuarioController {
    private $usuarioModel;
    private $profesionalModel; 

    public function __construct() {
        $this->usuarioModel = new UsuarioModel();
        $this->profesionalModel = new ProfesionalModel(); 
    }

    public function index() {
        $usuarios = $this->usuarioModel->getAll();
        
        $error_message = $_GET['error'] ?? '';
        $success_message = $_GET['success'] ?? '';

        $pageTitle = "Gestión de Usuarios";
        $activePage = "usuarios";

        require BASE_PATH . '/View/templates/header.php';
        require BASE_PATH . '/View/usuarios/index.php';
        require BASE_PATH . '/View/templates/footer.php';
    }

    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = $_POST['correo'];
            $idRol = $_POST['idRol'];

            if ($this->usuarioModel->findByEmail($correo)) {
                $error = urlencode("El correo electrónico ya está registrado.");
                header("Location: index.php?controller=Usuario&action=index&error=$error");
                exit();
            } else {
                $password_hashed = password_hash($_POST['password'], PASSWORD_DEFAULT);

                $this->usuarioModel->create(
                    $_POST['nombres'], 
                    $_POST['apellidoPaterno'], 
                    $_POST['apellidoMaterno'], 
                    $correo, 
                    $password_hashed, 
                    $idRol
                );
                
                if ($idRol == 2) { 
                    $nuevoUsuarioId = $this->usuarioModel->getLastInsertId();
                    if ($nuevoUsuarioId) {
                        $this->profesionalModel->create($nuevoUsuarioId);
                    }
                }
                
                $success = urlencode("Usuario añadido correctamente.");
                header("Location: index.php?controller=Usuario&action=index&success=$success");
                exit();
            }
        }
    }

    public function eliminar() {
        if (isset($_GET['id'])) {
            $this->usuarioModel->delete($_GET['id']);
            header("Location: index.php?controller=Usuario&action=index");
            exit();
        }
    }
}
?>