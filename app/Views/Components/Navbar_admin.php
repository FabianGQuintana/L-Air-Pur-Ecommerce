<link rel="stylesheet" href="<?= base_url('assets/css/Style_NavbarAdmin.css') ?>">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark navbar-admin">

  <div class="container-fluid d-flex align-items-center justify-content-between">

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

    <!-- MENÚ COLAPSABLE -->
    <div class="collapse navbar-collapse justify-content-end" id="adminNavbar">
      <ul class="navbar-nav mb-2 mb-lg-0 gap-3 align-items-center">
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('/Admin') ?>">Panel de Control</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('/Admin/Productos') ?>">Productos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('UsuarioController') ?>">Usuarios</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('Admin/Ordenes') ?>">Órdenes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('Admin/Reportes') ?>">Consultas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-danger" href="<?= base_url('Admin/Logout') ?>">Cerrar sesión</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
