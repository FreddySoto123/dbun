<div class="header">
    <h1>Editar Usuario</h1>
</div>

<div class="card">
    <h2>Modificar datos del usuario</h2>
    
    <form action="index.php?controller=Usuario&action=actualizar" method="POST">
        <!-- Input oculto para enviar el ID del usuario -->
        <input type="hidden" name="idUsuario" value="<?php echo htmlspecialchars($usuario['idUsuario']); ?>">

        <div class="form-group">
            <label for="nombres">Nombres</label>
            <input type="text" id="nombres" name="nombres" value="<?php echo htmlspecialchars($usuario['Nombres']); ?>" required>
        </div>
        <div class="form-group">
            <label for="apellidoPaterno">Apellido Paterno</label>
            <input type="text" id="apellidoPaterno" name="apellidoPaterno" value="<?php echo htmlspecialchars($usuario['ApellidoPaterno']); ?>" required>
        </div>
        <div class="form-group">
            <label for="apellidoMaterno">Apellido Materno</label>
            <input type="text" id="apellidoMaterno" name="apellidoMaterno" value="<?php echo htmlspecialchars($usuario['ApellidoMaterno']); ?>">
        </div>
        <div class="form-group">
            <label for="correo">Correo Institucional</label>
            <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($usuario['CorreoInstitucional']); ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Nueva Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Dejar en blanco para no cambiar">
        </div>
        <div class="form-group">
            <label for="idRol">Rol de Usuario</label>
            <select id="idRol" name="idRol" required>
                <option value="1" <?php echo ($usuario['IdRol'] == 1) ? 'selected' : ''; ?>>Estudiante</option> 
                <option value="2" <?php echo ($usuario['IdRol'] == 2) ? 'selected' : ''; ?>>Profesional</option>
                <option value="3" <?php echo ($usuario['IdRol'] == 3) ? 'selected' : ''; ?>>Administrador</option>
            </select>
        </div>
        <button type="submit">Guardar Cambios</button>
    </form>
</div>