<!DOCTYPE html>
    <html lang="es">
        <head>
        <title><?= $title ?? 'L’Air Pur' ?></title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="<?= base_url('assets/img/LogoPrincipal.png') ?>">
        <link rel="stylesheet" href="assets/css/Style-Home.css">
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" integrity="" crossorigin="">
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
        </head>

    <body>
        <header>
        <!-- Menú de navegación -->
        <?= view('Components/Navbar-Primary') ?>
        
        </header>
    
        <main>
        <?= $content ?? '' ?>
        </main>
    
        <footer class="bg-dark text-light pt-3 pb-3 mt-5">
        <!-- Pie de página -->
        <?= view('Components/Footer') ?>
        </footer>

        <script src="assets/js/bootstrap.bundle.min.js" integrity="" crossorigin=""></script>
    </body>
</html>