<?php
require_once BASE_PATH . '/Model/UsuarioModel.php';

class LoginController {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new UsuarioModel();
    }

    // Muestra la página del formulario de login
    public function index() {
        $error = $_GET['error'] ?? '';
        require_once BASE_PATH . '/View/login/index.php';
    }

    // Procesa el intento de inicio de sesión
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->usuarioModel->findByEmailForAuth($email);

            // Verifica si el usuario existe y si la contraseña es correcta
            if ($user && password_verify($password, $user['Password'])) {
                // Inicia la sesión y guarda los datos del usuario
                $_SESSION['user_id'] = $user['idUsuario'];
                $_SESSION['user_name'] = $user['Nombres'];
                $_SESSION['user_role'] = $user['IdRol'];

                // Redirige según el rol del usuario
                switch ($user['IdRol']) {
                    case 2: // Profesional
                        header('Location: ' . BASE_URL . '/index.php?controller=Professional&action=index');
                        break;
                    case 3: // Administrador
                        header('Location: ' . BASE_URL . '/index.php?controller=Dashboard&action=index');
                        break;
                    default: // Otros roles (ej. Estudiante) son redirigidos al login por ahora
                        header('Location: ' . BASE_URL . '/index.php?controller=Login&error=access_denied');
                        break;
                }
                exit();
            } else {
                // Credenciales incorrectas, redirige de vuelta al login con un error
                header('Location: ' . BASE_URL . '/index.php?controller=Login&error=invalid_credentials');
                exit();
            }
        }
    }

    // Cierra la sesión del usuario
    public function logout() {
        session_unset();
        session_destroy();
        header('Location: ' . BASE_URL . '/index.php?controller=Login');
        exit();
    }
}
?>