<?php
require_once BASE_PATH . '/Model/UsuarioModel.php';
require_once BASE_PATH . '/Model/ProfesionalModel.php';

class UsuarioController {
    private $usuarioModel;
    private $profesionalModel; 

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php?controller=Login');
            exit();
        }
        // Si el usuario no es un Administrador (rol 3), se le niega el acceso.
        if ($_SESSION['user_role'] != 3) {
            header('Location: ' . BASE_URL . '/index.php?controller=Login&error=access_denied');
            exit();
        }
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
    public function editar() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $usuario = $this->usuarioModel->findById($id);

            if ($usuario) {
                $pageTitle = "Editar Usuario";
                $activePage = "usuarios";
                require BASE_PATH . '/View/templates/header.php';
                require BASE_PATH . '/View/usuarios/editar.php';
                require BASE_PATH . '/View/templates/footer.php';
            } else {
                header("Location: index.php?controller=Usuario&action=index&error=" . urlencode("Usuario no encontrado."));
                exit();
            }
        }
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['idUsuario'];
            $password_hashed = null;
            if (!empty($_POST['password'])) {
                $password_hashed = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }

            $this->usuarioModel->update(
                $id,
                $_POST['nombres'],
                $_POST['apellidoPaterno'],
                $_POST['apellidoMaterno'],
                $_POST['correo'],
                $_POST['idRol'],
                $password_hashed
            );

            $success = urlencode("Usuario actualizado correctamente.");
            header("Location: index.php?controller=Usuario&action=index&success=$success");
            exit();
        }
    }
    public function getUsuarioJson() {
        if (isset($_GET['id'])) {
            $usuario = $this->usuarioModel->findById($_GET['id']);
            if ($usuario) {
                header('Content-Type: application/json');
                echo json_encode($usuario);
                exit();
            }
        }
        // Si no hay ID o el usuario no se encuentra, devuelve un error
        header("HTTP/1.0 404 Not Found");
        exit();
    }
}
?>