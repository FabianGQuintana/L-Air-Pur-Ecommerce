<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid d-flex align-items-center justify-content-between">

    <!-- LOGO -->
    <a class="navbar-brand letter-navbar" href="<?= base_url('/') ?>">
      <div class="logo-animado">
        <img src="<?= base_url('assets/img/LogoPrincipal.png') ?>" alt="L’Air Pur-logo" width="80" height="80">
      </div>
    </a>

    <!-- BOTÓN HAMBURGUESA (visible en móviles) -->
    <button class="navbar-toggler order-3 order-lg-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
      aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- ÍCONOS Login y Carrito -->
    <div class="d-flex gap-3 align-items-center order-2 order-lg-3 flex-lg-row">
      <a class="nav-link text-white text-center" href="<?= base_url('/Auth/Login') ?>">
        <i class="bi bi-person-circle fs-2"></i>
      </a>
      <a class="nav-link text-white text-center" href="<?= base_url('/Carrito') ?>">
        <i class="bi bi-cart3 fs-2"></i>
      </a>
    </div>

    <!-- MENÚ COLAPSABLE -->
    <div class="collapse navbar-collapse order-4 order-lg-1 justify-content-center" id="navbarContent">
      <ul class="navbar-nav mb-2 mb-lg-0 gap-4">
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('/') ?>">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('Productos') ?>">Perfumes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('Contact') ?>">Contacto</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            Más Info
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?= base_url('Comercializacion') ?>">Comercialización</a></li>
            <li><a class="dropdown-item" href="<?= base_url('QuienesSomos') ?>">Sobre Nosotros</a></li>
            <li><a class="dropdown-item" href="<?= base_url('TerminosYCondiciones') ?>">Términos y Usos</a></li>
          </ul>
        </li>
      </ul>
    </div>

  </div>
</nav>
