<div class="header">
    <h1>Editar Cita</h1>
</div>

<div class="card">
    <h2>Modificar datos de la cita</h2>

    <form action="index.php?controller=Cita&action=actualizar" method="POST">
        <input type="hidden" name="idCita" value="<?php echo htmlspecialchars($cita['idCita']); ?>">

        <div class="form-group">
            <label for="fechaCita">Fecha de la Cita</label>
            <input type="date" id="fechaCita" name="fechaCita" value="<?php echo htmlspecialchars($cita['FechaCita']); ?>" required>
        </div>
        <div class="form-group">
            <label for="horaCita">Hora de la Cita</label>
            <input type="time" id="horaCita" name="horaCita" value="<?php echo htmlspecialchars($cita['HoraCita']); ?>" required>
        </div>
        <div class="form-group">
            <label for="tipoConsulta">Tipo de Consulta</label>
            <select id="tipoConsulta" name="tipoConsulta" required>
                <option value="Médica" <?php echo ($cita['TipoConsulta'] == 'Médica') ? 'selected' : ''; ?>>Médica</option>
                <option value="Psicológica" <?php echo ($cita['TipoConsulta'] == 'Psicológica') ? 'selected' : ''; ?>>Psicológica</option>
            </select>
        </div>
        <div class="form-group">
            <label for="estado">Estado de la Cita</label>
            <select id="estado" name="estado" required>
                <option value="Reservado" <?php echo ($cita['Estado'] == 'Reservado') ? 'selected' : ''; ?>>Reservado</option>
                <option value="Atendido" <?php echo ($cita['Estado'] == 'Atendido') ? 'selected' : ''; ?>>Atendido</option>
                <option value="Cancelado" <?php echo ($cita['Estado'] == 'Cancelado') ? 'selected' : ''; ?>>Cancelado</option>
            </select>
        </div>
        <div class="form-group">
            <label for="idUsuario">Estudiante</label>
            <select id="idUsuario" name="idUsuario" required>
                <?php foreach ($estudiantes as $estudiante): ?>
                    <option value="<?php echo $estudiante['idUsuario']; ?>" <?php echo ($cita['IdUsuario'] == $estudiante['idUsuario']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($estudiante['Nombres'] . ' ' . $estudiante['ApellidoPaterno']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="idProfesional">Profesional</label>
            <select id="idProfesional" name="idProfesional" required>
                <?php foreach ($profesionales as $profesional): ?>
                    <option value="<?php echo $profesional['IdProfesional']; ?>" <?php echo ($cita['IdProfesional'] == $profesional['IdProfesional']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($profesional['Nombres'] . ' ' . $profesional['ApellidoPaterno']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <button type="submit">Guardar Cambios</button>
    </form>
</div>