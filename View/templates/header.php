<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle ?? 'Dashboard'); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            <?php
            // =========================================================
            // LÓGICA PARA MOSTRAR EL TÍTULO DEL DASHBOARD SEGÚN EL ROL
            // =========================================================
            $dashboardTitle = 'Mi Dashboard'; // Título por defecto
            if (isset($_SESSION['user_role'])) {
                if ($_SESSION['user_role'] == 3) { // Administrador
                    $dashboardTitle = 'Admin Dashboard';
                } elseif ($_SESSION['user_role'] == 2) { // Profesional
                    $dashboardTitle = 'Portal Profesional';
                }
                // Aquí podrías añadir un 'elseif' para el rol de Estudiante en el futuro
            }
            ?>
            <h2><?php echo $dashboardTitle; ?></h2>
        </div>
        
        <ul>
            <?php
            // =========================================================
            // LÓGICA PARA MOSTRAR LOS ENLACES DEL MENÚ SEGÚN EL ROL
            // =========================================================
            if (isset($_SESSION['user_role'])):
                // --- MENÚ PARA EL ADMINISTRADOR (Rol 3) ---
                if ($_SESSION['user_role'] == 3):
            ?>
                <li><a href="<?php echo BASE_URL; ?>/index.php?controller=Dashboard" class="<?php echo ($activePage == 'dashboard') ? 'active' : ''; ?>"><i class="fas fa-tachometer-alt"></i><span>Inicio</span></a></li>
                <li><a href="<?php echo BASE_URL; ?>/index.php?controller=Usuario" class="<?php echo ($activePage == 'usuarios') ? 'active' : ''; ?>"><i class="fas fa-users"></i><span>Gestión de Usuarios</span></a></li>
                <li><a href="<?php echo BASE_URL; ?>/index.php?controller=Cita" class="<?php echo ($activePage == 'citas') ? 'active' : ''; ?>"><i class="fas fa-calendar-check"></i><span>Gestión de Citas</span></a></li>
                <li><a href="<?php echo BASE_URL; ?>/index.php?controller=Horario" class="<?php echo ($activePage == 'horarios') ? 'active' : ''; ?>"><i class="fas fa-clock"></i><span>Conf. de Horarios</span></a></li>

            <?php
                // --- MENÚ PARA EL PROFESIONAL (Rol 2) ---
                elseif ($_SESSION['user_role'] == 2):
            ?>
                <li><a href="<?php echo BASE_URL; ?>/index.php?controller=Professional&action=index" class="<?php echo ($activePage == 'dashboard_profesional') ? 'active' : ''; ?>"><i class="fas fa-calendar-day"></i><span>Agenda del Día</span></a></li>
<li><a href="<?php echo BASE_URL; ?>/index.php?controller=Professional&action=appointments" class="<?php echo ($activePage == 'mis_citas') ? 'active' : ''; ?>"><i class="fas fa-calendar-alt"></i><span>Mis Citas</span></a></li>                <li><a href="<?php echo BASE_URL; ?>/index.php?controller=Professional&action=profile" class="<?php echo ($activePage == 'profile') ? 'active' : ''; ?>"><i class="fas fa-user-cog"></i><span>Mi Perfil</span></a></li>
            
            <?php
                // --- Aquí podrías añadir el menú para el Estudiante con 'elseif ($_SESSION['user_role'] == 1):' ---
                endif;
            endif;
            ?>
        </ul>
        
        <ul style="margin-top: auto;">
             <li><a href="<?php echo BASE_URL; ?>/index.php?controller=Login&action=logout"><i class="fas fa-sign-out-alt"></i><span>Cerrar Sesión</span></a></li>
        </ul>
    </div>

    <main class="main-wrapper">
        <div class="content">