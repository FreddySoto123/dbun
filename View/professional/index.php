<div class="header">
    <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h1>
</div>

<div class="card">
    <h2>Agenda para Hoy (<?php echo date('d/m/Y'); ?>)</h2>

    <?php if (empty($citasHoy)): ?>
        <p>No tienes citas programadas para hoy.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Hora</th>
                    <th>Estudiante</th>
                    <th>Tipo de Consulta</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($citasHoy as $cita): ?>
                <tr>
                    <td><?php echo htmlspecialchars(date('H:i', strtotime($cita['HoraCita']))); ?></td>
                    <td><?php echo htmlspecialchars(($cita['estudiante_nombre'] ?? '') . ' ' . ($cita['estudiante_apellido'] ?? '')); ?></td>
                    <td><?php echo htmlspecialchars($cita['TipoConsulta'] ?? ''); ?></td>
                    <td>
                        <?php 
                        $estado = $cita['Estado'] ?? 'No definido';
                        $clase = 'status-';
                        if ($estado == 'Reservado') $clase .= 'confirmada'; // Usamos la clase de 'confirmada' para 'reservado'
                        else $clase .= strtolower($estado);
                        ?>
                        <span class="status <?php echo $clase; ?>">
                            <?php echo htmlspecialchars($estado); ?>
                        </span>
                    </td>
                    <td>
                        <a href="#" class="delete-btn" style="background-color: #084298;">Atender</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>