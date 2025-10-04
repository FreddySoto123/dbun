<?php
// CAMBIO CLAVE: Usamos BASE_PATH para encontrar la configuración
require_once BASE_PATH . '/config/dbconfig.php';

class Database {
    protected $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
                DB_USER,
                DB_PASS
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
?>