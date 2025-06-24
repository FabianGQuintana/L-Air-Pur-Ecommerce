<link rel="stylesheet" href="<?= base_url('assets/css/AdminDashboard.css') ?>">

<div class="container-fluid">
  <!-- Encabezado -->
  <div class="row bg-secondary text-white p-3 mb-3 align-items-center">
    <div class="col-md-6">
      <h2 class="mb-0">Panel Administrador</h2>
    </div>
    <div class="col-md-6 text-end">
      <div class="admin-info bg-dark px-3 py-2 rounded-3 d-inline-block">
        <i class="bi bi-person-circle me-2"></i>
        <strong><?= esc($adminNombre) ?> <?= esc($adminApellido) ?></strong>
      </div>
    </div>
  </div>

  <!-- Tarjetas de resumen -->
  <div class="row mb-4">
    <div class="col-md-4 mb-3">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Productos</h5>
          <p class="card-text display-6"><?= esc($totalProductos) ?></p>
          <a href="<?= base_url('/Admin/Productos') ?>" class="btn btn-dark btn-sm">Ver productos</a>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Usuarios Activos</h5>
          <p class="card-text display-6"><?= esc($totalUsuarios) ?></p>
          <a href="<?= base_url('UsuarioController') ?>" class="btn btn-dark btn-sm">Ver usuarios</a>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Órdenes</h5>
          <p class="card-text display-6"><?= esc($totalOrdenes) ?></p>
          <a  href="<?= base_url('/Admin/compras') ?>" class="btn btn-dark btn-sm">Ver órdenes</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Gráfico -->
  <div class="row">
    <div class="col-12">
      <div class="card p-3">
        <h5 class="card-title">Ventas mensuales</h5>
        <div class="chart-container">
          <canvas id="ventasChart"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Gráfico dinámico con Chart.js -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const datos = <?= json_encode($ventasPorMes) ?>;

    const labels = datos.map(item => item.mes);
    const valores = datos.map(item => item.cantidad);

    const ctx = document.getElementById('ventasChart').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          label: 'Ventas por mes',
          data: valores,
          backgroundColor: 'rgba(54, 162, 235, 0.7)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              precision: 0
            }
          },
          x: {
            ticks: {
              autoSkip: false,
              maxRotation: 45,
              minRotation: 20
            }
          }
        },
        plugins: {
          legend: {
            display: true
          }
        }
      }
    });
  });
</script>
