<nav id="Home" class="navbar navbar-expand-lg navbar-dark bg-dark ">
  <div class="container-fluid">
    <!-- LOGO -->
    <a class="navbar-brand letter-navbar" href="<?= base_url('/') ?>">
      <div class="logo-animado">
        <img src="assets/img/LogoPrincipal.png" alt="L’Air Pur-logo" width="80" height="80">
      </div>
    </a>

    <!-- BOTÓN HAMBURGUESA -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
      aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- CONTENIDO QUE SE COLAPSA -->
    <div class="collapse navbar-collapse" id="navbarContent">
      <div class="d-flex flex-grow-1 justify-content-center">
      </div>

      <!-- MENÚ NAV -->
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-5 list-unstyled">
        <li class="nav-item mx-2"><a class="nav-link" href="<?= base_url('/') ?>" class="text-light text-decoration-none">Inicio</a></li>
        <li class="nav-item mx-2"><a class="nav-link" href="<?= base_url('QuienesSomos') ?>" class="text-light text-decoration-none">Quienes Somos</a></li>
        <li class="nav-item mx-2"><a class="nav-link" href="<?= base_url('Comercializacion') ?>" class="text-light text-decoration-none">Comercializacion</a></li>
        <li class="nav-item mx-2"><a class="nav-link" href="<?= base_url('Contact') ?>" class="text-light text-decoration-none">Contacto</a></li>
        <li class="nav-item mx-2"><a class="nav-link" href="<?= base_url('TerminosYCondiciones') ?>" class="text-light text-decoration-none">Terminos Y Usos</a></li>
      </ul>
    </div>
  </div>
</nav>