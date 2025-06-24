<div class="container my-4">
    <h2 class="mb-4 text-center text-md-start">Compras realizadas</h2>

    <!-- Tabla para pantallas grandes -->
    <div class="table-responsive d-none d-lg-block">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#Factura</th>
                    <th>Cliente</th>
                    <th>Email</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th class="text-center">Cantidad</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($facturas as $factura): ?>
                    <tr>
                        <td><?= str_pad($factura['id_factura'], 6, '0', STR_PAD_LEFT) ?></td>
                        <td><?= esc($factura['nombre'] . ' ' . $factura['apellido']) ?></td>
                        <td><?= esc($factura['email']) ?></td>
                        <td><?= date('d/m/Y', strtotime($factura['fecha_hora'])) ?></td>
                        <td><?= date('H:i', strtotime($factura['fecha_hora'])) ?></td>
                        <td class="text-center"><?= $factura['cantidad_productos'] ?></td>
                        <td>$<?= number_format($factura['importe_total'], 2) ?></td>
                        <td>
                            <a href="<?= base_url("/Admin/verFactura/{$factura['id_factura']}") ?>" 
                               class="btn btn-outline-primary btn-sm w-100">
                                Ver Factura
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Cards para pantallas medianas o chicas -->
    <div class="d-block d-lg-none">
        <div class="row g-3">
            <?php foreach ($facturas as $factura): ?>
                <div class="col-12 col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-2">Factura #<?= str_pad($factura['id_factura'], 6, '0', STR_PAD_LEFT) ?></h5>
                            <p class="mb-1"><strong>Cliente:</strong> <?= esc($factura['nombre'] . ' ' . $factura['apellido']) ?></p>
                            <p class="mb-1"><strong>Email:</strong> <?= esc($factura['email']) ?></p>
                            <p class="mb-1"><strong>Fecha:</strong> <?= date('d/m/Y', strtotime($factura['fecha_hora'])) ?></p>
                            <p class="mb-1"><strong>Hora:</strong> <?= date('H:i', strtotime($factura['fecha_hora'])) ?></p>
                            <p class="mb-1"><strong>Cantidad:</strong> <?= $factura['cantidad_productos'] ?></p>
                            <p class="mb-3"><strong>Total:</strong> $<?= number_format($factura['importe_total'], 2) ?></p>
                            <a href="<?= base_url("/Admin/verFactura/{$factura['id_factura']}") ?>" 
                               class="btn btn-outline-primary btn-sm w-100">
                                Ver Factura
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
