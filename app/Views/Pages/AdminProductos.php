<div class="container my-4">
  <h2 class="mb-4">Listado de Productos</h2>

   <!-- Botón para desplegar filtros -->
  <div class="mb-3 d-flex gap-2">
  <button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#filtrosCollapse" aria-expanded="false" aria-controls="filtrosCollapse">
    Filtros
  </button>
  <a href="<?= base_url('Productos/new') ?>" class="btn btn-success">Agregar</a>
</div>

  <!-- Sección de filtros -->
  <div class="collapse mb-4 <?= (!empty($filtrosSeleccionados['categorias']) || !empty($filtrosSeleccionados['marca'])) ? 'show' : '' ?>" id="filtrosCollapse">
    <div class="card card-body">
      <form method="get" action="">
        <div class="row">
          <!-- Filtro Nicho -->
          <div class="col-12 col-md-6 mb-3">
            <h5 class="mb-2">Nicho</h5>
            <?php foreach ($categorias as $cat): ?>
              <div class="form-check">
                  <input class="form-check-input" type="checkbox"
                        name="categorias[]"
                        value="<?= esc($cat['id_categoria']) ?>"
                        id="cat-<?= $cat['id_categoria'] ?>"
                        <?= in_array($cat['id_categoria'], $filtros['categorias']) ? 'checked' : '' ?>>
                  <label class="form-check-label" for="cat-<?= $cat['id_categoria'] ?>">
                    <?= esc($cat['nombre']) ?>
                  </label>
                </div>
            <?php endforeach; ?>
          </div>

          <!-- Filtro Marca -->
          <div class="col-12 col-md-6 mb-3">
            <h5 class="mb-2">Marca</h5>
            <?php foreach ($marcas as $marca): ?>
              <div class="form-check">
                  <input class="form-check-input" type="checkbox"
                        name="marcas[]"
                        value="<?= esc($marca['id_marca']) ?>"
                        id="marca-<?= esc($marca['id_marca']) ?>"
                        <?= in_array($marca['id_marca'], $filtros['marcas']) ? 'checked' : '' ?>>
                  <label class="form-check-label" for="marca-<?= esc($marca['id_marca']) ?>">
                    <?= esc($marca['nombre_marca']) ?>
                  </label>
                </div>
            <?php endforeach; ?>
          </div>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Aplicar filtros</button>
      </form>
    </div>
  </div>

  <!-- Tabla: visible solo en pantallas medianas y grandes -->
  <div class="table-responsive d-none d-md-block">
    <table class="table table-hover align-middle text-center">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Marca</th>
          <th>Categoría</th>
          <th>Cantidad</th>
          <th>Precio</th>
          <th>Imagen</th>
          <th>Editar</th>
          <th>Dar de baja</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($productos as $producto): ?>
          <tr>
            <td><?= htmlspecialchars($producto['nombre']) ?></td>
            <td><?= esc($producto['marca']) ?></td>
            <td><?= esc($producto['categoria']) ?></td>
            <td><?= $producto['cantidad'] ?></td>
            <td>$<?= number_format($producto['precio'], 2, ',', '.') ?></td>
            <td>
              <img src="<?= base_url('assets/img/' . $producto['imagen']) ?>" alt="<?= esc($producto['nombre']) ?>" class="img-fluid img-thumbnail" style="max-width: 60px; height: auto;">
            </td>
            <td>
              <a href="" class="btn btn-primary btn-sm w-100 mb-1">Editar</a>
            </td>
            <td>
              <a href="" class="btn btn-danger btn-sm w-100" onclick="return confirm('¿Estás seguro de dar de baja este producto?');">Dar de baja</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Tarjetas: visible solo en pantallas chicas -->
  <div class="d-block d-md-none">
    <?php foreach($productos as $producto): ?>
      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title"><?= htmlspecialchars($producto['nombre']) ?></h5>
          <p class="card-text mb-1"><strong>Marca:</strong> <?= esc($producto['marca']) ?></p>
          <p class="card-text mb-1"><strong>Categoría:</strong> <?= esc($producto['categoria']) ?></p>
          <p class="card-text mb-1"><strong>Cantidad:</strong> <?= $producto['cantidad'] ?></p>
          <p class="card-text mb-1"><strong>Precio:</strong> $<?= number_format($producto['precio'], 2, ',', '.') ?></p>
          <div class="mb-2">
            <img src="<?= base_url('assets/img/' . $producto['imagen']) ?>" alt="<?= esc($producto['nombre']) ?>" class="img-fluid img-thumbnail" style="max-width: 80px; height: auto;">
          </div>
          <div class="d-flex justify-content-between">
            <a href="" class="btn btn-primary btn-sm">Editar</a>
            <a href="" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de dar de baja este producto?');">Dar de baja</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
