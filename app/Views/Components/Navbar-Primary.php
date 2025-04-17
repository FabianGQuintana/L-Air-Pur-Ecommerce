<nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
  <div class="container-fluid">
    <!-- LOGO -->
    <a class="navbar-brand" href="<?= base_url('/') ?>">
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
        <!-- BARRA DE BÚSQUEDA -->
        <form class="d-flex w-75" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Buscar</button>
        </form>
      </div>

      <!-- MENÚ NAV -->
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item mx-2"><a class="nav-link" href="<?= base_url('/') ?>">Inicio</a></li>
        <li class="nav-item mx-2"><a class="nav-link" href="<?= base_url('QuienesSomos') ?>">Sobre Nosotros</a></li>
        <li class="nav-item mx-2"><a class="nav-link" href="<?= base_url('Comercializacion') ?>">Ventas</a></li>
        <li class="nav-item mx-2"><a class="nav-link" href="<?= base_url('Contact') ?>">Contacto</a></li>
        <li class="nav-item mx-2"><a class="nav-link" href="<?= base_url('TerminosYCondiciones') ?>">Terminos Y Condiciones</a></li>
      </ul>
    </div>
  </div>
</nav>