<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= esc($title ?? 'Login') ?> - L’Air Pur</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-icons/bootstrap-icons.css') ?>">
</head>
<body>

    <main>
        <?= $content ?? '' ?>
    </main>

    <footer class="bg-dark text-light pt-1 pb-1 mt-1">
        <!-- Pie de página -->
        <?= view('Components/Footer') ?>
    </footer>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
