<!-- Inicio del cuerpo -->
<div class="container-fluid">
  <!-- Encabezado -->
  <div class="row bg-primary text-white p-3 mb-3">
    <div class="col-md-6">
      <h2>Dashboard Administrador</h2>
    </div>
    <div class="col-md-6 text-end">
      <span>Admin: Juan Pérez</span>
      <button class="btn btn-light btn-sm ms-2">Cerrar sesión</button>
    </div>
  </div>

  <!-- Tarjetas de resumen -->
  <div class="row mb-4">
    <div class="col-md-4 mb-3">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Productos</h5>
          <p class="card-text display-6">120</p>
          <a href="#" class="btn btn-primary btn-sm">Ver productos</a>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Usuarios</h5>
          <p class="card-text display-6">75</p>
          <a href="#" class="btn btn-primary btn-sm">Ver usuarios</a>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Órdenes</h5>
          <p class="card-text display-6">45</p>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('ventasChart').getContext('2d');
  const ventasChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
      datasets: [{
        label: 'Ventas',
        data: [12, 19, 7, 15, 20],
        backgroundColor: 'rgba(54, 162, 235, 0.7)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

