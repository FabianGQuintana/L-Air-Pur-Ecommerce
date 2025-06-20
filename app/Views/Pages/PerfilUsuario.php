<link rel="stylesheet" href="<?= base_url('assets/css/StyleLogin.css') ?>">

<div class="container mt-5 mb-5">
    <h2 class="mb-4 text-center">Mi Perfil</h2>

    <div class="row">
        <!-- Columna izquierda: Carrito y Facturas -->
        <div class="col-md-8">
            <!-- Card 1: Carrito Actual -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-secondary text-white">
                    Carrito Actual
                </div>
                <div class="card-body">
                    <?php if (count($itemsCarrito) > 0): ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($itemsCarrito as $item): ?>
                                <tr>
                                    <td><?= esc($item['nombre']) ?></td>
                                    <td><?= esc($item['cantidad']) ?></td>
                                    <td>$<?= number_format($item['precio'], 0, ',', '.') ?></td>
                                    <td>$<?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <p class="text-end fw-bold">Total: $<?= number_format($totalCarrito, 0, ',', '.') ?></p>
                    <?php else: ?>
                        <p class="text-muted">Tu carrito está vacío.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Card 2: Compras Anteriores -->
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    Compras Anteriores
                </div>
                <div class="card-body">
                    <?php if (!empty($facturas)): ?>
                        <?php foreach ($facturas as $factura): ?>
                            <div class="mb-4">
                                <h6 class="fw-bold">Factura #<?= esc($factura['id_factura']) ?> - <?= date('d/m/Y', strtotime($factura['fecha_hora'])) ?></h6>
                                <table class="table table-sm table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Imagen</th>
                                            <th>Producto</th>
                                            <th>Marca</th>
                                            <th>Categoría</th>
                                            <th>Cantidad</th>
                                            <th>Precio Unitario</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $totalFactura = 0; ?>
                                        <?php foreach ($factura['detalles'] as $detalle): ?>
                                            <?php
                                                $subtotal = $detalle['subtotal'] * $detalle['cantidad'];
                                                $totalFactura += $subtotal;
                                            ?>
                                            <tr>
                                                <td>
                                                    <img src="<?= base_url('assets/img/' . esc($detalle['imagen'])) ?>" alt="Imagen" width="50" height="50" class="rounded">
                                                </td>
                                                <td><?= esc($detalle['nombre_producto']) ?></td>
                                                <td><?= esc($detalle['marca']) ?></td>
                                                <td><?= esc($detalle['categoria']) ?></td>
                                                <td><?= esc($detalle['cantidad']) ?></td>
                                                <td>$<?= number_format($detalle['subtotal'], 0, ',', '.') ?></td>
                                                <td>$<?= number_format($subtotal, 0, ',', '.') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-secondary">
                                            <td colspan="6" class="text-end fw-bold">Total de la factura:</td>
                                            <td class="fw-bold">$<?= number_format($totalFactura, 0, ',', '.') ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted">No has realizado compras previas.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Columna derecha: Perfil de usuario -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <!-- Imagen/avatar -->
                    <img src="<?= base_url('assets/img/perfilUsuario.png') ?>" alt="Avatar" class="rounded-circle mb-3 mx-auto d-block" width="120" height="120">

                    <h5 class="card-title"><?= esc($usuario['nombre']) . ' ' . esc($usuario['apellido']) ?></h5>
                    <p class="text-muted mb-1"><?= esc($usuario['rol'] ?? 'Usuario') ?></p>
                    <hr>

                    <p><strong>Email:</strong><br> <?= esc($usuario['email']) ?></p>
                    <p><strong>Teléfono:</strong><br> <?= esc($usuario['telefono']) ?></p>

                    <!-- Botón Editar perfil -->
                    <div class="d-grid mt-3">
                        <a href="<?= base_url('/Pages/EditarPerfilUsuario') ?>" class="btn btn-outline-primary">
                            <i class="bi bi-pencil-square"></i> Editar perfil
                        </a>
                    </div>

                    <!-- Botón Volver al inicio -->
                    <div class="d-grid mt-2">
                        <a href="<?= base_url('/') ?>" class="btn btn-dark">
                            <i class="bi bi-arrow-left"></i> Volver al inicio
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
