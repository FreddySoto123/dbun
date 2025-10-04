<?php
require_once BASE_PATH . '/Model/Database.php';
class UsuarioModel extends Database {
    public function getAll() {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios ORDER BY nombre ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function findByEmail($correo) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE correo = ?");
        $stmt->execute([$correo]);
        return $stmt->fetchColumn() > 0;
    }

    public function create($nombre, $apellido, $correo, $rol_id) {
        $stmt = $this->pdo->prepare("INSERT INTO usuarios (nombre, apellido, correo, rol_id) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$nombre, $apellido, $correo, $rol_id]);
    }
    
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
        return $stmt->execute([$id]);
    }
    
    public function count() {
        return $this->pdo->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
    }
}
?>