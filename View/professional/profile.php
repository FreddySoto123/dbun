<div class="header">
    <h1>Mi Perfil</h1>
</div>

<div class="card">
    <h2>Editar Información del Perfil</h2>
    <?php if (!empty($success_message)): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <form action="<?php echo BASE_URL; ?>/index.php?controller=Professional&action=profile" method="POST">
        
        <h4>Información Personal</h4>
        <div class="form-group">
            <label for="nombres">Nombres</label>
            <input type="text" id="nombres" name="nombres" value="<?php echo htmlspecialchars($professionalData['Nombres'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="apellidoPaterno">Apellido Paterno</label>
            <input type="text" id="apellidoPaterno" name="apellidoPaterno" value="<?php echo htmlspecialchars($professionalData['ApellidoPaterno'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="apellidoMaterno">Apellido Materno</label>
            <input type="text" id="apellidoMaterno" name="apellidoMaterno" value="<?php echo htmlspecialchars($professionalData['ApellidoMaterno'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="correo">Correo Institucional (No editable)</label>
            <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($professionalData['CorreoInstitucional'] ?? ''); ?>" readonly disabled>
        </div>
        <h4>Información Profesional</h4>
        <div class="form-group">
            <label for="especialidad">Especialidad</label>
            <input type="text" id="especialidad" name="especialidad" value="<?php echo htmlspecialchars($professionalData['Especialidad'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="horarioInicio">Horario de Inicio General</label>
            <input type="time" id="horarioInicio" name="horarioInicio" value="<?php echo htmlspecialchars($professionalData['HorarioInicio'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="horarioFin">Horario de Fin General</label>
            <input type="time" id="horarioFin" name="horarioFin" value="<?php echo htmlspecialchars($professionalData['HorarioFin'] ?? ''); ?>" required>
        </div>

        <button type="submit">Guardar Cambios</button>
    </form>
</div>
