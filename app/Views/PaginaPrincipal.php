<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>L’Air Pur</title>
  <link href="assets/css/style.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

</head>
<body>
  <!-- NAVBAR PRINCIPAL -->
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
      <div class="container-fluid">
        <!-- LOGO -->
        <a class="navbar-brand" href="#">
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
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>

          <!-- MENÚ NAV -->
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item mx-2"><a class="nav-link" href="#Home">Home</a></li>
            <li class="nav-item mx-2"><a class="nav-link" href="#About Us">About Us</a></li>
            <li class="nav-item mx-2"><a class="nav-link" href="#Trade">Trade</a></li>
            <li class="nav-item mx-2"><a class="nav-link" href="#Contact">Contact</a></li>
            <li class="nav-item mx-2"><a class="nav-link" href="#Our Policy">Our Policy</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <!-- SEGUNDO NAVBAR (Secundario o de categorías) -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light border-top border-bottom sticky-top navbar-secondary-items">
  <div class="container-fluid justify-content-between align-items-center">

    <!--  Botón de offcanvas visible solo en pantallas pequeñas -->
    <a class="navbar-brand d-lg-none fw-bold" data-bs-toggle="offcanvas" href="#offcanvasWithBothOptions" role="button" aria-controls="offcanvasWithBothOptions">
      L’Air Pur
    </a>

    <!--  Título que se muestra en pantallas grandes -->
    <a class="navbar-brand d-none d-lg-block fw-bold" href="#Home">L’Air Pur</a>

    <!-- Menú visible solo en pantallas grandes -->
    <ul class="navbar-nav mx-auto d-none d-lg-flex">
      <li class="nav-item mx-5"><a class="nav-link" href="#Home">Inicio</a></li>
      <li class="nav-item mx-5"><a class="nav-link" href="#marcas">Marcas</a></li>
      <li class="nav-item mx-5"><a class="nav-link" href="#nuevos">Nuevos</a></li>
      <li class="nav-item mx-5"><a class="nav-link" href="#ofertas">Ofertas</a></li>
      <li class="nav-item mx-5"><a class="nav-link" href="#favoritos">Favoritos</a></li>
    </ul>

  </div>
</nav>

<div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">L’Air Pur</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link" href="#Home">Inicio</a></li>
      <li class="nav-item"><a class="nav-link" href="#marcas">Marcas</a></li>
      <li class="nav-item"><a class="nav-link" href="#nuevos">Nuevos</a></li>
      <li class="nav-item"><a class="nav-link" href="#ofertas">Ofertas</a></li>
      <li class="nav-item"><a class="nav-link" href="#favoritos">Favoritos</a></li>
    </ul>
  </div>
</div>


  <section class="Home-Carousel">
    <!-- CARROUSEL DE MARCAS -->
  <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="assets/img/GiorgioArmani-bg-white.png" class="d-block w-100" alt="Giorgio A.">
    </div>
    <div class="carousel-item">
      <img src="assets/img/BossHugo.png" class="d-block w-100" alt="Boss Hugo">
    </div>
    <div class="carousel-item">
      <img src="assets/img/prueba1.png" class="d-block w-100" alt="Lattafa">
    </div>
    <div class="carousel-item">
      <img src="assets/img/probando.png" class="d-block w-100" alt="Versace Eros">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
  </section>
  
  <h2>Perfumes Y Fragancias</h2>
  <hr>
  <p>Si estás buscando perfumes, estás en el lugar correcto. En L’Air Pur, ofrecemos una amplia selección de perfumes importados,
    originales y fragancias para todos los gustos. Ya sea que busques un perfume de hombre, o unisex,
    encontrarás opciones que se adaptan a tu estilo y personalidad.</p>

  <h3>Perfumes importados</h3>
  <p>Nuestra colección de perfumes importados incluye las mejores marcas y fragancias del mundo. Cada perfume ha sido seleccionado
    por su calidad y durabilidad, garantizando una experiencia olfativa única.</p>
  <h3>Perfumes originales: las mejores marcas en un solo lugar</h3>
  <p>En L’Air Pur, nos aseguramos de ofrecer solo perfumes originales. Trabajamos directamente con las marcas y distribuidores
    autorizados para garantizar la autenticidad de cada producto. Compra con confianza y disfruta de la mejor calidad.</p>
  <h3>Beneficios de comprar en Perfumerías L’Air Pur</h3>
  <ul>
      <li>Amplia variedad de marcas y fragancias</li>
      <li>Productos 100% originales</li>
      <li>Envíos a todo el país</li>
      <li>Cuotas sin interés</li>
      <li>Ofertas y promociones exclusivas</li>
  </ul>
  <h4>Explora nuestra categoría de perfumes de hombre y encontra la fragancia perfecta para cada ocasión en L’Air Pur.</h4>


  <!-- FOOTER -->
  <footer class="bg-dark text-light pt-3 pb-3 mt-5">
  <div class="container">
    <div class="row">

      <!-- Nombre o logo -->
      <div class="col-md-4 mb-3">
        <h5 class="fw-bold">L’Air Pur</h5>
        <p class="text-muted">Respirá estilo, viví natural.</p>
      </div>

      <!-- Enlaces rápidos -->
      <div class="col-md-4 mb-3">
        <h6>Enlaces</h6>
        <ul class="list-unstyled">
        <li><a href="#marcas" class="text-light text-decoration-none">Inicio</a></li>
          <li><a href="#marcas" class="text-light text-decoration-none">Marcas</a></li>
          <li><a href="#nuevos" class="text-light text-decoration-none">Nuevos</a></li>
          <li><a href="#ofertas" class="text-light text-decoration-none">Ofertas</a></li>
          <li><a href="#favoritos" class="text-light text-decoration-none">Favoritos</a></li>
        </ul>
      </div>

      <!-- Redes sociales -->
      <div class="col-md-4 mb-3">
        <h6>Seguinos En Nuestras Redes Sociales!</h6>
        <a href="#" class="text-light me-3 fs-4"><i class="bi bi-facebook"></i></a>
        <a href="https://www.instagram.com/garavant.parfums?igsh=b3M3eDBpbHZ5Z2Nt" class="text-light me-3 fs-4"><i class="bi bi-instagram"></i></a>
        <a href="https://www.linkedin.com/in/fabian-quintana-60a59a325?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app" class="text-light me-3 fs-4"><i class="bi bi-linkedin"></i></a>
        <a href="#" class="text-light me-3 fs-4"><i class="bi bi-whatsapp"></i></a>
        <a href="https://github.com/FabianGQuintana" class="text-light me-3 fs-4"><i class="bi bi-github"></i></a>
      </div>

    </div>

    <hr>
    <p class="text-center mb-0 text-muted">&copy; 2025 L’Air Pur - Todos los derechos reservados.</p>
  </div>
</footer>

  
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
