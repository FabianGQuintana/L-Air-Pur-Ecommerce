<div class="container my-4">
    <h2 class="mb-4">Compras realizadas</h2>

    <table class="table table-hover table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#Factura</th>
                <th>Cliente</th>
                <th>Email</th>
                <th>Fecha</th>
                <th>Cantidad</th>
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
                    <td><?= date('d/m/Y H:i', strtotime($factura['fecha_hora'])) ?></td>
                    <td class="text-center"><?= $factura['cantidad_productos'] ?></td>
                    <td>$<?= number_format($factura['importe_total'], 2) ?></td>
                    <td>
                        <a href="<?= base_url("/Admin/verFactura/{$factura['id_factura']}") ?>" 
                           class="btn btn-outline-primary btn-sm">
                            Ver Factura
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
