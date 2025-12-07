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
     public function editar() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $cita = $this->citaModel->findById($id);

            if ($cita) {
                // También necesitamos las listas de estudiantes y profesionales para los menús desplegables
                $estudiantes = $this->usuarioModel->getEstudiantes();
                $profesionales = $this->usuarioModel->getProfesionales();
                
                $pageTitle = "Editar Cita";
                $activePage = "citas";
                
                require BASE_PATH . '/View/templates/header.php';
                // Llamamos a la nueva vista de edición que crearemos
                require BASE_PATH . '/View/citas/editar.php';
                require BASE_PATH . '/View/templates/footer.php';
            } else {
                header("Location: index.php?controller=Cita&action=index&error=" . urlencode("Cita no encontrada."));
                exit();
            }
        }
    }

    // ===== NUEVA ACCIÓN PARA PROCESAR LA ACTUALIZACIÓN DE CITAS =====
    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->citaModel->update(
                $_POST['idCita'],
                $_POST['fechaCita'],
                $_POST['horaCita'],
                $_POST['tipoConsulta'],
                $_POST['estado'],
                $_POST['idUsuario'],
                $_POST['idProfesional']
            );
            
            $success = urlencode("Cita actualizada correctamente.");
            header("Location: index.php?controller=Cita&action=index&success=$success");
            exit();
        }
    }
    public function apiGetAllCitas() {
        // Obtenemos los datos usando la función del modelo que ya existe
        $citas = $this->citaModel->getAll();

        // Le decimos al cliente (la app Flutter) que le estamos enviando JSON
        header('Content-Type: application/json; charset=utf-8');
        
        // Convertimos el array de PHP a formato JSON y lo imprimimos
        echo json_encode($citas);
        
        // Detenemos la ejecución para no enviar nada más
        exit();
    }
    public function getCitaJson() {
        if (isset($_GET['id'])) {
            $cita = $this->citaModel->findById($_GET['id']);
            if ($cita) {
                // Para el modal, también necesitamos pasar las listas de estudiantes y profesionales
                $estudiantes = $this->usuarioModel->getEstudiantes();
                $profesionales = $this->usuarioModel->getProfesionales();

                $response = [
                    'cita' => $cita,
                    'estudiantes' => $estudiantes,
                    'profesionales' => $profesionales
                ];

                header('Content-Type: application/json');
                echo json_encode($response);
                exit();
            }
        }
        // Si no hay ID o la cita no se encuentra, devuelve un error
        header("HTTP/1.0 404 Not Found");
        exit();
    }

}
?>