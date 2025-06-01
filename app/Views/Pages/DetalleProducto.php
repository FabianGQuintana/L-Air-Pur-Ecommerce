<link rel="stylesheet" href="<?= base_url('assets/css/StyleDetalleProducto.css') ?>">

<div class="container my-3">
    <div class="row producto-container">
        <!-- Imagen del producto -->
        <div class="col-md-6 mb-4 mb-md-0">
            <img src="<?= base_url('assets/img/' . $producto['imagen']) ?>" alt="<?= esc($producto['nombre']) ?>" class="img-fluid producto-imagen w-100 shadow-sm">
        </div>

        <!-- Detalle del producto -->
        <div class="col-md-6">
            <h5 class="text-muted mb-2">Nuevo | <?= esc($producto['cantidad']) ?> disponibles</h5>
            <h2 class="mb-3"><?= esc($producto['nombre']) ?> <?= esc($producto['mililitros']) ?> mL</h2>
            <h4 class="text-success mb-4">$<?= number_format($producto['precio'], 0, ',', '.') ?></h4>

            <p class="mt-3"><?= esc($producto['descripcion']) ?></p>

            <ul class="list-group mb-4 mt-4">
                <li class="list-group-item"><strong>Marca:</strong> <?= esc($producto['marca']) ?></li>
                <li class="list-group-item"><strong>Categoría:</strong> <?= esc($producto['categoria']) ?></li>
                <li class="list-group-item"><strong>Volumen:</strong> <?= esc($producto['mililitros']) ?> mL</li>
                <li class="list-group-item"><strong>Stock disponible:</strong> <?= esc($producto['cantidad']) ?></li>
            </ul>

            <!-- Formulario para agregar al carrito -->
            <form action="<?= base_url('Carrito/agregar/' . $producto['id_producto']) ?>" method="post" class="d-grid gap-3">
                <div class="mb-3">
                    <label for="cantidad" class="form-label">Cantidad:</label>
                    <input type="number" name="cantidad" id="cantidad" value="1" min="1" max="<?= esc($producto['cantidad']) ?>" class="form-control w-50">
                </div>
                <button type="submit" class="btn btn-outline-secondary btn-lg">Agregar al carrito</button>
            </form>
        </div>
    </div>
</div>
