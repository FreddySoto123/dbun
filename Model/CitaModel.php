<?php
require_once BASE_PATH . '/Model/Database.php';

class CitaModel extends Database {

    // La consulta es más compleja: necesitamos unir 3 tablas para obtener los nombres.
    public function getAll() {
        $stmt = $this->pdo->prepare("
            SELECT 
                c.*, 
                estudiante.Nombres as estudiante_nombre, 
                estudiante.ApellidoPaterno as estudiante_apellido,
                profesional_usuario.Nombres as profesional_nombre,
                profesional_usuario.ApellidoPaterno as profesional_apellido
            FROM Cita c
            -- Unimos con la tabla Usuario para el nombre del estudiante
            JOIN Usuario as estudiante ON c.IdUsuario = estudiante.IdUsuario
            -- Unimos con Profesional para encontrar al médico
            JOIN Profesional p ON c.IdProfesional = p.IdProfesional
            -- Unimos de nuevo con Usuario para el nombre del profesional
            JOIN Usuario as profesional_usuario ON p.IdUsuario = profesional_usuario.IdUsuario
            ORDER BY c.FechaCita DESC, c.HoraCita DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Adaptamos las columnas y JOINS para la consulta de las últimas citas.
    public function getLatest($limit = 5) {
        // Esta consulta es muy similar a getAll, solo que con un límite.
        $stmt = $this->pdo->prepare("
            SELECT c.FechaCita, c.HoraCita, c.TipoConsulta, c.Estado,
                   u.Nombres, u.ApellidoPaterno
            FROM Cita c
            JOIN Usuario u ON c.IdUsuario = u.IdUsuario
            ORDER BY c.FechaCita DESC, c.HoraCita DESC
            LIMIT ?
        ");
        $stmt->bindParam(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   public function create($fechaCita, $horaCita, $tipoConsulta, $estado, $idUsuario, $idProfesional) {
        $stmt = $this->pdo->prepare("
            INSERT INTO Cita (FechaCita, HoraCita, TipoConsulta, Estado, IdUsuario, IdProfesional) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$fechaCita, $horaCita, $tipoConsulta, $estado, $idUsuario, $idProfesional]);
    }
    
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM Cita WHERE IdCita = ?");
        return $stmt->execute([$id]);
    }
    
    public function count() {
        return $this->pdo->query("SELECT COUNT(*) FROM Cita")->fetchColumn();
    }
     public function getAppointmentsForProfessionalByDate($idProfesional, $fecha) {
        $stmt = $this->pdo->prepare("
            SELECT c.HoraCita, c.TipoConsulta, c.Estado,
                   u.Nombres as estudiante_nombre, u.ApellidoPaterno as estudiante_apellido
            FROM Cita c
            JOIN Usuario u ON c.IdUsuario = u.idUsuario
            WHERE c.IdProfesional = ? AND c.FechaCita = ?
            ORDER BY c.HoraCita ASC
        ");
        $stmt->execute([$idProfesional, $fecha]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
 

public function getCitasPorTipo() {
    $stmt = $this->pdo->prepare("
        SELECT TipoConsulta, COUNT(*) as cantidad
        FROM Cita
        GROUP BY TipoConsulta
    ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function getPromedioCitasPorEstudiante() {
    $stmt = $this->pdo->prepare("
        SELECT AVG(citas_por_estudiante) as promedio
        FROM (SELECT COUNT(*) as citas_por_estudiante FROM Cita GROUP BY IdUsuario) as subconsulta
    ");
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
 public function getUpcomingAppointmentsForProfessional($idProfesional) {
        $stmt = $this->pdo->prepare("
            SELECT c.FechaCita, c.HoraCita, c.TipoConsulta, c.Estado,
                   u.Nombres as estudiante_nombre, u.ApellidoPaterno as estudiante_apellido
            FROM Cita c
            JOIN Usuario u ON c.IdUsuario = u.idUsuario
            WHERE c.IdProfesional = ? AND c.FechaCita >= CURDATE()
            ORDER BY c.FechaCita ASC, c.HoraCita ASC
        ");
        $stmt->execute([$idProfesional]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPastAppointmentsForProfessional($idProfesional) {
        $stmt = $this->pdo->prepare("
            SELECT c.FechaCita, c.HoraCita, c.TipoConsulta, c.Estado,
                   u.Nombres as estudiante_nombre, u.ApellidoPaterno as estudiante_apellido
            FROM Cita c
            JOIN Usuario u ON c.IdUsuario = u.idUsuario
            WHERE c.IdProfesional = ? AND c.FechaCita < CURDATE()
            ORDER BY c.FechaCita DESC, c.HoraCita DESC
        ");
        $stmt->execute([$idProfesional]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM Cita WHERE IdCita = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ===== NUEVO MÉTODO PARA ACTUALIZAR UNA CITA =====
    public function update($idCita, $fechaCita, $horaCita, $tipoConsulta, $estado, $idUsuario, $idProfesional) {
        $stmt = $this->pdo->prepare("
            UPDATE Cita SET 
                FechaCita = ?, 
                HoraCita = ?, 
                TipoConsulta = ?, 
                Estado = ?, 
                IdUsuario = ?, 
                IdProfesional = ?
            WHERE IdCita = ?
        ");
        return $stmt->execute([$fechaCita, $horaCita, $tipoConsulta, $estado, $idUsuario, $idProfesional, $idCita]);
    }
    public function getCitasUltimos7Dias() {
        $stmt = $this->pdo->prepare("
            SELECT 
                DATE(FechaCita) as fecha, 
                COUNT(*) as cantidad
            FROM Cita
            WHERE FechaCita >= CURDATE() - INTERVAL 6 DAY
            GROUP BY DATE(FechaCita)
            ORDER BY fecha ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>