<div class="header">
    <h1>Configuración de Horarios</h1>
</div>

<div class="card">
    <h2>Añadir Día de Atención</h2>

    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars(urldecode($error_message)); ?></div>
    <?php endif; ?>
    <?php if (!empty($success_message)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars(urldecode($success_message)); ?></div>
    <?php endif; ?>

    <form action="index.php?controller=Horario&action=crear" method="POST">
                <div class="form-group">
            <label for="idProfesional">Profesional</label>
            <select id="idProfesional" name="idProfesional" required>
                <option value="" disabled selected>Seleccionar un profesional...</option>
                <?php foreach ($profesionales as $profesional): ?>
                    <option value="<?php echo $profesional['IdProfesional']; ?>">
                        <?php echo htmlspecialchars($profesional['Nombres'] . ' ' . $profesional['ApellidoPaterno']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="diaSemana">Día de la Semana</label>
            <select id="diaSemana" name="diaSemana" required>
                <option value="" disabled selected>Seleccionar día...</option>
                <option value="Lunes">Lunes</option>
                <option value="Martes">Martes</option>
                <option value="Miércoles">Miércoles</option>
                <option value="Jueves">Jueves</option>
                <option value="Viernes">Viernes</option>
                <option value="Sábado">Sábado</option>
                <option value="Domingo">Domingo</option>
            </select>
        </div>
        <div class="form-group">
            <label for="activo">Estado</label>
            <select id="activo" name="activo" required>
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
            </select>
        </div>
        <button type="submit">Añadir Día de Atención</button>
    </form>
</div>

<div class="card">
    <h2>Lista de Horarios de Atención</h2>
    <table>
        <thead>
            <tr>
                <th>Profesional</th>
                <th>Día de la Semana</th>
                <th>Horario General</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($horarios as $horario): ?>
            <tr>
                <td><?php echo htmlspecialchars($horario['profesional_nombre'] . ' ' . $horario['profesional_apellido']); ?></td>
                <td><?php echo htmlspecialchars($horario['DiaSemana']); ?></td>
                <td><?php echo htmlspecialchars($horario['HorarioInicio'] . ' - ' . $horario['HorarioFin']); ?></td>
                <td>
                    <?php 
                    $estado = $horario['Activo'] ? 'Activo' : 'Inactivo';
                    $clase = $horario['Activo'] ? 'status-confirmada' : 'status-cancelada';
                    ?>
                    <span class="status <?php echo $clase; ?>">
                        <?php echo $estado; ?>
                    </span>
                </td>
                <td>
                   <button class="edit-btn modal-trigger-btn" 
                            data-id="<?php echo $horario['idDiasAtencion']; ?>" 
                            data-type="horario">
                        Editar
                    </button>
                    <a href="index.php?controller=Horario&action=eliminar&id=<?php echo $horario['idDiasAtencion']; ?>" class="delete-btn" onclick="return confirm('¿Estás seguro de que deseas eliminar este día de atención?');">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>