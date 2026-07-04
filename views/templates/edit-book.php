<?php
$titleValue = $formValues['title'];
$authorValue = $formValues['author'];
$descriptionValue = $formValues['description'];
$imageValue = $formValues['image'];
$statusValue = $formValues['status'];
?>

<section class="book-form-page">
    <div class="book-form-page__inner">
        <a class="book-form-back" href="index.php?action=myprofile"><span aria-hidden="true">&larr;</span> retour</a>

        <h1 class="book-form-title"><?= $pageTitle ?></h1>

        <?php if ($error !== null): ?>
            <div class="book-form-alert">
                <?= Utils::safe($error) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= Utils::safe($formAction) ?>" class="book-form-panel">
            <?= Utils::csrfInput() ?>

            <div class="book-form-grid">
                <div class="book-form-photo">
                    <label class="book-form-label" for="image">Photo</label>

                    <?php if ($imageValue !== ''): ?>
                        <img
                            class="book-form-cover"
                            src="<?= Utils::safe($imageValue) ?>"
                            alt="Couverture de <?= Utils::safe($titleValue) ?>"
                        >
                    <?php else: ?>
                        <div class="book-form-cover book-form-cover--empty">
                            Aucune photo
                        </div>
                    <?php endif; ?>

                    <details class="book-form-photo-field">
                        <summary>Modifier la photo</summary>
                        <input
                            type="url"
                            id="image"
                            name="image"
                            placeholder="https://exemple.com/image.jpg"
                            value="<?= Utils::safe($imageValue) ?>"
                        >
                    </details>
                </div>

                <div class="book-form-fields">
                    <div class="book-form-field">
                        <label class="book-form-label" for="title">Titre</label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            value="<?= Utils::safe($titleValue) ?>"
                        >
                    </div>

                    <div class="book-form-field">
                        <label class="book-form-label" for="author">Auteur</label>
                        <input
                            type="text"
                            id="author"
                            name="author"
                            value="<?= Utils::safe($authorValue) ?>"
                        >
                    </div>

                    <div class="book-form-field">
                        <label class="book-form-label" for="description">Commentaire</label>
                        <textarea
                            id="description"
                            name="description"
                        ><?= Utils::safe($descriptionValue) ?></textarea>
                    </div>

                    <div class="book-form-field">
                        <label class="book-form-label" for="status">Disponibilité</label>
                        <select id="status" name="status">
                            <option value="available" <?= $statusValue === 'available' ? 'selected' : '' ?>>disponible</option>
                            <option value="unavailable" <?= $statusValue === 'unavailable' ? 'selected' : '' ?>>non disponible</option>
                        </select>
                    </div>

                    <button class="btn btn-primary book-form-submit" type="submit">
                        Valider
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>
