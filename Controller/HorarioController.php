<?php
require_once BASE_PATH . '/Model/HorarioModel.php';

class HorarioController {
    private $model;

    public function __construct() {
        $this->model = new HorarioModel();
    }

    /**
     * Muestra la página principal de configuración de horarios.
     */
    public function index() {
        // Obtener todos los horarios del modelo
        $horarios = $this->model->getAll();

        // Obtener mensajes de la URL si existen
        $error_message = $_GET['error'] ?? '';
        $success_message = $_GET['success'] ?? '';
        
        // Variables para la vista (header)
        $pageTitle = "Configuración de Horarios";
        $activePage = "horarios";
        
        // Cargar las vistas
        require BASE_PATH . '/View/templates/header.php';
        require BASE_PATH . '/View/horarios/index.php';
        require BASE_PATH . '/View/templates/footer.php';
    }

    /**
     * Procesa la creación de un nuevo horario desde el formulario.
     */
    public function crear() {
        // Solo proceder si la petición es de tipo POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Llamar al modelo para crear el horario
            $this->model->create(
                $_POST['medico_id'],
                $_POST['fecha_inicio'],
                $_POST['fecha_fin'],
                $_POST['estado']
            );
            
            // Redirigir a la página principal de horarios con un mensaje de éxito
            $success = urlencode("Horario añadido correctamente.");
            header("Location: index.php?controller=horario&action=index&success=$success");
            exit();
        }
    }

    /**
     * Procesa la eliminación de un horario.
     */
    public function eliminar() {
        // Solo proceder si se ha proporcionado un ID en la URL
        if (isset($_GET['id'])) {
            $this->model->delete($_GET['id']);

            // Redirigir a la página principal de horarios
            header("Location: index.php?controller=horario&action=index");
            exit();
        }
    }
}
?>