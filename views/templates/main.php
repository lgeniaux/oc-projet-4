<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav>
            <a href="index.php?action=home">TomTroc</a>
        </nav>
    </header>

    <main>
        <?= $content ?>
    </main>

    <footer>
        <p>TomTroc</p>
    </footer>
</body>
</html>
