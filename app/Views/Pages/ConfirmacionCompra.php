<?php /** @var array $usuario */ ?>
<?php /** @var array $factura */ ?>
<?php /** @var array $detalles */ ?>

<div class="container my-5">
    <div class="text-center mb-4">
        <h1 class="text-success">🎉 Gracias por su compra</h1>
        <p class="lead">Hemos recibido su pedido correctamente. A continuación encontrará los detalles de su factura.</p>
    </div>

    <?= view('Components/Factura', [
        'usuario' => $usuario,
        'factura' => $factura,
        'detalles' => $detalles
    ]) ?>

    <div class="text-center mt-4">
        <a href="<?= base_url('/') ?>" class="btn btn-dark">
            <i class="bi bi-shop"></i> Volver a la tienda
        </a>

    </div>
</div>
