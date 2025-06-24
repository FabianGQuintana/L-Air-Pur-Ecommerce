<!DOCTYPE html>
<html lang="es">
<head>
    <title><?= $title ?? 'L’Air Pur' ?></title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/LogoPrincipal.png') ?>">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-icons/bootstrap-icons.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">

    <!-- Google Fonts & Bootstrap Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@600&family=Open+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>
    <header>
        <!-- Menú de navegación -->
        <?= view('Components/Navbar_admin') ?>
    </header>

    <main>
        <?= $content ?? '' ?>
    </main>


    <!-- JS -->
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>
</html>