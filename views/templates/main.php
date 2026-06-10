<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Utils::safe($title) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-100 text-stone-900">
    <header class="mx-auto flex max-w-screen-xl justify-between p-6">
        <a class="font-bold text-green-600" href="index.php?action=home">Tom Troc</a>

        <nav class="flex gap-6">
            <a href="index.php?action=home">Accueil</a>
            <a href="index.php?action=books">Nos livres à l'échange</a>
            <a href="#">Messagerie</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="index.php?action=myprofile">Mon compte</a>
                <a href="index.php?action=logout">Déconnexion</a>
            <?php else: ?>
                <a href="index.php?action=login">Connexion</a>
            <?php endif; ?>
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
