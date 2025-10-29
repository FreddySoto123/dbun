<?php
require_once BASE_PATH . '/Model/CitaModel.php';
// AÑADIMOS EL MODELO DE USUARIO PARA OBTENER LAS LISTAS
require_once BASE_PATH . '/Model/UsuarioModel.php';

class CitaController {
    private $citaModel;
    private $usuarioModel; // Añadimos una propiedad para el modelo de usuario

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
        $this->citaModel = new CitaModel();
        $this->usuarioModel = new UsuarioModel(); // Creamos la instancia
    }

    public function index() {
        // Obtener los datos existentes
        $citas = $this->citaModel->getAll();

        // =======================================================
        // OBTENEMOS LAS LISTAS PARA LOS MENÚS DESPLEGABLES
        $estudiantes = $this->usuarioModel->getEstudiantes();
        $profesionales = $this->usuarioModel->getProfesionales();
        // =======================================================

        $error_message = $_GET['error'] ?? '';
        $success_message = $_GET['success'] ?? '';
        
        $pageTitle = "Gestión de Citas";
        $activePage = "citas";
        
        require BASE_PATH . '/View/templates/header.php';
        require BASE_PATH . '/View/citas/index.php';
        require BASE_PATH . '/View/templates/footer.php';
    }

    public function crear() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $this->citaModel->create(
            $_POST['fechaCita'],
            $_POST['horaCita'],
            $_POST['tipoConsulta'],
            $_POST['estado'],
            $_POST['idUsuario'],
            $_POST['idProfesional']
        );
        
        $success = urlencode("Cita añadida correctamente.");
        header("Location: index.php?controller=Cita&action=index&success=$success");
        exit();
    }
}

    public function eliminar() {
        if (isset($_GET['id'])) {
            $this->citaModel->delete($_GET['id']);
            header("Location: index.php?controller=Cita&action=index");
            exit();
        }
    }
}
?>