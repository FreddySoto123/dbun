</div> <!-- Cierre de la clase .content -->

        <footer>
            <p>&copy; <?php echo date("Y"); ?> Proyecto DBUN - Todos los derechos reservados</p>
        </footer>

    </main> <!-- ===== CIERRE DEL CONTENEDOR PRINCIPAL ===== -->
<div id="editModalOverlay" class="modal-overlay">
        <div id="editModal" class="modal-container">
            <div class="modal-header">
                <h2 id="modalTitle">Editar Registro</h2>
                <span id="closeModalBtn" class="modal-close-btn">&times;</span>
            </div>
            <div id="modalContent" class="modal-content">
                <!-- El formulario se cargará aquí dinámicamente con JavaScript -->
            </div>
        </div>
    </div>
    <!-- ======================================================= -->

    <!-- Aquí irá nuestro script de JavaScript -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    // --- ELEMENTOS DEL MODAL ---
    const modalOverlay = document.getElementById('editModalOverlay');
    const modalTitle = document.getElementById('modalTitle');
    const modalContent = document.getElementById('modalContent');
    const closeModalBtn = document.getElementById('closeModalBtn');

    // --- FUNCIONES PARA MANEJAR EL MODAL ---
    function closeModal() {
        modalOverlay.classList.remove('show');
    }

    // --- EVENTOS PARA CERRAR EL MODAL ---
    closeModalBtn.addEventListener('click', closeModal);
    modalOverlay.addEventListener('click', function(event) {
        // Cierra el modal solo si se hace clic en el fondo oscuro
        if (event.target === modalOverlay) {
            closeModal();
        }
    });

    // --- LÓGICA PRINCIPAL PARA ABRIR EL MODAL ---
    document.querySelectorAll('.modal-trigger-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const type = this.dataset.type;

            let url = '';
            // 1. Determinar la URL del endpoint según el tipo de datos
            if (type === 'usuario') {
                url = `index.php?controller=Usuario&action=getUsuarioJson&id=${id}`;
            } else if (type === 'cita') {
                url = `index.php?controller=Cita&action=getCitaJson&id=${id}`;
            } else if (type === 'horario') {
                url = `index.php?controller=Horario&action=getHorarioJson&id=${id}`;
            } else {
                console.error('Tipo de modal no reconocido:', type);
                return;
            }

            // 2. Hacer la petición fetch para obtener los datos
            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('La respuesta del servidor no fue exitosa. Estatus: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    let formHtml = '';
                    // 3. Construir y mostrar el formulario correspondiente
                    if (type === 'usuario') {
                        modalTitle.textContent = 'Editar Usuario';
                        formHtml = buildUsuarioForm(data);
                    } else if (type === 'cita') {
                        modalTitle.textContent = 'Editar Cita';
                        formHtml = buildCitaForm(data);
                    } else if (type === 'horario') {
                        modalTitle.textContent = 'Editar Día de Atención';
                        formHtml = buildHorarioForm(data);
                    }

                    modalContent.innerHTML = formHtml;
                    modalOverlay.classList.add('show');
                })
                .catch(error => {
                    console.error('Error al obtener los datos para el modal:', error);
                    alert('No se pudieron cargar los datos para editar. Por favor, intente de nuevo.');
                });
        });
    });

    // --- FUNCIONES CONSTRUCTORAS DE FORMULARIOS ---

    /**
     * Construye el HTML del formulario para editar un Usuario.
     */
    function buildUsuarioForm(data) {
        return `
            <form action="index.php?controller=Usuario&action=actualizar" method="POST">
                <input type="hidden" name="idUsuario" value="${data.idUsuario}">
                <div class="form-group">
                    <label>Nombres</label>
                    <input type="text" name="nombres" value="${data.Nombres}" required>
                </div>
                <div class="form-group">
                    <label>Apellido Paterno</label>
                    <input type="text" name="apellidoPaterno" value="${data.ApellidoPaterno}" required>
                </div>
                <div class="form-group">
                    <label>Apellido Materno</label>
                    <input type="text" name="apellidoMaterno" value="${data.ApellidoMaterno || ''}">
                </div>
                <div class="form-group">
                    <label>Correo Institucional</label>
                    <input type="email" name="correo" value="${data.CorreoInstitucional}" required>
                </div>
                <div class="form-group">
                    <label>Nueva Contraseña</label>
                    <input type="password" name="password" placeholder="Dejar en blanco para no cambiar">
                </div>
                <div class="form-group">
                    <label>Rol de Usuario</label>
                    <select name="idRol" required>
                        <option value="1" ${data.IdRol == 1 ? 'selected' : ''}>Estudiante</option>
                        <option value="2" ${data.IdRol == 2 ? 'selected' : ''}>Profesional</option>
                        <option value="3" ${data.IdRol == 3 ? 'selected' : ''}>Administrador</option>
                    </select>
                </div>
                <button type="submit">Guardar Cambios</button>
            </form>
        `;
    }

    /**
     * Construye el HTML del formulario para editar una Cita.
     */
    function buildCitaForm(data) {
        const { cita, estudiantes, profesionales } = data;

        const estudiantesOptions = estudiantes.map(e => `<option value="${e.idUsuario}" ${cita.IdUsuario == e.idUsuario ? 'selected' : ''}>${e.Nombres} ${e.ApellidoPaterno}</option>`).join('');
        const profesionalesOptions = profesionales.map(p => `<option value="${p.IdProfesional}" ${cita.IdProfesional == p.IdProfesional ? 'selected' : ''}>${p.Nombres} ${p.ApellidoPaterno}</option>`).join('');

        return `
            <form action="index.php?controller=Cita&action=actualizar" method="POST">
                <input type="hidden" name="idCita" value="${cita.IdCita}">
                <div class="form-group"><label>Fecha de la Cita</label><input type="date" name="fechaCita" value="${cita.FechaCita}" required></div>
                <div class="form-group"><label>Hora de la Cita</label><input type="time" name="horaCita" value="${cita.HoraCita}" required></div>
                <div class="form-group"><label>Tipo de Consulta</label>
                    <select name="tipoConsulta" required>
                        <option value="Médica" ${cita.TipoConsulta == 'Médica' ? 'selected' : ''}>Médica</option>
                        <option value="Psicológica" ${cita.TipoConsulta == 'Psicológica' ? 'selected' : ''}>Psicológica</option>
                    </select>
                </div>
                <div class="form-group"><label>Estado de la Cita</label>
                    <select name="estado" required>
                        <option value="Reservado" ${cita.Estado == 'Reservado' ? 'selected' : ''}>Reservado</option>
                        <option value="Atendido" ${cita.Estado == 'Atendido' ? 'selected' : ''}>Atendido</option>
                        <option value="Cancelado" ${cita.Estado == 'Cancelado' ? 'selected' : ''}>Cancelado</option>
                    </select>
                </div>
                <div class="form-group"><label>Estudiante</label><select name="idUsuario" required>${estudiantesOptions}</select></div>
                <div class="form-group"><label>Profesional</label><select name="idProfesional" required>${profesionalesOptions}</select></div>
                <button type="submit">Guardar Cambios</button>
            </form>
        `;
    }

    /**
     * Construye el HTML del formulario para editar un Horario.
     */
    function buildHorarioForm(data) {
        const { horario, profesionales } = data;

        const profesionalesOptions = profesionales.map(p => `<option value="${p.IdProfesional}" ${horario.IdProfesional == p.IdProfesional ? 'selected' : ''}>${p.Nombres} ${p.ApellidoPaterno}</option>`).join('');
        
        const dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
        const diasOptions = dias.map(dia => `<option value="${dia}" ${horario.DiaSemana == dia ? 'selected' : ''}>${dia}</option>`).join('');

        return `
            <form action="index.php?controller=Horario&action=actualizar" method="POST">
                <input type="hidden" name="idDiasAtencion" value="${horario.idDiasAtencion}">
                <div class="form-group">
                    <label>Profesional</label>
                    <select name="idProfesional" required>${profesionalesOptions}</select>
                </div>
                <div class="form-group">
                    <label>Día de la Semana</label>
                    <select name="diaSemana" required>${diasOptions}</select>
                </div>
                <div class="form-group">
                    <label>Estado</label>
                    <select name="activo" required>
                        <option value="1" ${horario.Activo == 1 ? 'selected' : ''}>Activo</option>
                        <option value="0" ${horario.Activo == 0 ? 'selected' : ''}>Inactivo</option>
                    </select>
                </div>
                <button type="submit">Guardar Cambios</button>
            </form>
        `;
    }
});
    </script>
</body>
</html>