<div class="header">
    <h1>Bienvenido al Dashboard</h1>
</div>

<!-- Contenedor de Estadísticas Principales -->
<div class="stats-container">
    <div class="stat-box">
        <h3>Usuarios Registrados</h3>
        <p class="stat-number"><?php echo $totalUsuarios; ?></p>
    </div>
    <div class="stat-box">
        <h3>Citas Agendadas</h3>
        <p class="stat-number"><?php echo $totalCitas; ?></p>
    </div>
    <div class="stat-box">
        <h3>Horarios Configurados</h3>
        <p class="stat-number"><?php echo $totalHorarios; ?></p>
    </div>
</div>

<!-- Contenedor para los Gráficos de Pastel -->
<div class="charts-container">
    <div class="chart-box">
        <h3>Distribución de Citas por Tipo</h3>
        <div class="chart-wrapper">
            <canvas id="citasPorTipoChart"></canvas>
        </div>
    </div>
    <div class="chart-box">
        <h3>Usuarios Registrados por Tipo</h3>
        <div class="chart-wrapper">
            <canvas id="usuariosPorTipoChart"></canvas>
        </div>
    </div>
</div>

<!-- ===== NUEVO: CONTENEDOR PARA EL GRÁFICO DE BARRAS ===== -->
<div class="full-width-chart-container">
    <div class="chart-box">
        <h3>Actividad de Citas (Últimos 7 Días)</h3>
        <div class="chart-wrapper">
            <canvas id="citasRecientesChart"></canvas>
        </div>
    </div>
</div>
<!-- ======================================================== -->

<!-- Tabla de Últimas Citas Reservadas -->
<div class="card">
    <h2>Últimas Citas Reservadas</h2>
    <!-- ... Botones de exportación ... -->
    <div class="export-buttons">
        <a href="index.php?controller=Dashboard&action=exportarPDF" class="export-btn btn-pdf"><i class="fas fa-file-pdf"></i> Exportar a PDF</a>
        <a href="index.php?controller=Dashboard&action=exportarExcel" class="export-btn btn-excel"><i class="fas fa-file-excel"></i> Exportar a Excel</a>
    </div>
    <!-- ... Tu tabla de citas ... -->
    <table>
        <thead>
            <tr> <th>Fecha y Hora</th> <th>Estudiante</th> <th>Tipo de Consulta</th> <th>Estado</th> </tr>
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

<!-- JavaScript para los Gráficos -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Paleta de colores (la misma que antes)
    const colorPalette = { blue: 'rgba(37, 99, 235, 0.8)', gold: 'rgba(202, 138, 4, 0.8)', slate: 'rgba(71, 85, 105, 0.8)', sky: 'rgba(125, 211, 252, 0.8)', rose: 'rgba(251, 113, 133, 0.8)' };
    const colorBorders = { blue: 'rgba(37, 99, 235, 1)', gold: 'rgba(202, 138, 4, 1)', slate: 'rgba(71, 85, 105, 1)', sky: 'rgba(125, 211, 252, 1)', rose: 'rgba(251, 113, 133, 1)' };

    // --- GRÁFICO 1: CITAS POR TIPO (Doughnut) ---
    const citasData = <?php echo $citasPorTipoJson; ?>;
    new Chart(document.getElementById('citasPorTipoChart'), {
        type: 'doughnut',
        data: {
            labels: citasData.map(item => item.TipoConsulta),
            datasets: [{ label: 'Citas', data: citasData.map(item => item.cantidad), backgroundColor: [colorPalette.sky, colorPalette.rose], borderColor: [colorBorders.sky, colorBorders.rose], borderWidth: 1, hoverOffset: 4 }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
    });

    // --- GRÁFICO 2: USUARIOS POR TIPO (Pie) ---
    const usuariosData = <?php echo $usuariosPorTipoJson; ?>;
    new Chart(document.getElementById('usuariosPorTipoChart'), {
        type: 'pie',
        data: {
            labels: usuariosData.map(item => item.rol_nombre),
            datasets: [{ label: 'Usuarios', data: usuariosData.map(item => item.cantidad), backgroundColor: [colorPalette.slate, colorPalette.sky, colorPalette.gold], borderColor: [colorBorders.slate, colorBorders.sky, colorBorders.gold], borderWidth: 1, hoverOffset: 4 }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
    });

    // --- NUEVO GRÁFICO 3: ACTIVIDAD RECIENTE (Bar) ---
    const citasRecientesData = <?php echo $citasRecientesJson; ?>;
    new Chart(document.getElementById('citasRecientesChart'), {
        type: 'bar',
        data: {
            labels: citasRecientesData.labels,
            datasets: [{
                label: 'Nuevas Citas',
                data: citasRecientesData.data,
                backgroundColor: colorPalette.blue,
                borderColor: colorBorders.blue,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false // La leyenda no es necesaria en un gráfico de una sola serie
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1 // Asegura que el eje Y solo muestre números enteros
                    }
                }
            }
        }
    });
});
</script>

<!-- CSS (con nuevos estilos añadidos) -->
<style>
/* ... (estilos existentes) ... */
.stat-box { color: white; background: linear-gradient(135deg, #2d3748, #4a5568); }
.stat-box h3 { font-size: 1rem; font-weight: normal; opacity: 0.8; }
.stat-number { font-size: 2.5rem; font-weight: bold; margin: 10px 0 0; }
.charts-container { display: flex; gap: 20px; margin: 20px 0; flex-wrap: wrap; }
.chart-box { background-color: white; border-radius: 8px; padding: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); text-align: center; }
.chart-box h3 { margin-bottom: 20px; color: #4a5568; }
.chart-wrapper { position: relative; height: 300px; }
.charts-container .chart-box { flex: 1; min-width: 320px; }
/* ===== NUEVO ESTILO PARA EL CONTENEDOR DEL GRÁFICO DE BARRAS ===== */
.full-width-chart-container { margin: 20px 0; }
.full-width-chart-container .chart-box { width: 100%; }
/* =================================================================== */
.export-buttons { display: flex; gap: 10px; margin-bottom: 20px; justify-content: flex-end; }
.export-btn { padding: 10px 15px; border-radius: 5px; text-decoration: none; color: white; font-weight: bold; display: inline-flex; align-items: center; gap: 8px; border: none; cursor: pointer; }
.btn-pdf { background-color: #d9534f; }
.btn-excel { background-color: #5cb85c; }
</style>