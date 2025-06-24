<div class="container py-5">
    <div class="row">
        <!-- Columna: Usuarios Logueados -->
        <div class="col-md-6">
            <h2 class="section-title">Usuarios Logueados</h2>
            <div class="mb-3">
                <label for="filtroUsuarios" class="form-label">Filtrar:</label>
                <select id="filtroUsuarios" class="form-select form-select-sm" onchange="filtrarConsultas('usuarios')">
                    <option value="todos">Todos</option>
                    <option value="sin-responder">Sin responder</option>
                    <option value="respondido">Respondido</option>
                </select>
            </div>

            <div class="row row-cols-1 g-4 mb-5">
                <?php foreach ($consultas as $c): ?>
                    <?php 
                        $fecha = date('d/m/Y', strtotime($c['fecha_hora']));
                        $hora = date('H:i', strtotime($c['fecha_hora']));
                        $estadoClase = ($c['estado'] === 'Sin Responder') ? 'sin-responder' : 'respondido';
                    ?>
                    <div class="col consulta-card usuarios <?= $estadoClase ?>">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-chat-dots info-icon"> </i><?= esc($c['asunto']) ?></h5>
                                <p class="card-text"> <?= esc($c['mensaje']) ?></p>
                                <hr>

                                <div class="row mb-2">
                                    <div class="col-6"><i class="bi bi-person info-icon"></i><strong> Nombre:</strong> <?= esc($c['nombre_usuario']) ?></div>
                                    <div class="col-6"><i class="bi bi-envelope info-icon"></i><strong> Email:</strong> <?= esc($c['email_usuario']) ?></div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-6"><i class="bi bi-calendar info-icon"></i><strong> Fecha:</strong> <?= $fecha ?></div>
                                    <div class="col-6"><i class="bi bi-clock info-icon"></i><strong> Hora:</strong> <?= $hora ?> hs</div>
                                </div>

                                <p><strong>Estado:</strong>
                                    <?php if ($c['estado'] === 'Sin Responder'): ?>
                                        <span class="badge bg-warning text-dark">Sin responder</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Respondido</span>
                                    <?php endif; ?>
                                </p>

                                <?php if ($c['estado'] === 'Sin Responder'): ?>
                                    <a href="<?= site_url("/Admin/responderConsulta/consulta/{$c['id_consulta']}") ?>" class="btn btn-sm btn-dark mt-2">
                                        <i class="bi bi-check-circle"></i> Marcar como Respondido
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Columna: Visitantes -->
        <div class="col-md-6">
            <h2 class="section-title">Visitantes</h2>
            <div class="mb-3">
                <label for="filtroVisitantes" class="form-label">Filtrar:</label>
                <select id="filtroVisitantes" class="form-select form-select-sm" onchange="filtrarConsultas('visitantes')">
                    <option value="todos">Todos</option>
                    <option value="sin-responder">Sin responder</option>
                    <option value="respondido">Respondido</option>
                </select>
            </div>

            <div class="row row-cols-1 g-4">
                <?php foreach ($contactos as $c): ?>
                    <?php 
                        $fecha = date('d/m/Y', strtotime($c['fecha_hora']));
                        $hora = date('H:i', strtotime($c['fecha_hora']));
                        $estadoClase = ($c['estado'] === 'Sin Responder') ? 'sin-responder' : 'respondido';
                    ?>
                    <div class="col consulta-card visitantes <?= $estadoClase ?>">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-chat-dots info-icon"></i> Consulta de visitante</h5>
                                <p class="card-text"> <?= esc($c['mensaje']) ?></p>
                                <hr>

                                <div class="row mb-2">
                                    <div class="col-6"><i class="bi bi-person info-icon"></i><strong> Nombre:</strong> <?= esc($c['nombre']) ?></div>
                                    <div class="col-6"><i class="bi bi-envelope info-icon"></i><strong> Email:</strong> <?= esc($c['email']) ?></div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-6"><i class="bi bi-telephone info-icon"></i><strong> Teléfono:</strong> <?= esc($c['telefono']) ?></div>
                                    <div class="col-6"><i class="bi bi-clock info-icon"></i><strong> Hora:</strong> <?= $hora ?> hs</div>
                                </div>

                                <p><i class="bi bi-calendar info-icon"></i><strong> Fecha:</strong> <?= $fecha ?></p>
                                <p><strong>Estado:</strong>
                                    <?php if ($c['estado'] === 'Sin Responder'): ?>
                                        <span class="badge bg-warning text-dark">Sin responder</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Respondido</span>
                                    <?php endif; ?>
                                </p>

                                <?php if ($c['estado'] === 'Sin Responder'): ?>
                                    <a href="<?= site_url("/Admin/responderConsulta/contacto/{$c['id_contacto']}") ?>" class="btn btn-sm btn-dark mt-2">
                                        <i class="bi bi-check-circle"></i> Marcar como Respondido
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Script para filtrar consultas -->
<script>
function filtrarConsultas(tipo) {
    const select = document.getElementById(`filtro${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`);
    const filtro = select.value;
    const tarjetas = document.querySelectorAll(`.consulta-card.${tipo}`);

    tarjetas.forEach(card => {
        if (filtro === 'todos') {
            card.style.display = '';
        } else if (card.classList.contains(filtro)) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>