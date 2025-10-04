<?php
require_once BASE_PATH . '/Model/Database.php';

class HorarioModel extends Database {
    public function getAll() {
        $stmt = $this->pdo->prepare("SELECT * FROM configuracion_horarios ORDER BY fecha_inicio DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($medico_id, $fecha_inicio, $fecha_fin, $estado) {
        $stmt = $this->pdo->prepare("INSERT INTO configuracion_horarios (medico_id, fecha_inicio, fecha_fin, estado) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$medico_id, $fecha_inicio, $fecha_fin, $estado]);
    }
    
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM configuracion_horarios WHERE id_horario = ?");
        return $stmt->execute([$id]);
    }
    
    public function count() {
        return $this->pdo->query("SELECT COUNT(*) FROM configuracion_horarios")->fetchColumn();
    }
}
?>