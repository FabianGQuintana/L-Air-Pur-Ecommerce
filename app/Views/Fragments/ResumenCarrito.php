<div class="card p-3 mb-4 bg-light resumen-pedido">
    <h4 class="mb-3">Resumen del Pedido</h4>
    <p><strong><?= count($items) ?> producto(s)</strong></p>

    <ul class="list-group mb-3">
        <?php foreach ($items as $item): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?= esc($item['nombre']) ?> x<?= esc($item['cantidad']) ?>
                <span>$<?= number_format($item['subtotal'], 2) ?></span>
            </li>
        <?php endforeach; ?>
    </ul>

    <p class="fw-bold">Total: $<?= number_format($total, 2) ?></p>
    <p><small class="text-muted">IVA incluido</small></p>

    <div class="my-3">
        <a href="<?= base_url('/Carrito/vaciar') ?>" class="btn btn-outline-danger btn-sm w-100 mb-2">
            <i class="bi bi-trash-fill"></i> Vaciar carrito
        </a>
        <a href="<?= base_url('Productos') ?>" class="btn btn-outline-primary btn-sm w-100 mb-2">
            <i class="bi bi-arrow-left-circle"></i> Seguir comprando
        </a>
    </div>

    <form action="<?= base_url('/Carrito/comprar') ?>" method="post">
        <button type="submit" class="btn btn-success btn-lg w-100">
            <i class="bi bi-credit-card-fill"></i> Comprar Ahora
        </button>
    </form>
</div>
