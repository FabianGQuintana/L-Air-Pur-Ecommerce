<?php foreach ($items as $item): ?>
    <div class="card mb-3">
        <div class="row g-0 align-items-center">
            <div class="col-md-3 text-center">
                <img src="<?= base_url('assets/img/' . $item['imagen']) ?>" class="img-fluid rounded-start" alt="<?= esc($item['nombre']) ?>">
            </div>
            <div class="col-md-6">
                <div class="card-body">
                    <h5 class="card-title"><?= esc($item['nombre']) ?></h5>
                    <p class="card-text mb-1"><strong>Marca:</strong> <?= esc($item['marca']) ?></p>
                    <p class="card-text mb-1"><strong>Categoría:</strong> <?= esc($item['categoria']) ?></p>
                    <p class="card-text mb-1"><strong>Precio Unitario:</strong> $<?= number_format($item['precio'], 2) ?></p>
                    <p class="card-text"><strong>Subtotal:</strong> $<?= number_format($item['subtotal'], 2) ?></p>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="mb-2 d-flex justify-content-center align-items-center">
                    <button class="btn btn-outline-secondary btn-sm me-1 quitar-btn" data-id="<?= esc($item['id']) ?>"><i class="bi bi-dash"></i></button>
                    <span class="fw-bold"><?= esc($item['cantidad']) ?></span>
                    <button class="btn btn-outline-secondary btn-sm ms-1 agregar-btn" data-id="<?= esc($item['id']) ?>"><i class="bi bi-plus"></i></button>
                </div>
                <button class="btn btn-danger btn-sm eliminar-btn" data-id="<?= esc($item['id']) ?>"><i class="bi bi-trash"></i> Eliminar</button>
            </div>
        </div>
    </div>
<?php endforeach; ?>
