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

    <form action="index.php?controller=Usuario&action=crear" method="POST">
        <div class="form-group">
            <label for="nombres">Nombres</label>
            <input type="text" id="nombres" name="nombres" placeholder="Ej: Juan Freddy" required>
        </div>
        <div class="form-group">
            <label for="apellidoPaterno">Apellido Paterno</label>
            <input type="text" id="apellidoPaterno" name="apellidoPaterno" placeholder="Ej: Soto" required>
        </div>
        <div class="form-group">
            <label for="apellidoMaterno">Apellido Materno</label>
            <input type="text" id="apellidoMaterno" name="apellidoMaterno" placeholder="Ej: Garrita">
        </div>
        <div class="form-group">
            <label for="correo">Correo Institucional</label>
            <input type="email" id="correo" name="correo" placeholder="Ej: juan.soto@institucion.com" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Mínimo 8 caracteres" required>
        </div>
        <div class="form-group">
            <label for="idRol">Rol de Usuario</label>
            <select id="idRol" name="idRol" required>
                <option value="" disabled selected>Seleccionar un rol...</option>
                <option value="1">Estudiante</option> 
                <option value="2">Profesional</option>
                <option value="3">Administrador</option>
            </select>
        </div>
        <button type="submit">Añadir Usuario</button>
    </form>
</div>

<div class="card">
    <h2>Lista de Usuarios</h2>
     <table>
        <thead>
            <tr>
                <th>Nombre Completo</th>
                <th>Correo Institucional</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
   <tbody>
    <?php foreach ($usuarios as $usuario): ?>
    <tr>
        <td>
            <?php 
            $nombres = $usuario['Nombres'] ?? '';
            $paterno = $usuario['ApellidoPaterno'] ?? '';
            $materno = $usuario['ApellidoMaterno'] ?? '';
            echo htmlspecialchars(trim($nombres . ' ' . $paterno . ' ' . $materno)); 
            ?>
        </td>
        <td>
            <?php echo htmlspecialchars($usuario['CorreoInstitucional'] ?? ''); ?>
        </td>
        <td>
            <?php echo htmlspecialchars($usuario['rol_nombre'] ?? ''); ?>
        </td>
        <td>
            <?php
            if (isset($usuario['idUsuario']) && !empty($usuario['idUsuario'])) {
            ?>
            <button class="edit-btn modal-trigger-btn" 
                        data-id="<?php echo $usuario['idUsuario']; ?>" 
                        data-type="usuario">
                    Editar
                </button>
                <a href="index.php?controller=Usuario&action=eliminar&id=<?php echo $usuario['idUsuario']; ?>" class="delete-btn" onclick="return confirm('¿Estás seguro de que deseas eliminar a este usuario?');">
                    Eliminar
                </a>
            <?php
            } else {
                echo 'ID de usuario no encontrado'; 
            }
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>
    </table>
</div>