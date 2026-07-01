<?php
$username = Utils::safe($profileUser->getUsername());
$profileImage = trim((string) $profileUser->getProfileImage());

$createdAt = new DateTime($profileUser->getCreatedAt());
$now = new DateTime();
$yearsSinceRegistration = $now->diff($createdAt)->y;

$messageUrl = 'index.php?action=messages&user=' . $profileUser->getId();
?>

<section class="profile-page profile-page--public">
    <div class="profile-page__inner profile-layout">
        <aside class="profile-card">
            <div class="profile-avatar">
                <?php if ($profileImage !== ''): ?>
                    <img src="<?= Utils::safe($profileImage) ?>" alt="Photo de profil de <?= $username ?>">
                <?php else: ?>
                    <?= strtoupper(substr($username, 0, 1)) ?>
                <?php endif; ?>
            </div>

            <div class="profile-separator"></div>

            <h1 class="profile-name"><?= $username ?></h1>
            <p class="profile-member-since">Membre depuis <?= $yearsSinceRegistration ?> an<?= $yearsSinceRegistration > 1 ? 's' : '' ?></p>

            <p class="profile-library-label">Bibliothèque</p>
            <p class="profile-book-count"><span aria-hidden="true">📖</span><span><?= $bookCount ?> livre<?= $bookCount > 1 ? 's' : '' ?></span></p>

            <a class="btn btn-secondary profile-message-button" href="<?= $messageUrl ?>">Écrire un message</a>
        </aside>

        <div class="profile-library">
            <table class="profile-table">
                <thead>
                    <tr>
                        <th class="profile-table__photo">Photo</th>
                        <th class="profile-table__title">Titre</th>
                        <th class="profile-table__author">Auteur</th>
                        <th class="profile-table__description">Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($books)): ?>
                        <tr>
                            <td class="py-8 text-center text-muted" colspan="4">Aucun livre dans la bibliothèque pour le moment.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($books as $book): ?>
                            <?php
                            $bookTitle = Utils::safe($book->getTitle());
                            $bookAuthor = Utils::safe($book->getAuthor());
                            $bookDescription = Utils::safe((string) $book->getDescription());
                            $bookImage = trim((string) $book->getImage());
                            ?>
                            <tr>
                                <td class="profile-table__photo">
                                    <?php if ($bookImage !== ''): ?>
                                        <img class="profile-table__cover" src="<?= Utils::safe($bookImage) ?>" alt="Couverture de <?= $bookTitle ?>">
                                    <?php else: ?>
                                        <div class="profile-table__cover bg-[#D9D9D9]"></div>
                                    <?php endif; ?>
                                </td>
                                <td class="profile-table__title"><?= $bookTitle ?></td>
                                <td class="profile-table__author"><?= $bookAuthor ?></td>
                                <td class="profile-table__description"><span class="profile-table__description-text"><?= $bookDescription ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
