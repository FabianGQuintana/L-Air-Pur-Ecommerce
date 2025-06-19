<?= $this->extend('Templates/main_layout') ?>
<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('assets/css/Style-DetalleProducto.css') ?>">

<div class="container my-3">
    <div class="row producto-container">
        <!-- Imagen del producto -->
        <div class="col-md-6 mb-4 mb-md-0">
            <img src="<?= base_url('assets/img/' . $producto['imagen']) ?>" alt="<?= esc($producto['nombre']) ?>" class="img-fluid producto-imagen w-100 shadow-sm">
        </div>

        <!-- Detalle del producto -->
        <div class="col-md-6">
            <h5 class="text-muted mb-2">Nuevo | <span id="stockDisponibleTexto"><?= $producto['cantidad']; ?> disponibles</span></h5>
            <h2 class="mb-3"><?= esc($producto['nombre']) ?> <?= esc($producto['mililitros']) ?> mL</h2>
            <h4 class="text-success mb-4">$<?= number_format($producto['precio'], 0, ',', '.') ?></h4>

            <p class="mt-3"><?= esc($producto['descripcion']) ?></p>

            <ul class="list-group mb-4 mt-4">
                <li class="list-group-item"><strong>Marca:</strong> <?= esc($producto['marca']) ?></li>
                <li class="list-group-item"><strong>Categoría:</strong> <?= esc($producto['categoria']) ?></li>
                <li class="list-group-item"><strong>Volumen:</strong> <?= esc($producto['mililitros']) ?> mL</li>
                <li class="list-group-item"><strong>Stock disponible:</strong> <span id="stockDisponibleLista"><?= esc($producto['cantidad']) ?></span></li>
            </ul>

            <!-- Mensaje de estado -->
            <div id="mensajeCarrito"></div>

            <!-- Formulario para agregar al carrito -->
            <form id="formAgregarCarrito" class="d-grid gap-3">
                <input type="hidden" name="id_producto" value="<?= $producto['id_producto'] ?>">

                <div class="mb-3">
                    <label for="cantidad" class="form-label">Cantidad:</label>
                    <select name="cantidad" id="cantidad" class="form-select w-50">
                        <?php
                        $max = min(12, $producto['cantidad']);
                        for ($i = 1; $i <= $max; $i++) {
                            echo "<option value=\"$i\">$i</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-dark btn-lg w-100">Agregar al carrito</button>
            </form>
        </div>
    </div>
</div>

<?= $this->section('popup') ?>
<?php if (!empty($mostrar_popup)): ?>
    <div id="popupCarrito" class="popup-carrito shadow rounded">
        <div class="popup-contenido">
            <div class="popup-imagen">
                <img id="popupImagenProducto" src="" alt="Producto">
                <div class="popup-check">&#10004;</div>
            </div>
            <div class="popup-texto mt-2">
                <strong>Agregaste a tu carrito</strong>
                <p id="popupDescripcionProducto" class="mb-1"></p>
            </div>
            <div class="popup-botones">
                <a href="<?= base_url('/Productos') ?>" class="btn btn-dark btn-sm">Ver más productos del Catalogo</a>
                <a href="<?= base_url('/Carrito') ?>" class="btn btn-outline-secondary btn-sm">Ir al carrito</a>
            </div>
        </div>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>

<script>
    const configDetalleProducto = {
        urlAgregarCarrito: "<?= base_url('/Carrito/agregar/') ?>",
        imagenProducto: "<?= base_url('assets/img/' . $producto['imagen']) ?>",
        descripcionProducto: "<?= esc($producto['nombre']) ?> <?= esc($producto['mililitros']) ?> mL"
    };
</script>
<script src="<?= base_url('assets/js/detalleProducto.js') ?>"></script>

<?= $this->endSection() ?>
