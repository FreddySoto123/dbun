<?php
require_once BASE_PATH . '/Model/Database.php';

class UsuarioModel extends Database {
    
    public function getAll() {
        $stmt = $this->pdo->prepare("
            SELECT u.*, r.Nombre as rol_nombre 
            FROM Usuario u
            JOIN Rol r ON u.IdRol = r.idRol
            ORDER BY u.Nombres ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function findByEmail($correo) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Usuario WHERE CorreoInstitucional = ?");
        $stmt->execute([$correo]);
        return $stmt->fetchColumn() > 0;
    }

    public function create($nombres, $apellidoPaterno, $apellidoMaterno, $correo, $password, $idRol) {
        $stmt = $this->pdo->prepare("
            INSERT INTO Usuario (Nombres, ApellidoPaterno, ApellidoMaterno, CorreoInstitucional, Password, Estado, IdRol) 
            VALUES (?, ?, ?, ?, ?, 'ACTIVO', ?)
        ");
        return $stmt->execute([$nombres, $apellidoPaterno, $apellidoMaterno, $correo, $password, $idRol]);
    }
    
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM Usuario WHERE idUsuario = ?");
        return $stmt->execute([$id]);
    }
    
    public function count() {
        return $this->pdo->query("SELECT COUNT(*) FROM Usuario")->fetchColumn();
    }

    public function getEstudiantes() {
        $stmt = $this->pdo->prepare("
            SELECT idUsuario, Nombres, ApellidoPaterno 
            FROM Usuario 
            WHERE IdRol = 1 
            ORDER BY Nombres ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProfesionales() {
        $stmt = $this->pdo->prepare("
            SELECT p.IdProfesional, u.Nombres, u.ApellidoPaterno
            FROM Profesional p
            JOIN Usuario u ON p.IdUsuario = u.idUsuario
            ORDER BY u.Nombres ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Devuelve el ID del último registro insertado en la conexión actual a la base de datos.
     * Es crucial para vincular un nuevo Usuario con su registro en Profesional.
     * @return string|false El ID del último registro, o false si la operación falla.
     */
    public function getLastInsertId() {
        return $this->pdo->lastInsertId();
    }
}
?>