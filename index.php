<?php
// Controlador Frontal - Único punto de entrada

// ------------------- CAMBIO CLAVE -------------------
// Definimos una constante con la ruta absoluta a la raíz del proyecto.
// __DIR__ es una constante mágica de PHP que devuelve la carpeta del archivo actual.
define('BASE_PATH', __DIR__);
// ----------------- FIN DEL CAMBIO -----------------
define('BASE_URL', '/royecto');

// 1. Obtener el controlador y la acción de la URL
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'Dashboard';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// 2. Formatear el nombre del archivo y la clase del controlador
$controllerName = ucfirst($controller) . 'Controller';
$controllerFile = BASE_PATH . '/Controller/' . $controllerName . '.php';

// 3. Verificar si el controlador existe y cargarlo
if (file_exists($controllerFile)) {
    require_once $controllerFile;

    // 4. Crear una instancia del controlador y llamar a la acción
    $controllerInstance = new $controllerName();
    
    if (method_exists($controllerInstance, $action)) {
        $controllerInstance->$action();
    } else {
        die("Error: La acción '$action' no existe en el controlador '$controllerName'.");
    }
} else {
    die("Error: El controlador '$controllerName' no existe.");
}
?>