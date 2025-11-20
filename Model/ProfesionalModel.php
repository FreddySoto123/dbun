<?php
require_once BASE_PATH . '/Model/Database.php';

class ProfesionalModel extends Database {

    /**
     * Crea un registro de profesional básico vinculado a un ID de usuario.
     * Se asignan valores por defecto que el administrador o el profesional podrán actualizar más tarde.
     * @param int $idUsuario El ID del usuario recién creado en la tabla 'Usuario'.
     * @return bool Devuelve true si la creación fue exitosa, false en caso contrario.
     */
    public function create($idUsuario) {
        try {
            $stmt = $this->pdo->prepare(
                "INSERT INTO Profesional (IdUsuario, Especialidad, HorarioInicio, HorarioFin) VALUES (?, 'No especificada', '08:00:00', '17:00:00')"
            );
            return $stmt->execute([$idUsuario]);
        } catch (PDOException $e) {
            // Opcional: Manejar o registrar el error si algo sale mal.
            // Por ahora, simplemente devolvemos false.
            return false;
        }
    }
     public function findProfesionalByUserId($idUsuario) {
        $stmt = $this->pdo->prepare("SELECT IdProfesional FROM Profesional WHERE IdUsuario = ?");
        $stmt->execute([$idUsuario]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['IdProfesional'] : false;
    }
       public function getProfessionalDetailsByUserId($idUsuario) {
        $stmt = $this->pdo->prepare("
            SELECT u.*, p.Especialidad, p.HorarioInicio, p.HorarioFin
            FROM Profesional p
            JOIN Usuario u ON p.IdUsuario = u.idUsuario
            WHERE p.IdUsuario = ?
        ");
        $stmt->execute([$idUsuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
     public function updateProfessionalDetails($idUsuario, $data) {
        // Iniciar transacción para asegurar que ambas actualizaciones se completen
        $this->pdo->beginTransaction();
        try {
            // 1. Actualizar la tabla Usuario
            $stmtUser = $this->pdo->prepare(
                "UPDATE Usuario SET Nombres = ?, ApellidoPaterno = ?, ApellidoMaterno = ? WHERE idUsuario = ?"
            );
            $stmtUser->execute([
                $data['nombres'],
                $data['apellidoPaterno'],
                $data['apellidoMaterno'],
                $idUsuario
            ]);

            // 2. Actualizar la tabla Profesional
            $stmtProf = $this->pdo->prepare(
                "UPDATE Profesional SET Especialidad = ?, HorarioInicio = ?, HorarioFin = ? WHERE IdUsuario = ?"
            );
            $stmtProf->execute([
                $data['especialidad'],
                $data['horarioInicio'],
                $data['horarioFin'],
                $idUsuario
            ]);

            // Si todo fue bien, confirmar los cambios
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            // Si algo falla, revertir todos los cambios
            $this->pdo->rollBack();
            // Opcional: registrar el error $e->getMessage()
            return false;
        }
    }

    // --- Aquí podrías añadir más funciones en el futuro ---
    
    /*
    public function findById($idProfesional) {
        // Lógica para encontrar un profesional por su ID
    }

    public function update($idProfesional, $especialidad, $horarioInicio, $horarioFin) {
        // Lógica para actualizar los datos de un profesional
    }
    */
}
?>