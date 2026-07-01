<?php
$bookTitle = Utils::safe($book->getTitle());
$bookAuthor = Utils::safe($book->getAuthor());
$bookDescription = nl2br(Utils::safe((string) $book->getDescription()));
$ownerUsername = Utils::safe($book->getOwnerUsername());
$bookImage = trim((string) $book->getImage());
?>

<section class="book-breadcrumb">
    <a href="index.php?action=books">Nos livres</a>
    <span>&gt;</span>
    <span><?= $bookTitle ?></span>
</section>

<section class="book-detail">
    <div class="book-detail__image-panel">
        <?php if ($bookImage !== ''): ?>
            <img class="book-detail__image" src="<?= Utils::safe($bookImage) ?>" alt="Couverture de <?= $bookTitle ?>">
        <?php endif; ?>
    </div>

    <div class="book-detail__content">
        <h1 class="book-detail__title"><?= $bookTitle ?></h1>
        <p class="book-detail__author">par <?= $bookAuthor ?></p>

        <div class="book-detail__rule"></div>

        <h2 class="book-detail__label book-detail__description-label">Description</h2>
        <p class="book-detail__description"><?= $bookDescription ?></p>

        <h2 class="book-detail__label book-detail__owner-label">Propriétaire</h2>
        <a
            class="book-owner-pill"
            href="index.php?action=profile&id=<?= $book->getUserId() ?>"
        >
            <span class="book-owner-pill__avatar">
                <?= strtoupper(substr($ownerUsername, 0, 1)) ?>
            </span>
            <span><?= $ownerUsername ?></span>
        </a>

        <a
            class="btn btn-primary book-detail__cta"
            href="index.php?action=messages&user=<?= $book->getUserId() ?>"
        >
            Envoyer un message
        </a>
    </div>
</section>
