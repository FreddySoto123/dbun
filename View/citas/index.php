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

    <form action="index.php?controller=Cita&action=crear" method="POST">
        <div class="form-group">
            <label for="fechaCita">Fecha de la Cita</label>
            <input type="date" id="fechaCita" name="fechaCita" required>
        </div>
        <div class="form-group">
            <label for="horaCita">Hora de la Cita</label>
            <input type="time" id="horaCita" name="horaCita" required>
        </div>
        <div class="form-group">
            <label for="tipoConsulta">Tipo de Consulta</label>
            <select id="tipoConsulta" name="tipoConsulta" required>
                <option value="" disabled selected>Seleccionar tipo...</option>
                <option value="Médica">Médica</option>
                <option value="Psicológica">Psicológica</option>
            </select>
        </div>
<div class="form-group">
            <label for="estado">Estado de la Cita</label>
            <select id="estado" name="estado" required>
                <option value="" disabled selected>Seleccionar estado...</option>
                <option value="Reservado">Reservado (Confirmada)</option>
                <option value="Cancelado">Cancelado</option>
                <option value="Atendido">Atendido</option>
            </select>
        </div>
        <!-- ===== CAMPO DE ESTUDIANTE MEJORADO ===== -->
        <div class="form-group">
            <label for="idUsuario">Estudiante</label>
            <select id="idUsuario" name="idUsuario" required>
                <option value="" disabled selected>Seleccionar un estudiante...</option>
                <?php foreach ($estudiantes as $estudiante): ?>
                    <option value="<?php echo $estudiante['idUsuario']; ?>">
                        <?php echo htmlspecialchars($estudiante['Nombres'] . ' ' . $estudiante['ApellidoPaterno']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- ===== CAMPO DE PROFESIONAL MEJORADO ===== -->
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
        
        <button type="submit">Añadir Cita</button>
    </form>
</div>

<div class="card">
    <h2>Lista de Citas</h2>
    <table>
        <thead>
            <tr>
                <th>Fecha y Hora</th>
                <th>Estudiante</th>
                <th>Profesional</th>
                <th>Tipo de Consulta</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
    <?php foreach ($citas as $cita): ?>
    <tr>
        <td>
            <?php 
            $fecha = $cita['FechaCita'] ?? '';
            $hora = $cita['HoraCita'] ?? '';
            echo htmlspecialchars($fecha . ' ' . $hora); 
            ?>
        </td>
        <td>
            <?php 
            $nombreEstudiante = $cita['estudiante_nombre'] ?? '';
            $apellidoEstudiante = $cita['estudiante_apellido'] ?? '';
            echo htmlspecialchars(trim($nombreEstudiante . ' ' . $apellidoEstudiante)); 
            ?>
        </td>
        <td>
            <?php 
            $nombreProfesional = $cita['profesional_nombre'] ?? '';
            $apellidoProfesional = $cita['profesional_apellido'] ?? '';
            echo htmlspecialchars(trim($nombreProfesional . ' ' . $apellidoProfesional)); 
            ?>
        </td>
        <td>
            <?php echo htmlspecialchars($cita['TipoConsulta'] ?? ''); ?>
        </td>
        <td>
            <?php 
            $estado = $cita['Estado'] ?? 'No definido';
            if (empty(trim($estado))) {
                $estado = 'No definido';
            }
            
            $clase = 'status-';
            if ($estado == 'Confirmada') $clase .= 'confirmada';
            elseif ($estado == 'Atendida') $clase .= 'atendida';
            elseif ($estado == 'Cancelada') $clase .= 'cancelada';
            else $clase = ''; 
            ?>
            <span class="status <?php echo $clase; ?>">
                <?php echo htmlspecialchars($estado); ?>
            </span>
        </td>
        <td>
            <?php if (isset($cita['idCita'])): ?>
                <a href="index.php?controller=Cita&action=eliminar&id=<?php echo $cita['idCita']; ?>" class="delete-btn" onclick="return confirm('¿Estás seguro de que deseas eliminar esta cita?');">
                    Eliminar
                </a>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>
    </table>
</div>