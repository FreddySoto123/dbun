<div class="header"><h1>Bienvenido al Dashboard</h1></div>
<div class="stats-container">
    <div class="stat-box"><h3>Usuarios Registrados</h3><p><?php echo $totalUsuarios; ?></p></div>
    <div class="stat-box"><h3>Citas Agendadas</h3><p><?php echo $totalCitas; ?></p></div>
    <div class="stat-box"><h3>Horarios Configurados</h3><p><?php echo $totalHorarios; ?></p></div>
</div>
<div class="card">
    <h2>Últimas Citas Reservadas</h2>
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
            <?php foreach ($ultimasCitas as $cita): ?>
            <tr>
                <td><?php echo htmlspecialchars($cita['FechaCita'] . ' ' . $cita['HoraCita']); ?></td>
                <td><?php echo htmlspecialchars($cita['Nombres'] . ' ' . $cita['ApellidoPaterno']); ?></td>
                <td><?php echo htmlspecialchars($cita['TipoConsulta']); ?></td>
                <td><?php echo htmlspecialchars($cita['Estado']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>