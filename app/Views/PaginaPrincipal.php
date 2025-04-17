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

<!-- Carrucel de Marcas -->
<section class="Home-Carousel container">
  <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="assets/img/GiorgioArmani.png" class="d-block w-100" alt="Giorgio Armani">
      </div>
      <div class="carousel-item">
        <img src="assets/img/BossHugo.png" class="d-block w-100" alt="Boss Hugo">
      </div>
      <div class="carousel-item">
        <img src="assets/img/JeanPaulGultier.png" class="d-block w-100" alt="Jean Paul Gaultier">
      </div>
      <div class="carousel-item">
        <img src="assets/img/VersaceEros.png" class="d-block w-100" alt="Versace Eros">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Siguiente</span>
    </button>
  </div>
</section>

  <hr>
  <h2 class="text-center text-uppercase fw-semibold mt-4 mb-4 display-5">Productos Destacados</h2>
  <hr>

    <!-- Cards de Perfumes Destacados -->
    <section class="Perfumes-Destacados">
      <div class="container text-center">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 justify-content-center">
          
          <div class="col mb-4">
            <div class="card h-100 d-flex flex-column mx-auto">
              <img src="assets/img/JeanPaulElixir.jpg" class="card-img-top" alt="Jean Paul Gaultier Le Male Elixir">
              <div class="card-body">
                <h5 class="card-title">Jean Paul Gaultier Le Male Elixir</h5>
                <p class="precio-elegante text-center"><span class="simbolo">$</span>160.00</p>
                <p class="card-text">
                  Fragancia intensa y moderna con notas dulces y especiadas, ideal para destacar en noches especiales o eventos importantes.
                </p>
                <a href="#" class="btn btn-dark">Comprar</a>
              </div>
            </div>
          </div>

          <div class="col mb-4">
            <div class="card h-100 d-flex flex-column mx-auto">
              <img src="assets/img/ErbaPura.jpg" class="card-img-top" alt="ErbaPura">
              <div class="card-body">
                <h5 class="card-title">Erba Pura Xerjoff Eau De Parfum</h5>
                <p class="precio-elegante text-center"><span class="simbolo">$</span>180.00</p>
                <p class="card-text">
                  Perfume afrutado y fresco con un toque oriental, ofrece elegancia y sofisticación para quienes buscan una presencia encantadora.
                </p>
                <a href="#" class="btn btn-dark">Comprar</a>
              </div>
            </div>
          </div>

          <div class="col mb-4">
            <div class="card h-100 d-flex flex-column mx-auto">
              <img src="assets/img/BossUnited.png" class="card-img-top" alt="boss-bottled-united-eau-de-toilette">
              <div class="card-body">
                <h5 class="card-title">Hugo Boss Bottled Eau De Parfum</h5>
                <p class="precio-elegante text-center"><span class="simbolo">$</span>130.00</p>
                <p class="card-text">
                  Aroma masculino refinado y versátil, combina frescura y calidez para acompañarte con estilo durante el día o la noche.
                </p>
                <a href="#" class="btn btn-dark">Comprar</a>
              </div>
            </div>
          </div>

          <div class="col mb-4">
            <div class="card h-100 d-flex flex-column mx-auto">
              <img src="assets/img/CreedAventus.png" class="card-img-top" alt="Bharara King Eau de Parfum">
              <div class="card-body">
                <h5 class="card-title">Bharara King Eau de Parfum</h5>
                <p class="precio-elegante text-center"><span class="simbolo">$</span>105.00</p>
                <p class="card-text">
                  Fragancia intensa y exótica con notas orientales y amaderadas, perfecta para destacar con elegancia y distinción.
                </p>
                <a href="#" class="btn btn-dark">Comprar</a>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
  <hr>

  <!-- Reseña de Reseña Jean Paul Gaultier Le Male Elixir -->
  <section class="py-5 bg-light">
    <div class="container text-center">
      <h2 class="fw-semibold mb-4 border-bottom pb-2 d-inline-block text-dark">
        Reseña Jean Paul Gaultier Le Male Elixir - Andrés Perfume-Man
      </h2>
      <div class="mx-auto shadow rounded overflow-hidden" style="max-width: 1080px;">
        <div class="ratio ratio-16x9">
          <iframe 
            src="https://www.youtube.com/embed/_z6NnfQDlT8" 
            title="Video de YouTube - Andrés Perfume-Man" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
            allowfullscreen>
          </iframe>
        </div>
      </div>
    </div>
  </section>

  <!-- Cards de Perfumes de Nicho -->
  <hr>
    <h3 class="text-center text-uppercase fw-semibold mt-4 mb-4 display-5">Perfumes Nicho</h3>
  <hr>
    <section class="Primavera/Verano">
      <div class="container text-center">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 justify-content-center">
          
          <div class="col mb-4">
            <div class="card h-100 d-flex flex-column mx-auto">
              <img src="assets/img/nishane.png" class="card-img-top" alt="Ani Nishane Extrait de Parfum">
              <div class="card-body">
                <h5 class="card-title">Ani Nishane Extrait de Parfum</h5>
                <p class="precio-elegante text-center"><span class="simbolo">$</span>250.00</p>
                <p class="card-text">
                  Aroma cálido y especiado con notas orientales y un toque dulce, ideal para momentos sofisticados y memorables.
                </p>
                <a href="#" class="btn btn-dark">Comprar</a>
              </div>
            </div>
          </div>

          <div class="col mb-4">
            <div class="card h-100 d-flex flex-column mx-auto">
              <img src="assets/img/CreedAventus.png" class="card-img-top" alt="Creed Aventus Eau de Parfum">
              <div class="card-body">
                <h5 class="card-title">Creed Aventus Eau de Parfum</h5>
                <p class="precio-elegante text-center"><span class="simbolo">$</span>495.00</p>
                <p class="card-text">
                  Fragancia masculina fresca y afrutada con un fondo amaderado, perfecta para líderes seguros y decididos.
                </p>
                <a href="#" class="btn btn-dark">Comprar</a>
              </div>
            </div>
          </div>

          <div class="col mb-4">
            <div class="card h-100 d-flex flex-column mx-auto">
              <img src="assets/img/InitioParfums.jpg" class="card-img-top" alt="Side Effect Initio Eau de Parfum">
              <div class="card-body">
                <h5 class="card-title">Side Effect Initio Eau de Parfum</h5>
                <p class="precio-elegante text-center"><span class="simbolo">$</span>400.00</p>
                <p class="card-text">
                  Perfume intenso y sensual con matices ambarinos y especiados, diseñado para dejar una impresión inolvidable.
                </p>
                <small><a href="#" class="btn btn-dark">Comprar</a></small>
              </div>
            </div>
          </div>

          <div class="col mb-4">
            <div class="card h-100 d-flex flex-column mx-auto">
              <img src="assets/img/MaisonFrancisKurkdjian.jpg" class="card-img-top" alt="Side Effect Initio Eau de Parfum">
              <div class="card-body">
                <h5 class="card-title">Maison Francis Kurkdjian Aqua Universalis</h5>
                <p class="precio-elegante text-center"><span class="simbolo">$</span>144.00</p>
                <p class="card-text">
                  Perfume fresco y limpio con notas cítricas y florales, ideal para un estilo versátil y sofisticado.
                </p>
                <small><a href="#" class="btn btn-dark">Comprar</a></small>
              </div>
            </div>
          </div>

        </div>
      </div>
      <hr>
    </section>
  
  <h3>Perfumes Arabes</h3>

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
