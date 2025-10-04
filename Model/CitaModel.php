<?php
require_once 'Model/Database.php';

class CitaModel extends Database {
    public function getAll() {
        $stmt = $this->pdo->prepare("SELECT * FROM citas ORDER BY fecha_hora DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getLatest($limit = 5) {
        $stmt = $this->pdo->prepare("SELECT c.fecha_hora, u.nombre, u.apellido, c.tipo_consulta, c.estado 
                                     FROM citas c JOIN usuarios u ON c.estudiante_id = u.id_usuario 
                                     ORDER BY c.fecha_hora DESC LIMIT ?");
        $stmt->bindParam(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($fecha_hora, $tipo_consulta, $estado, $estudiante_id, $personal_salud_id) {
        $stmt = $this->pdo->prepare("INSERT INTO citas (fecha_hora, tipo_consulta, estado, estudiante_id, personal_salud_id) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$fecha_hora, $tipo_consulta, $estado, $estudiante_id, $personal_salud_id]);
    }
    
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM citas WHERE id_cita = ?");
        return $stmt->execute([$id]);
    }
    
    public function count() {
        return $this->pdo->query("SELECT COUNT(*) FROM citas")->fetchColumn();
    }
}
?>