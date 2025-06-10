<!DOCTYPE html>
<html lang="es">
<head>
    <title><?= $title ?? 'L’Air Pur' ?></title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/LogoPrincipal.png') ?>">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/Style-Home.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-icons/bootstrap-icons.css') ?>">
    

    <!-- Google Fonts & Bootstrap Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <!-- Menú de navegación -->
        <?= view('Components/Navbar-Primary') ?>
    </header>

    <main>
        <?= isset($content) ? $content : $this->renderSection('content') ?>
    </main>


    <footer class="bg-dark text-light pt-3 pb-3 mt-5">
        <!-- Pie de página -->
        <?= view('Components/Footer') ?>
    </footer>

    <!-- JS -->
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <?= $this->renderSection('popup') ?>
</body>
</html>
