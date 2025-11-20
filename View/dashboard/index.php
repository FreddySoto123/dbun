<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin</title>
    <style>
        /* Estilos Generales */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-top: 20px;
        }

        .header h1 {
            font-size: 2rem;
            font-weight: bold;
        }

        .stats-container, .extra-stats-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin: 20px;
            flex-wrap: wrap;
        }

        .stat-box {
            background-color: #F2F6F9;
            border-radius: 8px;
            padding: 20px;
            margin: 10px;
            flex: 1 1 30%;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        .extra-stats-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        ul {
            list-style-type: none;
            padding-left: 0;
        }

        ul li {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        /* ========= NUEVOS ESTILOS PARA LOS BOTONES DE EXPORTACIÓN ========= */
        .export-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            justify-content: flex-end; /* Alinea los botones a la derecha */
        }

        .export-btn {
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-pdf {
            background-color: #d9534f; /* Rojo */
        }
        .btn-pdf:hover {
            background-color: #c9302c;
        }

        .btn-excel {
            background-color: #5cb85c; /* Verde */
        }
        .btn-excel:hover {
            background-color: #4cae4c;
        }
        /* =================================================================== */
    </style>
</head>
<body>
    <div class="header">
        <h1>Bienvenido al Dashboard</h1>
    </div>

    <div class="stats-container">
        <div class="stat-box">
            <h3>Usuarios Registrados</h3>
            <p><?php echo $totalUsuarios; ?></p>
        </div>
        <div class="stat-box">
            <h3>Citas Agendadas</h3>
            <p><?php echo $totalCitas; ?></p>
        </div>
        <div class="stat-box">
            <h3>Horarios Configurados</h3>
            <p><?php echo $totalHorarios; ?></p>
        </div>
    </div>

    <div class="extra-stats-container">
        <div class="stat-box">
            <h3>Distribución de Citas por tipo</h3>
            <ul>
                <?php foreach ($citasPorTipo as $tipo) : ?>
                    <li><?php echo htmlspecialchars($tipo['TipoConsulta']); ?>: <?php echo $tipo['cantidad']; ?> citas</li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="stat-box">
            <h3>Usuarios Registrados por tipo</h3>
            <ul>
                <?php foreach ($usuariosPorTipo as $usuario) : ?>
                    <li><?php echo htmlspecialchars($usuario['rol_nombre']); ?>: <?php echo $usuario['cantidad']; ?> usuarios</li>
                <?php endforeach; ?>
            </ul>
        </div>

    </div>

    <div class="card">
        <h2>Últimas Citas Reservadas</h2>

        <!-- ========= NUEVOS BOTONES DE EXPORTACIÓN ========= -->
        <div class="export-buttons">
            <a href="index.php?controller=Dashboard&action=exportarPDF" class="export-btn btn-pdf">
                <i class="fas fa-file-pdf"></i> Exportar a PDF
            </a>
            <a href="index.php?controller=Dashboard&action=exportarExcel" class="export-btn btn-excel">
                <i class="fas fa-file-excel"></i> Exportar a Excel
            </a>
        </div>
        <!-- =============================================== -->

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
</body>
</html>