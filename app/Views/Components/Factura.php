<!-- =============================
         Factura de Producto
================================ -->

<link rel="stylesheet" href="<?= base_url('assets/css/Style-Factura.css') ?>">

<div class="container my-5">
    <div class="factura-box">
        <div class="empresa d-flex justify-content-between align-items-center">
            <div>
                <h3 class="mb-0">L'Air Pur</h3>
                <small>Perfumería Premium</small>
            </div>
            <div class="text-end">
                <strong>FACTURA</strong><br>
                Nº <?= str_pad($factura['id_factura'], 6, '0', STR_PAD_LEFT) ?><br>
                <span><strong>Fecha:</strong> <?= date('d/m/Y', strtotime($factura['fecha_hora'])) ?></span><br>
            </div>
        </div>

        <div class="my-4">
            <h5 class="mb-3">📅 Datos de Compra</h5>
            <p class="mb-1"><strong>Cliente:</strong> <?= esc($usuario['nombre']) ?></p>
            <p class="mb-1"><strong>Email:</strong> <?= esc($usuario['email']) ?></p>
            <p class="mb-1">
                <strong>Fecha de compra:</strong> <?= date('d/m/Y', strtotime($factura['fecha_hora'])) ?>
            </p>
            <p class="mb-1">
                <strong>Hora de compra:</strong> <?= date('H:i', strtotime($factura['fecha_hora'])) ?>
            </p>
            <p class="mb-1"><strong>Cantidad de productos:</strong> <?= esc($factura['cantidad_productos']) ?></p>
            <p class="mb-3"><strong>Importe total:</strong> $<?= number_format($factura['importe_total'], 2) ?></p>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-secondary">
                    <tr>
                        <th>Producto</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-end">Precio Unitario</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detalles as $detalle): ?>
                        <tr>
                            <td><?= esc($detalle['nombre_producto']) ?></td>
                            <td class="text-center"><?= esc($detalle['cantidad']) ?></td>
                            <td class="text-end">$<?= number_format($detalle['precio_unitario'], 2) ?></td>
                            <td class="text-end">$<?= number_format($detalle['subtotal'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="resumen-total">
            TOTAL A PAGAR: $<?= number_format($factura['importe_total'], 2) ?>
        </div>

    </div>
</div>
