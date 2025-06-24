<div class="container-fluid mt-4">
  <div class="row">
    <!-- BOTÓN PARA MOSTRAR FILTROS EN PANTALLAS PEQUEÑAS -->
    <div class="col-12 d-md-none mb-3">
      <button class="btn btn-dark w-100" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFiltros">
        Filtros
      </button>
    </div>

    <!-- FILTROS EN OFFCANVAS (SOLO MÓVILES) -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasFiltros">
      <div class="offcanvas-header">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
      </div>
      <div class="offcanvas-body p-0">
        <div style="max-height: 70vh; overflow-y: auto;" class="p-3">
          <form method="get" action="<?= base_url('Productos') ?>">
            <button type="submit" class="btn btn-dark w-100">Aplicar filtros</button>

            <!-- CATEGORÍAS -->
            <div class="mb-3">
              <label class="form-label mt-3"><strong>Categoría</strong></label>
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

            <!-- MARCAS -->
            <div class="mb-3">
              <label class="form-label"><strong>Marca</strong></label>
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
          </form>
        </div>
      </div>
    </div>

    <!-- FILTROS VISIBLES SOLO EN PANTALLAS MD EN ADELANTE (STICKY CON SCROLL) -->
    <div class="col-md-2 d-none d-md-block">
      <div class="position-sticky" style="top: 20px; max-height: 85vh; overflow-y: auto;">
        <form method="get" action="<?= base_url('Productos') ?>">
          <button type="submit" class="btn btn-dark w-100">Aplicar filtros</button>

          <!-- CATEGORÍAS -->
          <div class="mb-3">
            <label class="form-label mt-3"><strong>Categoría</strong></label>
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

          <!-- MARCAS -->
          <div class="mb-3">
            <label class="form-label"><strong>Marca</strong></label>
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
        </form>
      </div>
    </div>

    <!-- PRODUCTOS -->
    <div class="col-md-10">
      <div class="container text-center text-justify">
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-5 justify-content-center">
          <?php foreach ($productos as $producto): ?>
            <div class="col mb-3">
              <div class="card h-100 d-flex flex-column mx-auto">
                <a href="<?= base_url('Productos/' . $producto['id_producto']) ?>" class="text-decoration-none text-dark">
                  <img src="<?= base_url('assets/img/' . $producto['imagen']) ?>" class="card-img-top" alt="<?= esc($producto['nombre']) ?>">
                  <div class="card-body">
                    <h5 class="card-title"><?= esc($producto['nombre']) ?></h5>
                    <p class="precio-elegante text-center">
                      <span class="simbolo">$</span><?= number_format($producto['precio'], 2, ',', '.') ?>
                    </p>
                  </div>
                </a>
                <div class="card-footer bg-transparent border-0">
                  <a href="<?= base_url('Productos/' . $producto['id_producto']) ?>" class="btn btn-dark w-100">Ver Detalle</a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>
