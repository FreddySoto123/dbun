<div class="header">
    <h1>Mis Citas</h1>
    <p>Aquí puedes ver tus citas programadas y tu historial de atenciones.</p>
</div>

<!-- Sección de Próximas Citas -->
<div class="card">
    <h2>Próximas Citas</h2>

    <?php if (empty($upcomingAppointments)): ?>
        <p>No tienes próximas citas programadas.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Fecha y Hora</th>
                    <th>Estudiante</th>
                    <th>Tipo de Consulta</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($upcomingAppointments as $cita): ?>
                <tr>
                    <td><?php echo htmlspecialchars($cita['FechaCita'] . ' ' . date('H:i', strtotime($cita['HoraCita']))); ?></td>
                    <td><?php echo htmlspecialchars(($cita['estudiante_nombre'] ?? '') . ' ' . ($cita['estudiante_apellido'] ?? '')); ?></td>
                    <td><?php echo htmlspecialchars($cita['TipoConsulta'] ?? ''); ?></td>
                    <td>
                        <?php 
                        $estado = $cita['Estado'] ?? 'No definido';
                        $clase = 'status-' . strtolower($estado);
                        if ($estado == 'Reservado') $clase = 'status-confirmada';
                        ?>
                        <span class="status <?php echo $clase; ?>">
                            <?php echo htmlspecialchars($estado); ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<!-- Sección de Historial de Citas -->
<div class="card">
    <h2>Historial de Citas</h2>

    <?php if (empty($pastAppointments)): ?>
        <p>Aún no tienes un historial de citas.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Fecha y Hora</th>
                    <th>Estudiante</th>
                    <th>Tipo de Consulta</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pastAppointments as $cita): ?>
                <tr>
                    <td><?php echo htmlspecialchars($cita['FechaCita'] . ' ' . date('H:i', strtotime($cita['HoraCita']))); ?></td>
                    <td><?php echo htmlspecialchars(($cita['estudiante_nombre'] ?? '') . ' ' . ($cita['estudiante_apellido'] ?? '')); ?></td>
                    <td><?php echo htmlspecialchars($cita['TipoConsulta'] ?? ''); ?></td>
                    <td>
                        <?php 
                        $estado = $cita['Estado'] ?? 'No definido';
                        $clase = 'status-' . strtolower($estado);
                        if ($estado == 'Atendido') $clase = 'status-atendida'; // Un estilo específico para atendidas
                        ?>
                        <span class="status <?php echo $clase; ?>">
                            <?php echo htmlspecialchars($estado); ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>