<div class="container mt-4">
    <h1 class="mb-4">Lista de Usuarios</h1>

    <!-- Buscador -->
    <form method="get" action="<?= base_url('UsuarioController') ?>" class="mb-3">
        <div class="input-group" style="max-width: 400px;">
            <input type="text"
                name="busqueda"
                class="form-control"
                placeholder="Buscar por nombre, apellido o email"
                value="<?= esc($busqueda ?? '') ?>">
            <button class="btn btn-outline-secondary" type="submit">
                <i class="bi bi-search"></i> Buscar
            </button>
        </div>
    </form>

    <!-- Tabla de usuarios -->
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Rol</th> <!-- Nueva columna para el rol -->
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
                        <td><?= esc($usuario['rol']) ?></td> <!-- Celda de rol -->
                        <td>
                            <a href="<?= base_url('usuarios/editar/' . $usuario['id_usuario']) ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="<?= base_url('usuarios/eliminar/' . $usuario['id_usuario']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="7" class="text-center">No hay usuarios registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
