<div class="container mt-5 mb-5">
    <h2 class="mb-4 text-center">Editar Perfil</h2>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">

                    <!-- ✅ Mostrar errores generales -->
                    <?php if (session()->getFlashdata('validation')): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach (session()->getFlashdata('validation')->getErrors() as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= base_url('/Pages/ActualizarUsuario') ?>">
                        <?= csrf_field() ?>

                        <!-- Campo Nombre -->
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control <?= session('validation') && session('validation')->hasError('nombre') ? 'is-invalid' : '' ?>" id="nombre" name="nombre" required value="<?= old('nombre', esc($usuario['nombre'])) ?>">
                            <?php if (session('validation') && session('validation')->hasError('nombre')): ?>
                                <div class="invalid-feedback">
                                    <?= esc(session('validation')->getError('nombre')) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Campo Apellido -->
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control <?= session('validation') && session('validation')->hasError('apellido') ? 'is-invalid' : '' ?>" id="apellido" name="apellido" required value="<?= old('apellido', esc($usuario['apellido'])) ?>">
                            <?php if (session('validation') && session('validation')->hasError('apellido')): ?>
                                <div class="invalid-feedback">
                                    <?= esc(session('validation')->getError('apellido')) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Campo Teléfono -->
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control <?= session('validation') && session('validation')->hasError('telefono') ? 'is-invalid' : '' ?>" id="telefono" name="telefono" value="<?= old('telefono', esc($usuario['telefono'])) ?>">
                            <?php if (session('validation') && session('validation')->hasError('telefono')): ?>
                                <div class="invalid-feedback">
                                    <?= esc(session('validation')->getError('telefono')) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('/Pages/PerfilUsuario') ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Guardar cambios
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
