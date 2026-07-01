<section class="books-page">
    <div class="books-page__header">
        <h1 class="books-page__title">Nos livres à l'échange</h1>

        <form class="books-search" method="get" action="index.php">
            <input type="hidden" name="action" value="books">
            <svg class="books-search__icon" viewBox="0 0 18 18" fill="none" aria-hidden="true">
                <path d="M8.25 14.5a6.25 6.25 0 1 0 0-12.5 6.25 6.25 0 0 0 0 12.5ZM13 13l3 3" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" />
            </svg>
            <input
                class="books-search__input"
                type="search"
                name="search"
                aria-label="Rechercher un livre"
                placeholder="Rechercher un livre"
                value="<?= Utils::safe($search) ?>"
            >
            <button class="books-search__submit" type="submit">
                Rechercher
            </button>
        </form>
    </div>

    <?php if (empty($books)): ?>
        <p class="books-empty">Aucun livre disponible pour le moment.</p>
    <?php else: ?>
        <div class="books-grid">
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
                        <h2 class="book-card__title"><?= $bookTitle ?></h2>
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
</section>
