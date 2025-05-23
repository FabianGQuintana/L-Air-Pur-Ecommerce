<h2 class="text-center mb-4">Iniciar sesión</h2>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg">
                <div class="card-body p-4">
                    <h2 class="text-center mb-4">Iniciar sesión</h2>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger text-center">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('/Auth/doLogin') ?>" method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="ejemplo@correo.com" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="••••••••" required>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary">Ingresar</button>
                        </div>

                        <p class="text-center">¿No tienes una cuenta? <a href="<?= base_url('Auth/Register') ?>">Registrarse</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

