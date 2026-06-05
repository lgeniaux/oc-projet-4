<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-100 text-stone-900">
    <header class="mx-auto flex max-w-5xl justify-between p-6">
        <a class="font-bold text-green-600" href="index.php?action=home">Tom Troc</a>

        <nav class="flex gap-6">
            <a href="index.php?action=home">Accueil</a>
            <a href="#">Nos livres à l'échange</a>
            <a href="#">Messagerie</a>
            <a href="#">Mon compte</a>
            <a href="#">Connexion</a>
        </nav>
    </header>

    <main>
        <?= $content ?>
    </main>

    <footer class="bg-white p-6 text-center text-sm text-stone-500">
        <p>Tom Troc ©</p>
    </footer>
</body>
</html>
