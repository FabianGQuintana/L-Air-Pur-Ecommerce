<link rel="stylesheet" href="<?= base_url('assets/css/StyleLogin.css') ?>">
<div class="container mt-5 mb-5">
    <h2 class="mb-4 text-center">Editar Perfil</h2>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">

                    <!-- Mostrar errores generales -->
                    <?php if (session()->getFlashdata('validation')): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach (session()->getFlashdata('validation')->getErrors() as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php elseif (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
                    <?php endif; ?>

                    <form method="post" action="<?= base_url('/Pages/ActualizarUsuario') ?>">
                        <?= csrf_field() ?>

                        <div class="row">
                            <!-- Columna izquierda -->
                            <div class="col-md-6">
                                <!-- Nombre -->
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control <?= session('validation') && session('validation')->hasError('nombre') ? 'is-invalid' : '' ?>" id="nombre" name="nombre" value="<?= old('nombre', esc($usuario['nombre'])) ?>" required>
                                    <?php if (session('validation') && session('validation')->hasError('nombre')): ?>
                                        <div class="invalid-feedback"><?= esc(session('validation')->getError('nombre')) ?></div>
                                    <?php endif; ?>
                                </div>

                                <!-- Apellido -->
                                <div class="mb-3">
                                    <label for="apellido" class="form-label">Apellido</label>
                                    <input type="text" class="form-control <?= session('validation') && session('validation')->hasError('apellido') ? 'is-invalid' : '' ?>" id="apellido" name="apellido" value="<?= old('apellido', esc($usuario['apellido'])) ?>" required>
                                    <?php if (session('validation') && session('validation')->hasError('apellido')): ?>
                                        <div class="invalid-feedback"><?= esc(session('validation')->getError('apellido')) ?></div>
                                    <?php endif; ?>
                                </div>

                                <!-- Teléfono -->
                                <div class="mb-3">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input type="text" class="form-control <?= session('validation') && session('validation')->hasError('telefono') ? 'is-invalid' : '' ?>" id="telefono" name="telefono" value="<?= old('telefono', esc($usuario['telefono'])) ?>">
                                    <?php if (session('validation') && session('validation')->hasError('telefono')): ?>
                                        <div class="invalid-feedback"><?= esc(session('validation')->getError('telefono')) ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Columna derecha -->
                            <div class="col-md-6">
                                <!-- Correo -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo Electrónico</label>
                                    <input type="email" class="form-control <?= session('validation') && session('validation')->hasError('email') ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= old('email', esc($usuario['email'])) ?>" required>
                                    <?php if (session('validation') && session('validation')->hasError('email')): ?>
                                        <div class="invalid-feedback"><?= esc(session('validation')->getError('email')) ?></div>
                                    <?php endif; ?>
                                </div>

                                <!-- Nueva contraseña -->
                                <div class="mb-3">
                                    <label for="nueva_contrasena" class="form-label">Nueva Contraseña</label>
                                    <input type="password" class="form-control <?= session('validation') && session('validation')->hasError('nueva_contrasena') ? 'is-invalid' : '' ?>" id="nueva_contrasena" name="nueva_contrasena" placeholder="Opcional">
                                    <?php if (session('validation') && session('validation')->hasError('nueva_contrasena')): ?>
                                        <div class="invalid-feedback"><?= esc(session('validation')->getError('nueva_contrasena')) ?></div>
                                    <?php endif; ?>
                                </div>

                                <!-- Confirmar contraseña -->
                                <div class="mb-3">
                                    <label for="confirmar_contrasena" class="form-label">Confirmar Contraseña</label>
                                    <input type="password" class="form-control <?= session('validation') && session('validation')->hasError('confirmar_contrasena') ? 'is-invalid' : '' ?>" id="confirmar_contrasena" name="confirmar_contrasena" placeholder="Opcional">
                                    <?php if (session('validation') && session('validation')->hasError('confirmar_contrasena')): ?>
                                        <div class="invalid-feedback"><?= esc(session('validation')->getError('confirmar_contrasena')) ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-between mt-4">
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
