<?php
require_once BASE_PATH . '/Model/UsuarioModel.php';

class UsuarioController {
private $model;

public function __construct() {
$this->model = new UsuarioModel();
}

public function index() {
$usuarios = $this->model->getAll();
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
if ($this->model->findByEmail($correo)) {
$error = urlencode("El correo electrónico ya está registrado.");
header("Location: index.php?controller=usuario&action=index&error=$error");
} else {
$this->model->create($_POST['nombre'], $_POST['apellido'], $_POST['correo'], $_POST['rol_id']);
$success = urlencode("Usuario añadido correctamente.");
header("Location: index.php?controller=usuario&action=index&success=$success");
}
}
}

public function eliminar() {
if (isset($_GET['id'])) {
$this->model->delete($_GET['id']);
header("Location: index.php?controller=usuario&action=index");
}
}
}
?>