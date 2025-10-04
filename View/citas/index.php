<div class="header">
    <h1>Gestión de Citas</h1>
</div>

<div class="card">
    <h2>Añadir Nueva Cita</h2>

    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars(urldecode($error_message)); ?></div>
    <?php endif; ?>
    <?php if (!empty($success_message)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars(urldecode($success_message)); ?></div>
    <?php endif; ?>

    <form action="index.php?controller=cita&action=crear" method="POST">
        <div class="form-group">
            <label for="fecha_hora">Fecha y Hora</label>
            <input type="datetime-local" id="fecha_hora" name="fecha_hora" required>
        </div>
        <div class="form-group">
            <label for="tipo_consulta">Tipo de Consulta</label>
            <select id="tipo_consulta" name="tipo_consulta" required>
                <option value="" disabled selected>Seleccionar tipo...</option>
                <option value="Médica">Médica</option>
                <option value="Psicológica">Psicológica</option>
            </select>
        </div>
        <div class="form-group">
            <label for="estado">Estado de la Cita</label>
            <select id="estado" name="estado" required>
                <option value="" disabled selected>Seleccionar estado...</option>
                <option value="Confirmada">Confirmada</option>
                <option value="Cancelada">Cancelada</option>
                <option value="Atendida">Atendida</option>
            </select>
        </div>
        <div class="form-group">
            <label for="estudiante_id">ID del Estudiante</label>
            <input type="number" id="estudiante_id" name="estudiante_id" placeholder="Ej: 101" required>
        </div>
        <div class="form-group">
            <label for="personal_salud_id">ID del Personal de Salud</label>
            <input type="number" id="personal_salud_id" name="personal_salud_id" placeholder="Ej: 202" required>
        </div>
        <button type="submit">Añadir Cita</button>
    </form>
</div>

<div class="card">
    <h2>Lista de Citas</h2>
    <table>
        <thead>
            <tr>
                <th>Fecha y Hora</th>
                <th>Tipo de Consulta</th>
                <th>Estado</th>
                <th>Estudiante ID</th>
                <th>Personal Salud ID</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($citas as $cita): ?>
            <tr>
                <td><?php echo htmlspecialchars($cita['fecha_hora']); ?></td>
                <td><?php echo htmlspecialchars($cita['tipo_consulta']); ?></td>
                <td><?php echo htmlspecialchars($cita['estado']); ?></td>
                <td><?php echo htmlspecialchars($cita['estudiante_id']); ?></td>
                <td><?php echo htmlspecialchars($cita['personal_salud_id']); ?></td>
                <td>
                    <a href="index.php?controller=cita&action=eliminar&id=<?php echo $cita['id_cita']; ?>" class="delete-btn" onclick="return confirm('¿Estás seguro de que deseas eliminar esta cita?');">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>