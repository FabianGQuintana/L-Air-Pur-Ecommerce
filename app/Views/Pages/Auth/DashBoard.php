<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-body">
            <h1 class="text-center mb-4">Bienvenido, <?= esc(session('nombre')) ?> 👋</h1>

            <div class="text-center mb-4">
                <p class="lead">Has iniciado sesión correctamente.</p>
                <p>Tu email registrado es: <strong><?= esc(session('email')) ?></strong></p>
            </div>

            <div class="d-flex justify-content-center gap-3">
                <a href="<?= base_url('/') ?>" class="btn btn-primary">Ir al inicio</a>
                <a href="<?= base_url('/logout') ?>" class="btn btn-outline-danger">Cerrar sesión</a>
            </div>
        </div>
    </div>
</div>
