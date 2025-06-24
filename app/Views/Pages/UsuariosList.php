<div class="container mt-4">
    <h1 class="mb-4 text-center text-md-start">Lista de Usuarios</h1>

    <!-- Buscador y botón para crear admin -->
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
        <form method="get" action="<?= base_url('UsuarioController') ?>" class="d-flex flex-grow-1 me-3" style="max-width: 400px; min-width: 250px;">
            <input type="text"
                name="busqueda"
                class="form-control me-2"
                placeholder="Buscar por nombre, apellido o email"
                value="<?= esc($busqueda ?? '') ?>">
            <button class="btn btn-outline-secondary" type="submit">
                <i class="bi bi-search"></i> Buscar
            </button>
        </form>

        <div class="mt-2 mt-md-0">
            <a href="<?= base_url('/Admin/Nuevo') ?>" class="btn btn-success">
                <i class="bi bi-person-plus-fill me-1"></i> Crear Admin
            </a>
        </div>
    </div>

    <!-- Mensaje de éxito -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>

    <!-- Tabla para pantallas grandes -->
    <div class="table-responsive d-none d-lg-block">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($usuarios) && is_array($usuarios)) : ?>
                    <?php foreach ($usuarios as $usuario) : ?>
                        <tr>
                            <td><?= esc($usuario['id_usuario']) ?></td>
                            <td><?= esc($usuario['nombre']) ?></td>
                            <td><?= esc($usuario['apellido']) ?></td>
                            <td><?= esc($usuario['telefono']) ?></td>
                            <td><?= esc($usuario['email']) ?></td>
                            <td><?= esc($usuario['rol']) ?></td>
                            <td>
                                <?= $usuario['activo'] == 1
                                    ? '<span class="badge bg-success">Activo</span>'
                                    : '<span class="badge bg-secondary">Inactivo</span>' ?>
                            </td>
                            <td>
                                <a href="<?= base_url('Admin/Editar/' . $usuario['id_usuario']) ?>" class="btn btn-sm btn-warning">Editar</a>
                                <?php if ($usuario['activo'] == 1): ?>
                                    <a href="<?= base_url('Admin/Eliminar/' . $usuario['id_usuario']) ?>"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('¿Estás seguro de eliminar este usuario?');">
                                        Eliminar
                                    </a>
                                <?php else: ?>
                                    <a href="<?= base_url('Admin/Reactivar/' . $usuario['id_usuario']) ?>"
                                       class="btn btn-sm btn-success"
                                       onclick="return confirm('¿Deseas reactivar este usuario?');">
                                        Reactivar
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8" class="text-center">No hay usuarios registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Cards para pantallas medianas y chicas -->
    <div class="d-block d-lg-none">
        <div class="row g-3">
            <?php if (!empty($usuarios) && is_array($usuarios)) : ?>
                <?php foreach ($usuarios as $usuario) : ?>
                    <div class="col-12 col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title mb-2">Usuario #<?= esc($usuario['id_usuario']) ?></h5>
                                <p class="mb-1"><strong>Nombre:</strong> <?= esc($usuario['nombre']) ?></p>
                                <p class="mb-1"><strong>Apellido:</strong> <?= esc($usuario['apellido']) ?></p>
                                <p class="mb-1"><strong>Teléfono:</strong> <?= esc($usuario['telefono']) ?></p>
                                <p class="mb-1"><strong>Email:</strong> <?= esc($usuario['email']) ?></p>
                                <p class="mb-1"><strong>Rol:</strong> <?= esc($usuario['rol']) ?></p>
                                <p class="mb-3">
                                    <strong>Estado:</strong>
                                    <?= $usuario['activo'] == 1
                                        ? '<span class="badge bg-success">Activo</span>'
                                        : '<span class="badge bg-secondary">Inactivo</span>' ?>
                                </p>
                                <div class="d-grid gap-2">
                                    <a href="<?= base_url('Admin/Editar/' . $usuario['id_usuario']) ?>" class="btn btn-warning btn-sm">
                                        Editar
                                    </a>
                                    <?php if ($usuario['activo'] == 1): ?>
                                        <a href="<?= base_url('Admin/Eliminar/' . $usuario['id_usuario']) ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('¿Estás seguro de eliminar este usuario?');">
                                            Eliminar
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= base_url('Admin/Reactivar/' . $usuario['id_usuario']) ?>"
                                           class="btn btn-success btn-sm"
                                           onclick="return confirm('¿Deseas reactivar este usuario?');">
                                            Reactivar
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">No hay usuarios registrados.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
