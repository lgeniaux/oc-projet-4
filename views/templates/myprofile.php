<?php
$username = Utils::safe($profileUser->getUsername());
$email = Utils::safe($profileUser->getEmail());
$profileImage = trim((string) $profileUser->getProfileImage());

$createdAt = new DateTime($profileUser->getCreatedAt());
$now = new DateTime();
$yearsSinceRegistration = $now->diff($createdAt)->y;
?>

<section class="profile-page">
    <div class="profile-page__inner">
        <h1 class="profile-page__title">Mon compte</h1>

        <?php if ($success): ?>
            <div class="profile-alert profile-alert--success">Profil mis à jour avec succès.</div>
        <?php endif; ?>

        <?php if ($error !== null): ?>
            <div class="profile-alert profile-alert--error"><?= Utils::safe($error) ?></div>
        <?php endif; ?>

        <div class="profile-top-grid">
            <aside class="profile-card">
                <div id="profileImagePreview" class="profile-avatar">
                    <?php if ($profileImage !== ''): ?>
                        <img src="<?= Utils::safe($profileImage) ?>" alt="Photo de profil de <?= $username ?>">
                    <?php else: ?>
                        <?= strtoupper(substr($username, 0, 1)) ?>
                    <?php endif; ?>
                </div>

                <details class="profile-image-field">
                    <summary>modifier</summary>
                    <input
                        type="url"
                        name="profile_image"
                        form="profileForm"
                        placeholder="https://exemple.com/photo.jpg"
                        value="<?= Utils::safe($profileImage) ?>"
                    >
                </details>

                <div class="profile-separator"></div>

                <h2 class="profile-name"><?= $username ?></h2>
                <p class="profile-member-since">Membre depuis <?= $yearsSinceRegistration ?> an<?= $yearsSinceRegistration > 1 ? 's' : '' ?></p>

                <p class="profile-library-label">Bibliothèque</p>
                <p class="profile-book-count"><span aria-hidden="true">📖</span><span><?= $bookCount ?> livre<?= $bookCount > 1 ? 's' : '' ?></span></p>
            </aside>

            <div class="profile-info-card">
                <h2 class="profile-info-title">Vos informations personnelles</h2>

                <form id="profileForm" class="profile-form" method="post" action="index.php?action=myprofile">
                    <div class="profile-form__fields">
                        <div class="profile-form__field">
                            <label for="email">Adresse email</label>
                            <input type="email" id="email" name="email" value="<?= $email ?>">
                        </div>

                        <div class="profile-form__field">
                            <label for="password">Mot de passe</label>
                            <input type="password" id="password" name="password" placeholder="•••••••••">
                        </div>

                        <div class="profile-form__field">
                            <label for="username">Pseudo</label>
                            <input type="text" id="username" name="username" value="<?= $username ?>">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-secondary profile-save-button">Enregistrer</button>
                </form>
            </div>
        </div>

        <div class="profile-library profile-library--own">
            <table class="profile-table">
                <thead>
                    <tr>
                        <th class="profile-table__photo">Photo</th>
                        <th class="profile-table__title">Titre</th>
                        <th class="profile-table__author">Auteur</th>
                        <th class="profile-table__description">Description</th>
                        <th class="profile-table__status">Disponibilité</th>
                        <th class="profile-table__action">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($books)): ?>
                        <tr>
                            <td class="py-8 text-center text-muted" colspan="6">Aucun livre dans la bibliothèque pour le moment.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($books as $book): ?>
                            <?php
                            $bookTitle = Utils::safe($book->getTitle());
                            $bookAuthor = Utils::safe($book->getAuthor());
                            $bookDescription = Utils::safe((string) $book->getDescription());
                            $bookImage = trim((string) $book->getImage());
                            $isAvailable = $book->isAvailable();
                            $deleteUrl = 'index.php?action=delete-book&id=' . $book->getId();
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
                                <td class="profile-table__status">
                                    <span class="profile-status <?= $isAvailable ? 'profile-status--available' : 'profile-status--unavailable' ?>">
                                        <?= $isAvailable ? 'disponible' : 'non dispo.' ?>
                                    </span>
                                </td>
                                <td class="profile-table__action">
                                    <span class="profile-actions">
                                        <a href="index.php?action=edit-book&id=<?= $book->getId() ?>">Éditer</a>
                                        <a class="profile-actions__delete" href="<?= $deleteUrl ?>">Supprimer</a>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
