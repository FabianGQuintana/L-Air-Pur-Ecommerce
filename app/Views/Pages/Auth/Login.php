<?php helper('cookie'); ?>

<link rel="stylesheet" href="<?= base_url('assets/css/StyleLogin.css') ?>">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg formulario-login">
                <div class="card-body p-4">
                    <h2 class="text-center mb-4">Iniciar sesión</h2>

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

                    <?php if (isset($validation)) : ?>
                        <div class="alert alert-danger">
                            <?= $validation->listErrors() ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('/Auth/doLogin') ?>" method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="ejemplo@correo.com"
                                value="<?= old('email', get_cookie('remember_email')) ?>" required>
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control password-input" name="password" id="password" placeholder="Contraseña" required>
                            <i class="bi bi-eye-fill toggle-password"></i>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">Recuérdame</label>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-dark">Ingresar</button>
                        </div>

                        <p class="text-center">¿No tienes una cuenta? <a href="<?= base_url('Auth/Register') ?>">Registrarse</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script para mostrar/ocultar la contraseña -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.querySelector('.toggle-password');
    const passwordInput = document.getElementById('password');

    toggle.addEventListener('click', function () {
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        this.classList.toggle('bi-eye-fill');
        this.classList.toggle('bi-eye-slash-fill');
    });
});
</script>
