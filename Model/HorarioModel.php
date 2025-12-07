<?php
require_once BASE_PATH . '/Model/Database.php';

class HorarioModel extends Database {

    // La consulta ahora une DiasAtencion, Profesional y Usuario.
    public function getAll() {
        $stmt = $this->pdo->prepare("
            SELECT 
                da.*, 
                u.Nombres as profesional_nombre, 
                u.ApellidoPaterno as profesional_apellido,
                p.HorarioInicio,
                p.HorarioFin
            FROM DiasAtencion da
            JOIN Profesional p ON da.IdProfesional = p.IdProfesional
            JOIN Usuario u ON p.IdUsuario = u.IdUsuario
            ORDER BY da.IdProfesional, da.DiaSemana
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // La creación ahora es sobre la tabla DiasAtencion.
    public function create($idProfesional, $diaSemana, $activo) {
        $stmt = $this->pdo->prepare("
            INSERT INTO DiasAtencion (IdProfesional, DiaSemana, Activo) 
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([$idProfesional, $diaSemana, $activo]);
    }
    
    // El ID corresponde a la tabla DiasAtencion.
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM DiasAtencion WHERE IdDiasAtencion = ?");
        return $stmt->execute([$id]);
    }
    
    // Contaremos los profesionales que tienen días de atención definidos.
    public function count() {
        return $this->pdo->query("SELECT COUNT(DISTINCT IdProfesional) FROM DiasAtencion")->fetchColumn();
    }

    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM DiasAtencion WHERE idDiasAtencion = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ===== NUEVO MÉTODO PARA ACTUALIZAR UN DÍA DE ATENCIÓN =====
    public function update($id, $idProfesional, $diaSemana, $activo) {
        $stmt = $this->pdo->prepare("
            UPDATE DiasAtencion SET 
                IdProfesional = ?, 
                DiaSemana = ?, 
                Activo = ? 
            WHERE idDiasAtencion = ?
        ");
        return $stmt->execute([$idProfesional, $diaSemana, $activo, $id]);
    }

}
?>