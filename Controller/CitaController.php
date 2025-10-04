<?php
require_once BASE_PATH . '/Model/CitaModel.php';

class CitaController {
    private $model;

    public function __construct() {
        $this->model = new CitaModel();
    }

    /**
     * Muestra la página principal de gestión de citas (formulario y lista).
     */
    public function index() {
        // Obtener todas las citas del modelo
        $citas = $this->model->getAll();

        // Obtener mensajes de la URL si existen
        $error_message = $_GET['error'] ?? '';
        $success_message = $_GET['success'] ?? '';
        
        // Variables para la vista (header)
        $pageTitle = "Gestión de Citas";
        $activePage = "citas";
        
        // Cargar las vistas
       require BASE_PATH . '/View/templates/header.php';
        require BASE_PATH . '/View/citas/index.php';
        require BASE_PATH . '/View/templates/footer.php';
    }

    /**
     * Procesa la creación de una nueva cita desde el formulario.
     */
    public function crear() {
        // Solo proceder si la petición es de tipo POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Llamar al modelo para crear la cita con los datos del formulario
            $this->model->create(
                $_POST['fecha_hora'],
                $_POST['tipo_consulta'],
                $_POST['estado'],
                $_POST['estudiante_id'],
                $_POST['personal_salud_id']
            );
            
            // Redirigir a la página principal de citas con un mensaje de éxito
            $success = urlencode("Cita añadida correctamente.");
            header("Location: index.php?controller=cita&action=index&success=$success");
            exit();
        }
    }

    /**
     * Procesa la eliminación de una cita.
     */
    public function eliminar() {
        // Solo proceder si se ha proporcionado un ID en la URL
        if (isset($_GET['id'])) {
            $this->model->delete($_GET['id']);
            
            // Redirigir a la página principal de citas
            header("Location: index.php?controller=cita&action=index");
            exit();
        }
    }
}
?>