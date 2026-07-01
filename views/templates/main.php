<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Utils::safe($title) ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light font-body text-dark">

    <header class="site-header">
        <div class="site-header__inner">
            <a class="site-logo" href="index.php?action=home">
                <img class="site-logo__image" src="images/logo-tom-troc.svg" alt="Tom Troc">
            </a>

            <nav class="site-nav-left" aria-label="Navigation principale">
                <a class="<?= ($activeNav ?? '') === 'home' ? 'font-semibold' : 'font-normal' ?> hover:text-primary" href="index.php?action=home">Accueil</a>
                <a class="<?= ($activeNav ?? '') === 'books' ? 'font-semibold' : 'font-normal' ?> hover:text-primary" href="index.php?action=books">Nos livres à l'échange</a>
            </nav>

            <nav class="site-nav-right" aria-label="Navigation utilisateur">
                <a class="flex items-center gap-1.5 <?= ($activeNav ?? '') === 'messages' ? 'font-semibold' : 'font-normal' ?> hover:text-primary" href="index.php?action=messages">
                    <span>Messagerie</span>
                    <?php if ($unreadMessagesCount > 0): ?>
                        <span class="flex h-[15px] min-w-[15px] items-center justify-center rounded-full bg-dark px-1 text-[8px] font-bold text-light">
                            <?= $unreadMessagesCount ?>
                        </span>
                    <?php endif; ?>
                </a>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <a class="flex items-center gap-1.5 <?= ($activeNav ?? '') === 'myprofile' ? 'font-semibold' : 'font-normal' ?> hover:text-primary" href="index.php?action=myprofile">
                        <svg class="h-3 w-2.5" viewBox="0 0 9 13" fill="none" stroke="currentColor" stroke-width="0.7">
                            <circle cx="4.5" cy="3" r="2.5" />
                            <path d="M0.5 12c0-3 2-5 4-5s4 2 4 5" />
                        </svg>
                        <span>Mon compte</span>
                    </a>
                    <a class="hover:text-primary" href="index.php?action=logout">Déconnexion</a>
                <?php else: ?>
                    <a class="<?= ($activeNav ?? '') === 'login' ? 'font-semibold' : 'font-normal' ?> hover:text-primary" href="index.php?action=login">Connexion</a>
                <?php endif; ?>
            </nav>

            <input class="mobile-menu-toggle" type="checkbox" id="mobile-menu-toggle" aria-label="Ouvrir le menu">
            <label class="mobile-menu-button" for="mobile-menu-toggle" aria-hidden="true">
                <svg class="h-[15px] w-[22px]" viewBox="0 0 22 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 1H21M1 7.5H21M1 14H21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                </svg>
            </label>

            <nav class="mobile-nav" aria-label="Menu mobile">
                <a class="<?= ($activeNav ?? '') === 'home' ? 'font-semibold' : 'font-normal' ?> hover:text-primary" href="index.php?action=home">Accueil</a>
                <a class="<?= ($activeNav ?? '') === 'books' ? 'font-semibold' : 'font-normal' ?> hover:text-primary" href="index.php?action=books">Nos livres à l'échange</a>
                <a class="<?= ($activeNav ?? '') === 'messages' ? 'font-semibold' : 'font-normal' ?> hover:text-primary" href="index.php?action=messages">Messagerie</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a class="hover:text-primary" href="index.php?action=myprofile">Mon compte</a>
                    <a class="hover:text-primary" href="index.php?action=logout">Déconnexion</a>
                <?php else: ?>
                    <a class="hover:text-primary" href="index.php?action=login">Connexion</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main>
        <?= $content ?>
    </main>

    <footer class="site-footer">
        <div class="site-footer__inner">
            <a class="hover:text-primary" href="#">Politique de confidentialité</a>
            <a class="hover:text-primary" href="#">Mentions légales</a>
            <span>Tom Troc©</span>
            <img class="site-footer__logo" src="images/footer-logo-footer_logo.svg" alt="">
        </div>
    </footer>
</body>
</html>
