<div class="header">
    <h1>Configuración de Horarios</h1>
</div>

<div class="card">
    <h2>Añadir Nuevo Horario</h2>

    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars(urldecode($error_message)); ?></div>
    <?php endif; ?>
    <?php if (!empty($success_message)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars(urldecode($success_message)); ?></div>
    <?php endif; ?>

    <form action="index.php?controller=horario&action=crear" method="POST">
        <div class="form-group">
            <label for="medico_id">ID del Médico</label>
            <input type="number" id="medico_id" name="medico_id" placeholder="Ej: 202" required>
        </div>
        <div class="form-group">
            <label for="fecha_inicio">Inicio del Horario</label>
            <input type="datetime-local" id="fecha_inicio" name="fecha_inicio" required>
        </div>
        <div class="form-group">
            <label for="fecha_fin">Fin del Horario</label>
            <input type="datetime-local" id="fecha_fin" name="fecha_fin" required>
        </div>
        <div class="form-group">
            <label for="estado">Estado del Horario</label>
            <select id="estado" name="estado" required>
                <option value="" disabled selected>Seleccionar estado...</option>
                <option value="Disponible">Disponible</option>
                <option value="No Disponible">No Disponible</option>
            </select>
        </div>
        <button type="submit">Añadir Horario</button>
    </form>
</div>

<div class="card">
    <h2>Lista de Horarios</h2>
    <table>
        <thead>
            <tr>
                <th>Médico ID</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($horarios as $horario): ?>
            <tr>
                <td><?php echo htmlspecialchars($horario['medico_id']); ?></td>
                <td><?php echo htmlspecialchars($horario['fecha_inicio']); ?></td>
                <td><?php echo htmlspecialchars($horario['fecha_fin']); ?></td>
                <td><?php echo htmlspecialchars($horario['estado']); ?></td>
                <td>
                    <a href="index.php?controller=horario&action=eliminar&id=<?php echo $horario['id_horario']; ?>" class="delete-btn" onclick="return confirm('¿Estás seguro de que deseas eliminar este horario?');">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>