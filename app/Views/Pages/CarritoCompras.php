<?php if (session()->has('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        <?= session('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->has('success')): ?>
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        <?= session('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="container mt-5">
    <h1 class="mb-4">🛒 Mi Carrito de Compras</h1>

    <?php if ($usuario): ?>
        <p class="text-success">¡Hola, <strong><?= esc($usuario['nombre']) ?></strong>!</p>
    <?php endif; ?>

    <?php if (empty($items)): ?>
        <div class="alert alert-info">
            <p>El carrito está vacío. ¡Explora nuestra tienda y encuentra tus perfumes favoritos!</p>
        </div>
        <a href="<?= base_url('Productos') ?>" class="btn btn-dark">
            <i class="bi bi-arrow-left-circle"></i> Seguir comprando
        </a>
    <?php else: ?>
        <div class="row">
            <!-- Columna izquierda: Productos -->
            <div class="col-md-8" id="carrito-items">
                <?= view('Fragments/ItemsCarrito', ['items' => $items]) ?>
            </div>

            <!-- Columna derecha: Resumen -->
            <div class="col-md-4" id="resumen-carrito">
                <?= view('Fragments/ResumenCarrito', ['items' => $items, 'total' => $total]) ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- JS para manejar AJAX -->
<script>
document.addEventListener('click', function (e) {
    const target = e.target.closest('button');
    if (!target) return;

    const id = target.dataset.id;
    if (target.classList.contains('agregar-btn')) {
        actualizarCarrito('agregarAjax', id);
    } else if (target.classList.contains('quitar-btn')) {
        actualizarCarrito('quitarAjax', id);
    } else if (target.classList.contains('eliminar-btn')) {
        actualizarCarrito('eliminarAjax', id);
    }
});

function actualizarCarrito(accion, id) {
    fetch(`carrito/${accion}/${id}`, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: ''
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert(data.mensaje);
            return;
        }

        if (data.productos && data.resumen) {
            document.querySelector('#carrito-items').innerHTML = data.productos;
            document.querySelector('#resumen-carrito').innerHTML = data.resumen;
        }
    })
    .catch(error => {
        console.error('Error al actualizar el carrito:', error);
    });
}
</script>
