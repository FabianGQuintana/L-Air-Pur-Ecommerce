
<!-- ============================
    SECCIÓN: DÓNDE ENCONTRARNOS
============================= -->
<div class="container mb-5">
    <h2 class="text-center mb-4 mt-5 titulo-seccion">Dónde encontrarnos</h2>
    <p class="text-justificado mb-4">
        Nos apasiona ofrecer fragancias exclusivas que definen tu estilo. Podés visitarnos en nuestro local o hacer tu pedido
        desde cualquier parte del país. Nuestra misión es acercarte la esencia del lujo, estés donde estés.
    </p>

    <div class="row">
        <!-- Mapa -->
        <div class="col-md-6 mb-4">
            <div class="mapa-responsive">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3583.464558187462!2d-58.827313324841276!3d-27.47124021729852!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94456c07c3e3a64f%3A0xf24940d6d8cf5c69!2sAv.%209%20de%20Julio%201198%2C%20W3400AAN%20Corrientes!5e0!3m2!1ses!2sar!4v1714069302000!5m2!1ses!2sar"
                    width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>
        </div>

        <!-- Información de la tienda -->
        <div class="col-md-6 text-justificado">
            <h4 class="titulo-destacado">Nuestra tienda</h4>
            <p><strong>Dirección:</strong>9 de Julio 1198, W3400CCP Corrientes, Argentina</p>
            <p><strong>Horario:</strong>
            <ul>
                <li>Lunes a Viernes de 9:00 a 21:00 hs</li>
                <li>Sabado de 9:00 a 13:00 hs</li>
            </ul>
            <p><strong>Teléfono:</strong> +3794123456</p>
            <p><strong>Email:</strong> soporte@lairpur.com</p>
        </div>
    </div>
</div>
<hr>
<!-- ============================
    SECCIÓN: MÉTODOS DE PAGO
============================= -->
<div class="container-fluid seccion-pagos py-5 mb-5">
    <div class="container">
        <h2 class="text-center mb-4 titulo-seccion">Métodos de pago</h2>
        <div class="row align-items-center">
            <!-- Texto -->
            <div class="col-md-6 text-justificado mb-3 mb-md-0">
                <p>
                    En nuestra tienda te ofrecemos múltiples opciones de pago para que elijas la que más te convenga:
                    tarjetas de crédito y débito, transferencias, Mercado Pago y más. Comprá con tranquilidad y seguridad.
                </p>
            </div>

            <!-- Imagen -->
            <div class="col-md-6 text-center">
                <img src="assets/img/tarjetasEjemplo.png" alt="Logos de tarjetas aceptadas"
                    class="img-fluid" style="max-height: 90px;">
            </div>
        </div>
    </div>
</div>


<!-- ============================
    SECCIÓN: CARRUSEL / GALERÍA
============================= -->
<div class="container mb-5">
    <h2 class="text-center mb-4 titulo-seccion">La experiencia de nuestros clientes</h2>
    <div id="carouselTestimonios" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner text-center">
            <div class="carousel-item active">
                <p class="text-muted">“Me encantó la fragancia y llegó rapidísimo. ¡Muy recomendados!”</p>
                <small>- Camila G.</small>
            </div>
            <div class="carousel-item">
                <p class="text-muted">“La atención fue excelente y el packaging hermoso. ¡Volveré a comprar!”</p>
                <small>- Juan L.</small>
            </div>
            <div class="carousel-item">
                <p class="text-muted">“Variedad, calidad y buen precio. No se puede pedir más.”</p>
                <small>- Luciana R.</small>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselTestimonios" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselTestimonios" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>
<hr>
<!-- ============================
    SECCIÓN: LLAMADO A LA ACCIÓN
============================= -->
<div class="container text-center mb-5">
    <h3 class="titulo-seccion">¿Listo para hacer tu pedido?</h3>
    <p class="text-muted mb-3">Elegí tu fragancia favorita y dejá que el lujo llegue a vos.</p>
    <a href="<?= base_url('/') ?>" class="btn btn-dark px-4 py-2">Productos</a>
</div>