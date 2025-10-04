<?php
require_once BASE_PATH . '/Model/UsuarioModel.php';
require_once BASE_PATH . '/Model/CitaModel.php';
require_once BASE_PATH . '/Model/HorarioModel.php';

class DashboardController {
    private $usuarioModel;
    private $citaModel;
    private $horarioModel;

    public function __construct() {
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