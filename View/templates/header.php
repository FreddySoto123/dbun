<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> - Admin Dashboard</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/style.css">
    <style>
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 8px; font-weight: 500; text-align: center; }
        .alert-danger { background-color: #f8d7da; color: #a83232; border: 1px solid #f5c6cb; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>Admin Dashboard</h2>
        </div>
        <ul>
            <li><a href="<?php echo BASE_URL; ?>/index.php?controller=Dashboard" class="<?php echo ($activePage == 'dashboard') ? 'active' : ''; ?>">Inicio</a></li>
            <li><a href="<?php echo BASE_URL; ?>/index.php?controller=Usuario" class="<?php echo ($activePage == 'usuarios') ? 'active' : ''; ?>">Gestión de Usuarios</a></li>
            <li><a href="<?php echo BASE_URL; ?>/index.php?controller=Cita" class="<?php echo ($activePage == 'citas') ? 'active' : ''; ?>">Gestión de Citas</a></li>
            <li><a href="<?php echo BASE_URL; ?>/index.php?controller=Horario" class="<?php echo ($activePage == 'horarios') ? 'active' : ''; ?>">Configuración de Horarios</a></li>
        </ul>
    </div>

    <!-- ===== NUEVO CONTENEDOR PRINCIPAL ===== -->
    <main class="main-wrapper">
        <div class="content">