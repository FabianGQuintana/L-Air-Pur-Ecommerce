<!-- ============================
    SECCIÓN: LISTADO DE PRODUCTOS
=============================== -->
<link rel="stylesheet" href="<?= base_url('assets/css/Style-AdminProductos.css') ?>">

<div class="container my-4">
  <h2 class="mb-4 text-center fw-light">Listado de Productos</h2>

  <!-- Barra de búsqueda + botones -->
  <div class="mb-3 d-flex gap-2 justify-content-between">
    <form method="get" action="<?= base_url('/Admin/Productos') ?>" class="flex-grow-1 me-2">
      <div class="input-group">
        <input type="text"
               name="busqueda"
               class="form-control"
               placeholder="Buscar productos, marcas o categorías..."
               value="<?= esc($busqueda ?? '') ?>">
        <button class="btn btn-outline-secondary" type="submit">
          <i class="bi bi-search"></i> Buscar
        </button>
      </div>
    </form>

    <button class="btn btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#filtrosCollapse" aria-expanded="false" aria-controls="filtrosCollapse">
      <i class="bi bi-funnel-fill me-1"></i> Filtros
    </button>
    <a href="<?= base_url('Productos/new') ?>" class="btn btn-success">
      <i class="bi bi-plus-circle-fill me-1"></i> Agregar
    </a>
  </div>

  <!-- Sección de filtros -->
  <div class="collapse mb-4 <?= (!empty($filtros['categorias']) || !empty($filtros['marcas'])) ? 'show' : '' ?>" id="filtrosCollapse">
    <div class="card filtros-card p-3">
      <form method="get" action="">
        <div class="row">
          <!-- Filtro Nicho -->
          <div class="col-12 col-md-6 mb-3">
            <h5 class="mb-2 fw-semibold">Nicho</h5>
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
            <h5 class="mb-2 fw-semibold">Marca</h5>
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
        <button type="submit" class="btn btn-dark mt-3 w-100">
          <i class="bi bi-funnel me-1"></i> Aplicar filtros
        </button>
      </form>
    </div>
  </div>

  <!-- Tabla: visible solo en pantallas medianas y grandes -->
  <div class="table-responsive d-none d-md-block">
    <table class="table table-hover align-middle text-center">
      <thead class="table-dark">
        <tr>
          <th>Nombre</th>
          <th>Marca</th>
          <th>Categoría</th>
          <th>Cantidad</th>
          <th>Precio</th>
          <th>Imagen</th>
          <th>Estado</th> <!-- NUEVO -->
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
              <img src="<?= base_url('assets/img/' . $producto['imagen']) ?>" alt="<?= esc($producto['nombre']) ?>" class="img-thumbnail img-miniatura">
            </td>
            <td>
              <?php if ($producto['activo']): ?>
                <span class="badge bg-success">Activo</span>
              <?php else: ?>
                <span class="badge bg-secondary">Inactivo</span>
              <?php endif; ?>
            </td>
            <td>
              <a href="<?= base_url('Productos/'. $producto['id_producto'].'/edit'); ?>" class="btn btn-custom-dark btn-sm w-100 mb-1">Editar</a>
            </td>
            <td>
              <form action="<?= site_url('Productos/' . $producto['id_producto']) ?>" method="post" onsubmit="return confirm('¿Estás seguro que querés desactivar este producto?')">
                  <?= csrf_field() ?>
                  <input type="hidden" name="_method" value="DELETE">
                  <button type="submit" class="btn btn-custom-danger btn-sm w-100">Dar de Baja</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

 <!-- Tarjetas: visible solo en pantallas chicas -->
<div class="d-block d-md-none">
  <?php foreach($productos as $producto): ?>
    <div class="card mb-3 card-producto">
      <div class="card-body">
        <h5 class="card-title fw-semibold"><?= htmlspecialchars($producto['nombre']) ?></h5>
        <p class="card-text mb-1"><strong>Marca:</strong> <?= esc($producto['marca']) ?></p>
        <p class="card-text mb-1"><strong>Categoría:</strong> <?= esc($producto['categoria']) ?></p>
        <p class="card-text mb-1"><strong>Cantidad:</strong> <?= $producto['cantidad'] ?></p>
        <p class="card-text mb-1"><strong>Precio:</strong> $<?= number_format($producto['precio'], 2, ',', '.') ?></p>
        <p class="card-text mb-1">
          <strong>Estado:</strong>
          <?php if ($producto['activo']): ?>
            <span class="text-success fw-semibold">Activo</span>
          <?php else: ?>
            <span class="text-muted fw-semibold">Inactivo</span>
          <?php endif; ?>
        </p>
        <div class="mb-2 text-center">
          <img src="<?= base_url('assets/img/' . $producto['imagen']) ?>" alt="<?= esc($producto['nombre']) ?>" class="img-thumbnail img-miniatura-movil">
        </div>
        <!-- BOTONES en columna y a 100% de ancho -->
        <div class="d-grid gap-2">
          <a href="<?= base_url('Productos/'. $producto['id_producto'].'/edit'); ?>" class="btn btn-custom-dark btn-sm w-100">Editar</a>
          <form action="<?= site_url('Productos/' . $producto['id_producto']) ?>" method="post" onsubmit="return confirm('¿Estás seguro que querés desactivar este producto?')">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="btn btn-custom-danger btn-sm w-100">Dar de baja</button>
          </form>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>



<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
