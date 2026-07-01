<section class="home-hero">
    <div class="home-hero__copy">
        <h1 class="home-hero__title">
            Rejoignez nos lecteurs passionnés
        </h1>

        <p class="home-hero__text">
            Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux de la lecture. Nous croyons en la magie du partage de connaissances et d'histoires à travers les livres.
        </p>

        <div class="home-hero__button">
            <a class="btn btn-primary" href="index.php?action=books">Découvrir</a>
        </div>
    </div>

    <div>
        <img class="home-hero__image" src="images/hero.jpg" alt="Lecteur entouré de livres">
        <p class="home-hero__credit">Hamza</p>
    </div>
</section>

<section class="home-latest">
    <div>
        <h2 class="section-title text-center">
            Les derniers livres ajoutés
        </h2>

        <?php if (empty($books)): ?>
            <p class="mt-12 text-center text-muted">Aucun livre disponible pour le moment.</p>
        <?php else: ?>
            <div class="home-latest__grid">
                <?php foreach ($books as $book): ?>
                    <?php
                    $bookTitle = Utils::safe($book->getTitle());
                    $bookAuthor = Utils::safe($book->getAuthor());
                    $ownerUsername = Utils::safe($book->getOwnerUsername());
                    $bookImage = trim((string) $book->getImage());
                    $bookUrl = 'index.php?action=book&id=' . $book->getId();
                    ?>

                    <a class="book-card" href="<?= $bookUrl ?>">
                        <?php if ($bookImage !== ''): ?>
                            <img class="book-card__cover" src="<?= Utils::safe($bookImage) ?>" alt="Couverture de <?= $bookTitle ?>">
                        <?php else: ?>
                            <div class="book-card__empty-cover"></div>
                        <?php endif; ?>

                        <div class="book-card__body">
                            <h3 class="book-card__title"><?= $bookTitle ?></h3>
                            <p class="book-card__author"><?= $bookAuthor ?></p>

                            <div class="book-card__seller">
                                <span>Vendu par :</span>
                                <span><?= $ownerUsername ?></span>
                            </div>

                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="mt-12 text-center">
            <a class="btn btn-primary" href="index.php?action=books">
                Voir tous les livres
            </a>
        </div>
    </div>
</section>

<section class="home-steps">
    <h2 class="section-title text-center">
        Comment ça marche ?
    </h2>

    <p class="home-steps__intro">
        Échanger des livres avec TomTroc c'est simple et amusant ! Suivez ces étapes pour commencer :
    </p>

    <div class="home-steps__grid">
        <div class="step-card">
            <p class="text-sm leading-relaxed text-dark">Inscrivez-vous gratuitement sur notre plateforme.</p>
        </div>
        <div class="step-card">
            <p class="text-sm leading-relaxed text-dark">Ajoutez les livres que vous souhaitez échanger à votre profil.</p>
        </div>
        <div class="step-card">
            <p class="text-sm leading-relaxed text-dark">Parcourez les livres disponibles chez d'autres membres.</p>
        </div>
        <div class="step-card">
            <p class="text-sm leading-relaxed text-dark">Proposez un échange et discutez avec d'autres passionnés de lecture.</p>
        </div>
    </div>

    <div class="mt-12 text-center">
        <a class="btn btn-secondary" href="index.php?action=books">
            Voir tous les livres
        </a>
    </div>
</section>

<div class="home-values-image">
    <img src="images/values-bg.jpg" alt="">
</div>

<section class="home-values">
    <h2 class="section-title">
        Nos valeurs
    </h2>

    <div class="home-values__text">
        <p>
            Chez Tom Troc, nous mettons l'accent sur le partage, la découverte et la communauté. Nos valeurs sont ancrées dans notre passion pour les livres et notre désir de créer des liens entre les lecteurs. Nous croyons en la puissance des histoires pour rassembler les gens et inspirer des conversations enrichissantes.
        </p>
        <p>
            Notre association a été fondée avec une conviction profonde : chaque livre mérite d'être lu et partagé.
        </p>
        <p>
            Nous sommes passionnés par la création d'une plateforme conviviale qui permet aux lecteurs de se connecter, de partager leurs découvertes littéraires et d'échanger des livres qui attendent patiemment sur les étagères.
        </p>
    </div>
</section>

<section class="home-signature">
    <div class="home-signature__inner">
        <p class="home-signature__text">L'équipe Tom Troc</p>
        <img class="home-signature__image" src="images/signature-tom-troc.svg" alt="Signature Tom Troc">
    </div>
</section>
