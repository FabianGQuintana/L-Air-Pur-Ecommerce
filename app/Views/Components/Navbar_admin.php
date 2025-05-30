<nav id="Admin" class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <!-- LOGO -->
    <a class="navbar-brand letter-navbar" href="<?= base_url('/Admin') ?>">
      <div class="logo-animado">
        <img src="<?= base_url('assets/img/LogoPrincipal.png') ?>" alt="Admin-logo" width="60" height="60">
      </div>
    </a>

    <!-- BOTÓN HAMBURGUESA -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar"
      aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- CONTENIDO QUE SE COLAPSA -->
    <div class="collapse navbar-collapse" id="adminNavbar">

      <!-- MENÚ NAV -->
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-2 list-unstyled">
        <li class="nav-item mx-1 px-3 py-2 rounded-pill">
          <a class="nav-link" href="<?= base_url('/Admin') ?>">Panel de Control</a>
        </li>
        <li class="nav-item mx-1 px-3 py-2 rounded-pill">
          <a class="nav-link" href="<?= base_url('/Admin/Productos') ?>">Productos</a>
        </li>
        <li class="nav-item mx-1 px-3 py-2 rounded-pill">
          <a class="nav-link" href="<?= base_url('Admin/Usuarios') ?>">Usuarios</a>
        </li>
        <li class="nav-item mx-1 px-3 py-2 rounded-pill">
          <a class="nav-link" href="<?= base_url('Admin/Ordenes') ?>">Órdenes</a>
        </li>
        <li class="nav-item mx-1 px-3 py-2 rounded-pill">
          <a class="nav-link" href="<?= base_url('Admin/Reportes') ?>">Consultas</a>
        </li>
        <li class="nav-item mx-1 px-3 py-2 rounded-pill">
          <a class="nav-link" href="<?= base_url('Admin/Logout') ?>">Cerrar sesión</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
