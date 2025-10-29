<?php
// Añadimos los modelos que vamos a necesitar
require_once BASE_PATH . '/Model/CitaModel.php';
require_once BASE_PATH . '/Model/ProfesionalModel.php';

class ProfessionalController {
    private $citaModel;
    private $profesionalModel;

    public function __construct() {
        // Bloque de seguridad (ya lo tienes)
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 2) {
            header('Location: ' . BASE_URL . '/index.php?controller=Login&error=access_denied');
            exit();
        }

        // Creamos las instancias de los modelos
        $this->citaModel = new CitaModel();
        $this->profesionalModel = new ProfesionalModel();
    }

    public function index() {
        // 1. Obtener el IdUsuario del profesional que ha iniciado sesión
        $idUsuarioLogueado = $_SESSION['user_id'];
        
        // 2. Encontrar su IdProfesional correspondiente
        $idProfesional = $this->profesionalModel->findProfesionalByUserId($idUsuarioLogueado);
        
        $citasHoy = []; // Inicializamos como array vacío
        
        // 3. Si encontramos un ID de profesional, buscamos sus citas para hoy
        if ($idProfesional) {
            $fechaHoy = date('Y-m-d'); // Obtiene la fecha actual
            $citasHoy = $this->citaModel->getAppointmentsForProfessionalByDate($idProfesional, $fechaHoy);
        }

        // 4. Pasamos los datos a la vista
        $pageTitle = "Dashboard del Profesional";
        $activePage = "dashboard_profesional";

        require BASE_PATH . '/View/templates/header.php';
        require BASE_PATH . '/View/professional/index.php';
        require BASE_PATH . '/View/templates/footer.php';
    }
}
?>