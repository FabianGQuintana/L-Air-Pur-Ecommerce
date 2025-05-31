<!-- ============================
    SECCIÓN: FORMULARIO DE PRODUCTO
=============================== -->
<div class="container my-5">
  <h2 class="card-title mb-4 text-center fw-light display-6">Modificar Producto</h2>

  <?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?= session()->getFlashdata('message') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <ul class="mb-0">
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
          <li><?= esc($error) ?></li>
        <?php endforeach; ?>
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
  <?php endif; ?>

  <form action="<?= base_url('Productos/'.$producto['id_producto']); ?>" method="post" enctype="multipart/form-data">

    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="id_producto" value="<?= $producto['id_producto']; ?>">
    
    <div class="row">
      <div class="mb-3 col-md-6">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre" required value="<?= $producto['nombre'] ?>">
      </div>
      <div class="mb-3 col-md-6">
        <label for="categoria" class="form-label">Categoría</label>
        <select class="form-control" id="categoria" name="categoria" required>
          <option value="">Seleccionar</option>
          <?php foreach ($categorias as $categoria): ?>
            <option value="<?= $categoria['id_categoria'] ?>" <?php echo ($producto['id_categoria'] == $categoria['id_categoria'])? 'selected' : ''; ?> <?= set_select('categoria', $categoria['id_categoria']) ?>>
              <?= $categoria['nombre'] ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="mb-3">
      <label for="descripcion" class="form-label">Descripción</label>
      <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?= $producto['descripcion'] ?></textarea>
    </div>

    <div class="row">
      <div class="mb-3 col-md-4">
        <label for="precio" class="form-label">Precio</label>
        <input type="number" step="0.01" class="form-control" id="precio" name="precio" required value="<?= $producto['precio'] ?>">
      </div>
      <div class="mb-3 col-md-4">
        <label for="cantidad" class="form-label">Cantidad</label>
        <input type="number" class="form-control" id="cantidad" name="cantidad" required value="<?= $producto['cantidad'] ?>">
      </div>
      <div class="mb-3 col-md-4">
        <label for="mililitros" class="form-label">Mililitros</label>
        <input type="number" class="form-control" id="mililitros" name="mililitros" required value="<?= $producto['mililitros'] ?>">
      </div>
    </div>

    <div class="mb-3">
      <label for="marca" class="form-label">Marca</label>
      <select class="form-control" id="marca" name="marca" required>
        <option value="">Seleccionar</option>
        <?php foreach ($marcas as $marca): ?>
          <option value="<?= $marca['id_marca'] ?>" <?php echo ($producto['id_marca'] == $marca['id_marca'])? 'selected' : ''; ?> <?= set_select('marca', $marca['id_marca']) ?>>
            <?= $marca['nombre_marca'] ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="imagen" class="form-label">Imagen</label><br>
      <?php if (!empty($producto['imagen'])): ?>
        <img src="<?= base_url('assets/img/' .$producto['imagen']) ?>" alt="Imagen actual" class="img-thumbnail mb-2" style="max-width: 150px;">
      <?php else: ?>
        <p class="text-muted">No hay imagen actual</p>
      <?php endif; ?>
      <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
    </div>

    <div class="d-grid d-md-flex justify-content-md-end">
      <a href="<?= base_url('/Admin/Productos'); ?>" class="btn btn-secondary me-2">Volver</a>
      <button type="submit" class="btn btn-dark">Guardar producto</button>
    </div>
  </form>
</div>
