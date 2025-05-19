<h2 class="text-center mb-4">Iniciar sesión</h2>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<form method="post" action="<?= base_url('Auth/Login') ?>">
    <div class="mb-3">
        <label for="email" class="form-label">Correo electrónico</label>
        <input type="email" class="form-control" name="email" required />
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" class="form-control" name="password" required />
    </div>
    <button type="submit" class="btn btn-primary w-100">Ingresar</button>
</form>
