<div class="header">
    <h1>Gestión de Usuarios</h1>
</div>

<div class="card">
    <h2>Añadir Nuevo Usuario</h2>
    
    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars(urldecode($error_message)); ?></div>
    <?php endif; ?>
    <?php if (!empty($success_message)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars(urldecode($success_message)); ?></div>
    <?php endif; ?>

    <!-- ===================================== -->
    <!-- ESTE ES EL FORMULARIO QUE FALTABA -->
    <!-- ===================================== -->
    <form action="index.php?controller=Usuario&action=crear" method="POST">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" placeholder="Ej: Juan" required>
        </div>
        <div class="form-group">
            <label for="apellido">Apellido</label>
            <input type="text" id="apellido" name="apellido" placeholder="Ej: Pérez" required>
        </div>
        <div class="form-group">
            <label for="correo">Correo Electrónico</label>
            <input type="email" id="correo" name="correo" placeholder="Ej: usuario@correo.com" required>
        </div>
        <div class="form-group">
            <label for="rol_id">Rol de Usuario</label>
            <select id="rol_id" name="rol_id" required>
                <option value="" disabled selected>Seleccionar un rol...</option>
                <option value="1">Estudiante</option>
                <option value="2">Personal de Salud</option>
                <option value="3">Administrador</option>
            </select>
        </div>
        <button type="submit">Añadir Usuario</button>
    </form>
</div>

<div class="card">
    <h2>Lista de Usuarios</h2>
    
    <!-- ===================================== -->
    <!-- ESTA ES LA TABLA QUE FALTABA -->
    <!-- ===================================== -->
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                <td><?php echo htmlspecialchars($usuario['apellido']); ?></td>
                <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                <td><?php echo $usuario['rol_id'] == 1 ? 'Estudiante' : ($usuario['rol_id'] == 2 ? 'Personal de Salud' : 'Administrador'); ?></td>
                <td>
                    <a href="index.php?controller=Usuario&action=eliminar&id=<?php echo $usuario['id_usuario']; ?>" class="delete-btn" onclick="return confirm('¿Estás seguro de que deseas eliminar a este usuario?');">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>