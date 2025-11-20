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
      public function profile() {
        $idUsuarioLogueado = $_SESSION['user_id'];
        $success_message = '';

        // Si el formulario fue enviado (método POST), procesar la actualización
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $updateSuccess = $this->profesionalModel->updateProfessionalDetails($idUsuarioLogueado, $_POST);
            if ($updateSuccess) {
                $success_message = "¡Perfil actualizado correctamente!";
            }
        }

        // Obtener los datos actualizados del profesional para mostrar en la vista
        $professionalData = $this->profesionalModel->getProfessionalDetailsByUserId($idUsuarioLogueado);

        // Si no se encuentran datos, es un error grave.
        if (!$professionalData) {
            die('Error: No se pudieron cargar los datos del perfil.');
        }

        $pageTitle = "Mi Perfil";
        $activePage = "profile";

        require BASE_PATH . '/View/templates/header.php';
        require BASE_PATH . '/View/professional/profile.php'; // La nueva vista que vamos a crear
        require BASE_PATH . '/View/templates/footer.php';
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
    public function appointments() {
        // 1. Obtener el IdUsuario del profesional logueado
        $idUsuarioLogueado = $_SESSION['user_id'];
        
        // 2. Encontrar su IdProfesional
        $idProfesional = $this->profesionalModel->findProfesionalByUserId($idUsuarioLogueado);
        
        $upcomingAppointments = [];
        $pastAppointments = [];
        
        // 3. Si encontramos un ID, buscamos sus citas futuras y pasadas
        if ($idProfesional) {
            $upcomingAppointments = $this->citaModel->getUpcomingAppointmentsForProfessional($idProfesional);
            $pastAppointments = $this->citaModel->getPastAppointmentsForProfessional($idProfesional);
        }

        // 4. Pasamos los datos a la nueva vista
        $pageTitle = "Mis Citas";
        $activePage = "mis_citas"; // Un nuevo identificador para el menú

        require BASE_PATH . '/View/templates/header.php';
        // Crearemos esta nueva vista en el siguiente paso
        require BASE_PATH . '/View/professional/appointments.php'; 
        require BASE_PATH . '/View/templates/footer.php';
    }
}
?>