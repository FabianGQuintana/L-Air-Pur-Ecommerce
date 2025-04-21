<!-- SEGUNDO NAVBAR (Secundario o de categorías) -->
  
<nav class="navbar navbar-expand-lg navbar-light bg-light border-top border-bottom sticky-top navbar-secondary-items letter-navbar-Secondary">
    <div class="container-fluid justify-content-between align-items-center">

    <!--  Botón de offcanvas visible solo en pantallas pequeñas -->
    <a class="navbar-brand d-lg-none fw-bold" data-bs-toggle="offcanvas" href="#offcanvasWithBothOptions" role="button" aria-controls="offcanvasWithBothOptions">
      L’Air Pur
    </a>

    <!--  Título que se muestra en pantallas grandes -->
    <a class="navbar-brand d-none d-lg-block fw-bold" href="#Home">L’Air Pur</a>

    <!-- Menú visible solo en pantallas grandes -->
    <ul class="navbar-nav mx-auto d-none d-lg-flex">
      <li class="nav-item mx-5"><a class="nav-link" href="<?= base_url('/') ?>">Inicio</a></li>
      <li class="nav-item mx-5"><a class="nav-link" href="#marcas">Marcas</a></li>
      <li class="nav-item mx-5"><a class="nav-link" href="#nuevos">Nuevos</a></li>
      <li class="nav-item mx-5"><a class="nav-link" href="#ofertas">Review</a></li>
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

<!-- Banner principal(Hero) -->
<div class="container-fluid px-0 position-relative">
  <img src="assets/img/Banner-Hero.jpg" class="img-fluid w-100" alt="Banner Creed-Aventus L’Air Pur">
</div>



<!-- Carrucel de Marcas -->
<section class="Home-Carousel container">
  <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <!-- Imagen chica (visible hasta sm) -->
        <img src="assets/img/GiorgioArmani-sm.png" class="d-block d-md-none w-100" alt="Giorgio Armani móvil">
        <!-- Imagen grande (visible desde md en adelante) -->
        <img src="assets/img/GiorgioArmani.png" class="d-none d-md-block w-100" alt="Giorgio Armani movil">
      </div>
      <div class="carousel-item">
          <img src="assets/img/BossHugo-sm.png" class="d-block d-md-none w-100" alt="Hugo Boss">
          <img src="assets/img/BossHugo.png" class="d-none d-md-block w-100" alt="Hugo Boss">
      </div>
      <div class="carousel-item">
        <img src="assets/img/JeanPaulGaultier-sm.png" class="d-block d-md-none w-100" alt="Jean Paul Gaultier">
        <img src="assets/img/JeanPaulGaultier.png" class="d-none d-md-block w-100" alt="Jean Paul Gaultier">
      </div>
      <div class="carousel-item">
        <img src="assets/img/VersaceEros-sm.png" class="d-block d-md-none w-100" alt="Versace Eros">
        <img src="assets/img/VersaceEros.png" class="d-none d-md-block w-100" alt="Versace Eros">
      </div>
      <div class="carousel-item">
        <img src="assets/img/Valentino-sm.png" class="d-block d-md-none w-100" alt="Valentino movil">
        <img src="assets/img/Valentino.png" class="d-none d-md-block w-100" alt="Valentino">
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

<!-- Introduccion a la Pagina -->
<hr>
<div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-12 text-center">
        <h1 class="Titulo-Principal display-5 mb-4">L'AIR PUR TIENDA ONLINE DE PERFUMES</h1>
        <p class="lead">
          En L'Air Pur te ofrecemos una cuidada selección de perfumes que se adaptan a todos los gustos y estilos.
          Desde las casas de diseñador más reconocidas hasta las marcas nicho más exclusivas, cada fragancia es
          una invitación a expresar tu personalidad.
        </p>
      </div>
    </div>
  </div>


  <hr>
  <h2 class="text-center text-uppercase mt-4 mb-4 display-6">Productos Destacados</h2>
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
                  Fragancia intensa y moderna con notas dulces y especiadas, ideal para destacar en noches especiales o
                  eventos importantes.
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
                  Perfume afrutado y fresco con un toque oriental, ofrece elegancia y sofisticación
                  para quienes buscan una presencia encantadora.
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
                  Aroma masculino refinado y versátil, combina la frescura y calidez para acompañarte con estilo durante
                  el cualquier momento del dia.
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
                  Fragancia intensa y exótica con notas orientales y amaderadas, perfecta para destacar con
                  elegancia y distinción para cualquier momento.
                </p>
                <a href="#" class="btn btn-dark">Comprar</a>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

<!-- Descripcion De Fragancias Exoticas -->
<hr>
<div class="container-fluid px-0 mt-4 mb-4 shadow">
  <img src="assets/img/BannerOferta.png" class="img-fluid w-100" alt="Banner de la página">
</div>
  
  <hr>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-12 text-center">
        <h2 class="Titulo-Principal display-6 mb-4">SUMERGETE EN LAS FRAGANCIAS AXOTICAS</h2>
        <p class="lead">
          Explora nuestro universo olfativo y déjate llevar por notas que evocan lugares lejanos, recuerdos intensos
          y emociones profundas. Porque cada fragancia tiene su magia... y la tuya te está esperando.
        </p>
      </div>
    </div>
  </div>

  <!-- Cards de Perfumes de Nicho -->
  <hr>
    <h2 class="text-center text-uppercase mt-4 mb-4 display-6">Perfumes Exclusivos</h2>
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
                  Intenso y sensual con matices ambarinos y especiados, diseñado para dejar una impresión inolvidable.
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
                  Perfume fresco y limpio con notas cítricas y florales, ideal para un estilo sofisticado.
                </p>
                <small><a href="#" class="btn btn-dark">Comprar</a></small>
              </div>
            </div>
          </div>

        </div>
      </div>
      <hr>
    </section>

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

  <hr>
  <h2 class="text-center text-uppercase mt-4 mb-4 display-6">Perfumes Arabes Destacados</h2>
  <hr>

  <ul>
      <li>Amplia variedad de marcas y fragancias</li>
      <li>Productos 100% originales</li>
      <li>Envíos a todo el país</li>
      <li>Cuotas sin interés</li>
      <li>Ofertas y promociones exclusivas</li>
  </ul>
  <h4>Explora nuestra categoría de perfumes de hombre y encontra la fragancia perfecta para cada ocasión en L’Air Pur.</h4>



