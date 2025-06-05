<div class="container mt-5 mb-5">
    <h2 class="mb-4 text-center">Mi Perfil</h2>

    <div class="card shadow">
        <div class="card-body">
            <h5 class="card-title mb-4">Información Personal</h5>
            <p><strong>Nombre:</strong> <?= esc($usuario['nombre']) ?></p>
            <p><strong>Email:</strong> <?= esc($usuario['email']) ?></p>
            <p><strong>Rol:</strong> <?= esc($usuario['rol'] ?? 'N/A') ?></p>


            <!-- Más detalles en el futuro -->
            <p class="text-muted mt-4">Aquí podrás modificar tus datos personales y ver tus compras recientes próximamente.</p>

            <a href="<?= base_url('/') ?>" class="btn btn-outline-dark mt-3">
                <i class="bi bi-arrow-left"></i> Volver al inicio
            </a>
        </div>
    </div>
</div>
