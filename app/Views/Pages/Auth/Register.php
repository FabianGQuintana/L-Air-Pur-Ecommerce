<link rel="stylesheet" href="<?= base_url('assets/css/StyleRegister.css') ?>">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg formulario-register">
                <div class="card-body p-4">
                    <h2 class="text-center mb-4">Registrarse</h2>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger text-center">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success text-center">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('/Auth/doRegister') ?>" method="post">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Tu nombre" required>
                        </div>

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Apellido</label>
                            <input type="text" class="form-control" name="apellido" id="apellido" placeholder="Tu Apellido" required>
                        </div>

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Telefono (Opcional)</label>
                            <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Tu Telefono">
                        </div>

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Correo electrónico</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="ejemplo@correo.com" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Confirmar Correo</label>
                            <input type="email" class="form-control" name="emailConfirmar" id="emailConfirmar" placeholder="ejemplo@correo.com" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" name="password_hash" id="password_hash" placeholder="••••••••" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label"> Confirmar Contraseña</label>
                            <input type="password" class="form-control" name="passwordConfirmar" id="passwordConfirmar" placeholder="••••••••" required>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-success">Registrarse</button>
                        </div>

                        <p class="text-center">¿Ya tienes una cuenta? <a href="<?= base_url('/Auth/Login') ?>">Inicia sesión</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
