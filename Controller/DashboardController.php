<?php
require_once BASE_PATH . '/Model/UsuarioModel.php';
require_once BASE_PATH . '/Model/CitaModel.php';
require_once BASE_PATH . '/Model/HorarioModel.php';

class DashboardController {
    private $usuarioModel;
    private $citaModel;
    private $horarioModel;

   public function __construct() {
        // =================== BLOQUE DE SEGURIDAD ===================
        // Si el usuario no ha iniciado sesión, se le redirige al login.
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php?controller=Login');
            exit();
        }
        // Si el usuario no es un Administrador (rol 3), se le niega el acceso.
        if ($_SESSION['user_role'] != 3) {
            header('Location: ' . BASE_URL . '/index.php?controller=Login&error=access_denied');
            exit();
        }
        // =========================================================

        // El resto del constructor original
        $this->usuarioModel = new UsuarioModel();
        $this->citaModel = new CitaModel();
        $this->horarioModel = new HorarioModel();
    }

    public function index() {
        $totalUsuarios = $this->usuarioModel->count();
        $totalCitas = $this->citaModel->count();
        $totalHorarios = $this->horarioModel->count();
        $ultimasCitas = $this->citaModel->getLatest(5);

        $pageTitle = "Dashboard";
        $activePage = "dashboard";

             require BASE_PATH . '/View/templates/header.php';
        require BASE_PATH . '/View/dashboard/index.php';
        require BASE_PATH . '/View/templates/footer.php';
    }
}
?>