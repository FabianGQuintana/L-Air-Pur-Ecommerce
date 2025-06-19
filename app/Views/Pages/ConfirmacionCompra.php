<?php /** @var array $usuario */ ?>
<?php /** @var array $factura */ ?>
<?php /** @var array $detalles */ ?>

<style>
    .factura-box {
        background-color: #fff;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        max-width: 700px;
        margin: 0 auto;
    }
    .empresa {
        background-color: rgb(75, 67, 97);
        color: white;
        padding: 20px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
    .resumen-total {
        background-color: #198754;
        color: white;
        padding: 10px;
        font-size: 1.25rem;
        font-weight: bold;
        text-align: end;
    }
    @media (max-width: 768px) {
        .empresa, .factura-box {
            padding: 15px;
        }
    }
</style>

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
