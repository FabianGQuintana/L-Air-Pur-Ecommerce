<div class="container mt-5">
    <h1 class="mb-4">🛒 Carrito de Compras</h1>

    <?php if ($usuario): ?>
        <p class="text-success">¡Hola, <strong><?= esc($usuario['nombre']) ?></strong>!</p>
    <?php endif; ?>

    <?php if (empty($items)): ?>
        <div class="alert alert-info">
            <p>El carrito está vacío. ¡Explora nuestra tienda y encuentra tus productos favoritos!</p>
        </div>
        <a href="/" class="btn btn-primary">
            <i class="bi bi-arrow-left-circle"></i> Seguir comprando
        </a>
    <?php else: ?>
        <?php foreach ($items as $item): ?>
            <div class="card mb-3 shadow-sm">
                <div class="row no-gutters align-items-center">
                    <div class="col-md-2 text-center">
                        <img src="<?= base_url('assets/img/' . $item['imagen']) ?>" class="img-fluid rounded" alt="<?= esc($item['nombre']) ?>">
                    </div>
                    <div class="col-md-6">
                        <div class="card-body">
                            <h5 class="card-title"><?= esc($item['nombre']) ?></h5>
                            <p class="card-text mb-1"><strong>Marca:</strong> <?= esc($item['marca']) ?></p>
                            <p class="card-text mb-1"><strong>Categoría:</strong> <?= esc($item['categoria']) ?></p>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="card-body">
                            <p class="card-text mb-1"><strong>Precio Unitario:</strong> $<?= number_format($item['precio'], 2) ?></p>
                            <div class="d-inline-flex align-items-center mb-2">
                                <!-- Botón para quitar 1 unidad -->
                                <a href="/Carrito/quitar/<?= esc($item['id']) ?>" class="btn btn-outline-secondary btn-sm me-1">
                                    <i class="bi bi-dash"></i>
                                </a>

                                <span class="fw-bold"><?= esc($item['cantidad']) ?></span>

                                <!-- Botón para agregar 1 unidad -->
                                <a href="/Carrito/agregar/<?= esc($item['id']) ?>" class="btn btn-outline-secondary btn-sm ms-1">
                                    <i class="bi bi-plus"></i>
                                </a>
                            </div>
                            <p class="card-text"><strong>Subtotal:</strong> $<?= number_format($item['subtotal'], 2) ?></p>

                            <!-- Botón para eliminar completamente el producto -->
                            <a href="/Carrito/eliminar/<?= esc($item['id']) ?>" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i> Eliminar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="mt-4 p-3 border rounded bg-light">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <a href="/" class="btn btn-primary">
                    <i class="bi bi-arrow-left-circle"></i> Seguir comprando
                </a>
                <p class="h5 mb-0">Total: <strong>$<?= number_format($total, 2) ?></strong></p>
                <a href="/carrito/vaciar" class="btn btn-danger">
                    <i class="bi bi-trash-fill"></i> Vaciar carrito
                </a>
            </div>
            <div class="text-end">
                <a href="/checkout" class="btn btn-success btn-lg">
                    <i class="bi bi-credit-card-fill"></i> Comprar Ahora
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>
