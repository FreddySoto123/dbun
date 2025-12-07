<?php
require_once BASE_PATH . '/Model/HorarioModel.php';
// AÑADIMOS EL MODELO DE USUARIO PARA OBTENER LA LISTA DE PROFESIONALES
require_once BASE_PATH . '/Model/UsuarioModel.php';

class HorarioController {
    private $horarioModel;
    private $usuarioModel; // Añadimos la propiedad para el modelo de usuario

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
        $this->horarioModel = new HorarioModel();
        $this->usuarioModel = new UsuarioModel(); // Creamos la instancia
    }

    public function index() {
        // Obtener los datos existentes
        $horarios = $this->horarioModel->getAll();

        // =======================================================
        // OBTENEMOS LA LISTA PARA EL MENÚ DESPLEGABLE DE PROFESIONALES
        $profesionales = $this->usuarioModel->getProfesionales();
        // =======================================================

        $error_message = $_GET['error'] ?? '';
        $success_message = $_GET['success'] ?? '';
        
        $pageTitle = "Configuración de Horarios";
        $activePage = "horarios";
        
        require BASE_PATH . '/View/templates/header.php';
        require BASE_PATH . '/View/horarios/index.php';
        require BASE_PATH . '/View/templates/footer.php';
    }

    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->horarioModel->create(
                $_POST['idProfesional'],
                $_POST['diaSemana'],
                $_POST['activo']
            );
            
            $success = urlencode("Día de atención añadido correctamente.");
            header("Location: index.php?controller=Horario&action=index&success=$success");
            exit();
        }
    }

    public function eliminar() {
        if (isset($_GET['id'])) {
            $this->horarioModel->delete($_GET['id']);
            header("Location: index.php?controller=Horario&action=index");
            exit();
        }
    }

    public function editar() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $horario = $this->horarioModel->findById($id);

            if ($horario) {
                // Necesitamos la lista de profesionales para el menú desplegable
                $profesionales = $this->usuarioModel->getProfesionales();
                
                $pageTitle = "Editar Día de Atención";
                $activePage = "horarios";
                
                require BASE_PATH . '/View/templates/header.php';
                // Llamamos a la nueva vista de edición que crearemos
                require BASE_PATH . '/View/horarios/editar.php';
                require BASE_PATH . '/View/templates/footer.php';
            } else {
                header("Location: index.php?controller=Horario&action=index&error=" . urlencode("Registro de horario no encontrado."));
                exit();
            }
        }
    }

    // ===== NUEVA ACCIÓN PARA PROCESAR LA ACTUALIZACIÓN DE HORARIOS =====
    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->horarioModel->update(
                $_POST['idDiasAtencion'],
                $_POST['idProfesional'],
                $_POST['diaSemana'],
                $_POST['activo']
            );
            
            $success = urlencode("Día de atención actualizado correctamente.");
            header("Location: index.php?controller=Horario&action=index&success=$success");
            exit();
        }
    }
      public function getHorarioJson() {
        if (isset($_GET['id'])) {
            $horario = $this->horarioModel->findById($_GET['id']);
            if ($horario) {
                // También necesitamos la lista de profesionales para el menú desplegable
                $profesionales = $this->usuarioModel->getProfesionales();

                $response = [
                    'horario' => $horario,
                    'profesionales' => $profesionales
                ];

                header('Content-Type: application/json');
                echo json_encode($response);
                exit();
            }
        }
        // Si no hay ID o el registro no se encuentra, devuelve un error
        header("HTTP/1.0 404 Not Found");
        exit();
    }
}
?>