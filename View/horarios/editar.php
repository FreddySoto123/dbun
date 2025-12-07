<div class="header">
    <h1>Editar Día de Atención</h1>
</div>

<div class="card">
    <h2>Modificar día de atención</h2>

    <form action="index.php?controller=Horario&action=actualizar" method="POST">
        <input type="hidden" name="idDiasAtencion" value="<?php echo htmlspecialchars($horario['idDiasAtencion']); ?>">

        <div class="form-group">
            <label for="idProfesional">Profesional</label>
            <select id="idProfesional" name="idProfesional" required>
                <?php foreach ($profesionales as $profesional): ?>
                    <option value="<?php echo $profesional['IdProfesional']; ?>" <?php echo ($horario['IdProfesional'] == $profesional['IdProfesional']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($profesional['Nombres'] . ' ' . $profesional['ApellidoPaterno']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="diaSemana">Día de la Semana</label>
            <select id="diaSemana" name="diaSemana" required>
                <option value="Lunes" <?php echo ($horario['DiaSemana'] == 'Lunes') ? 'selected' : ''; ?>>Lunes</option>
                <option value="Martes" <?php echo ($horario['DiaSemana'] == 'Martes') ? 'selected' : ''; ?>>Martes</option>
                <option value="Miércoles" <?php echo ($horario['DiaSemana'] == 'Miércoles') ? 'selected' : ''; ?>>Miércoles</option>
                <option value="Jueves" <?php echo ($horario['DiaSemana'] == 'Jueves') ? 'selected' : ''; ?>>Jueves</option>
                <option value="Viernes" <?php echo ($horario['DiaSemana'] == 'Viernes') ? 'selected' : ''; ?>>Viernes</option>
                <option value="Sábado" <?php echo ($horario['DiaSemana'] == 'Sábado') ? 'selected' : ''; ?>>Sábado</option>
                <option value="Domingo" <?php echo ($horario['DiaSemana'] == 'Domingo') ? 'selected' : ''; ?>>Domingo</option>
            </select>
        </div>
        <div class="form-group">
            <label for="activo">Estado</label>
            <select id="activo" name="activo" required>
                <option value="1" <?php echo ($horario['Activo'] == 1) ? 'selected' : ''; ?>>Activo</option>
                <option value="0" <?php echo ($horario['Activo'] == 0) ? 'selected' : ''; ?>>Inactivo</option>
            </select>
        </div>
        <button type="submit">Guardar Cambios</button>
    </form>
</div>