<footer class="bg-dark text-light mt-5 shadow-lg">
    <div class="container py-5 border-top border-secondary">
        <div class="row text-center text-md-start justify-content-center align-items-center">
            <!-- Marca -->
            <div class="col-md-4 mb-4 d-flex flex-column justify-content-center align-items-center text-center text-md-start">
                <h4 class="fw-bold">L'AIR PUR</h4>
                <p class="small mb-0">Panel de administración para gestionar productos, usuarios y compras de forma eficiente.</p>
            </div>

            <!-- Navegación -->
            <div class="col-md-4 mb-4 d-flex flex-column justify-content-center align-items-center text-center text-md-start">
                <h6 class="text-uppercase fw-bold mb-3">Navegación</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="bi bi-speedometer2 me-2"></i>
                        <a href="<?= base_url('/Admin') ?>" class="text-light text-decoration-none">Panel de Control</a>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-box-seam me-2"></i>
                        <a href="<?= base_url('/Admin/Productos') ?>" class="text-light text-decoration-none">Productos</a>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-people me-2"></i>
                        <a href="<?= base_url('UsuarioController') ?>" class="text-light text-decoration-none">Usuarios</a>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-cart-check me-2"></i>
                        <a href="<?= base_url('/Admin/compras') ?>" class="text-light text-decoration-none">Compras</a>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-chat-left-text me-2"></i>
                        <a href="<?= base_url('/Admin/consultas') ?>" class="text-light text-decoration-none">Consultas</a>
                    </li>
                </ul>
            </div>

            <!-- Derechos -->
            <div class="col-md-4 d-flex flex-column justify-content-center align-items-center text-center text-md-end">
                <p class="small mb-0">&copy; <?= date('Y') ?> <strong>L'AIR PUR</strong>. Todos los derechos reservados.</p>
            </div>
        </div>
    </div>
</footer>
