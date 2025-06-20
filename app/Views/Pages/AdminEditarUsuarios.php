<div class="container mt-5">
    <h2 class="mb-4">Editar Usuario</h2>

    <?php if ($validation = session()->getFlashdata('validation')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($validation->getErrors() as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('Admin/Actualizar/' . $usuario['id_usuario']) ?>">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input
                    type="text"
                    class="form-control <?= ($validation && $validation->hasError('nombre')) ? 'is-invalid' : '' ?>"
                    name="nombre"
                    id="nombre"
                    value="<?= old('nombre', esc($usuario['nombre'])) ?>"
                    required
                >
                <?php if ($validation && $validation->hasError('nombre')): ?>
                    <div class="invalid-feedback">
                        <?= $validation->getError('nombre') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-md-6 mb-3">
                <label for="apellido" class="form-label">Apellido</label>
                <input
                    type="text"
                    class="form-control <?= ($validation && $validation->hasError('apellido')) ? 'is-invalid' : '' ?>"
                    name="apellido"
                    id="apellido"
                    value="<?= old('apellido', esc($usuario['apellido'])) ?>"
                    required
                >
                <?php if ($validation && $validation->hasError('apellido')): ?>
                    <div class="invalid-feedback">
                        <?= $validation->getError('apellido') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-md-6 mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input
                    type="text"
                    class="form-control <?= ($validation && $validation->hasError('telefono')) ? 'is-invalid' : '' ?>"
                    name="telefono"
                    id="telefono"
                    value="<?= old('telefono', esc($usuario['telefono'])) ?>"
                >
                <?php if ($validation && $validation->hasError('telefono')): ?>
                    <div class="invalid-feedback">
                        <?= $validation->getError('telefono') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                    type="email"
                    class="form-control <?= ($validation && $validation->hasError('email')) ? 'is-invalid' : '' ?>"
                    name="email"
                    id="email"
                    value="<?= old('email', esc($usuario['email'])) ?>"
                    required
                >
                <?php if ($validation && $validation->hasError('email')): ?>
                    <div class="invalid-feedback">
                        <?= $validation->getError('email') ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save me-1"></i> Guardar cambios
        </button>
        <a href="<?= base_url('UsuarioController') ?>" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
</div>
