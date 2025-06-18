<!-- Inicio del cuerpo -->
<div class="container-fluid">
  <!-- Encabezado -->
  <div class="row bg-primary text-white p-3 mb-3">
    <div class="col-md-6">
      <h2>Dashboard Administrador</h2>
    </div>
    <div class="col-md-6 text-end">
      <span>Admin: <?= esc($adminNombre) . ' ' . esc($adminApellido) ?></span>
      <a href="<?= base_url('/Logout') ?>" class="btn btn-light btn-sm ms-2">Cerrar sesión</a>
    </div>
  </div>

  <!-- Tarjetas de resumen -->
  <div class="row mb-4">
    <div class="col-md-4 mb-3">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Productos</h5>
          <p class="card-text display-6"><?= esc($totalProductos) ?></p>
          <a href="<?= base_url('/Admin/Productos') ?>" class="btn btn-primary btn-sm">Ver productos</a>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Usuarios</h5>
          <p class="card-text display-6"><?= esc($totalUsuarios)?></p>
          <a href="<?= base_url('UsuarioController') ?>" class="btn btn-primary btn-sm">Ver usuarios</a>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Órdenes</h5>
          <p class="card-text display-6"><?= esc($totalOrdenes)?></p>
          <a href="#" class="btn btn-primary btn-sm">Ver órdenes</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Gráfico -->
  <div class="row">
    <div class="col-12">
      <div class="card p-3">
        <h5 class="card-title">Ventas mensuales</h5>
        <canvas id="ventasChart" height="100"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- Script para el gráfico (Chart.js) -->

<script>
  const datos = <?= json_encode($ventasPorMes) ?>;
  const labels = datos.map(item => `Mes ${item.mes}`);
  const valores = datos.map(item => item.cantidad);

  const ventasChart = new Chart(document.getElementById('ventasChart'), {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: 'Ventas',
        data: valores,
        backgroundColor: 'rgba(54, 162, 235, 0.7)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true }
      }
    }
  });
</script>



