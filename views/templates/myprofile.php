<?php
$username = Utils::safe($profileUser->getUsername());
$email = Utils::safe($profileUser->getEmail());
$profileImage = trim((string) $profileUser->getProfileImage());

$createdAt = new DateTime($profileUser->getCreatedAt());
$now = new DateTime();
$yearsSinceRegistration = $now->diff($createdAt)->y;
?>

<section class="mx-auto max-w-screen-xl px-6 py-16">
    <h1 class="mb-10 text-3xl font-bold">Mon compte</h1>

    <?php if ($success): ?>
        <div class="mb-6 rounded border border-green-600 bg-green-50 p-4 text-green-800">
            Profil mis à jour avec succès.
        </div>
    <?php endif; ?>

    <?php if ($error !== null): ?>
        <div class="mb-6 rounded border border-red-600 bg-red-50 p-4 text-red-800">
            <?= Utils::safe($error) ?>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-3 gap-8">

        <aside class="col-span-1 flex flex-col items-center rounded-2xl bg-white px-8 py-12">
            <?php if ($profileImage !== ''): ?>
                <img
                    id="profileImagePreview"
                    class="mb-4 h-40 w-40 rounded-full object-cover"
                    src="<?= Utils::safe($profileImage) ?>"
                    alt="Photo de profil de <?= $username ?>"
                >
            <?php else: ?>
                <div id="profileImagePreview" class="mb-4 flex h-40 w-40 items-center justify-center rounded-full bg-stone-200 text-5xl font-bold text-stone-500">
                    <?= strtoupper(substr($username, 0, 1)) ?>
                </div>
            <?php endif; ?>

            <details class="mb-8">
                <summary class="cursor-pointer text-sm text-stone-500 underline">modifier</summary>
                <div class="mt-2">
                    <input
                        class="w-full rounded border border-stone-300 px-3 py-2 text-sm"
                        type="url"
                        name="profile_image"
                        form="profileForm"
                        placeholder="https://exemple.com/photo.jpg"
                        value="<?= Utils::safe($profileImage) ?>"
                    >
                </div>
            </details>

            <hr class="mb-8 w-2/3 border-stone-200">

            <h2 class="mb-2 text-2xl font-bold"><?= $username ?></h2>
            <p class="mb-10 text-sm text-stone-400">
                Membre depuis <?= $yearsSinceRegistration ?> an<?= $yearsSinceRegistration > 1 ? 's' : '' ?>
            </p>

            <p class="mb-2 text-xs font-bold uppercase tracking-wider text-stone-500">
                Bibliothèque
            </p>
            <p class="flex items-center gap-2 text-stone-700">
                <span class="text-lg">📖</span>
                <span><?= $bookCount ?> livre<?= $bookCount > 1 ? 's' : '' ?></span>
            </p>
        </aside>

        <div class="col-span-2 rounded-2xl bg-white px-10 py-12">
            <h2 class="mb-8 text-xl font-bold">Vos informations personnelles</h2>

            <form id="profileForm" method="post" action="index.php?action=myprofile" class="space-y-6">

                <div>
                    <label class="mb-2 block text-sm text-stone-500" for="email">Adresse email</label>
                    <input
                        class="w-full rounded bg-stone-100 px-4 py-3"
                        type="email"
                        id="email"
                        name="email"
                        value="<?= $email ?>"
                    >
                </div>

                <div>
                    <label class="mb-2 block text-sm text-stone-500" for="password">
                        Mot de passe
                    </label>
                    <input
                        class="w-full rounded bg-stone-100 px-4 py-3"
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Laisser vide pour ne pas changer"
                    >
                </div>

                <div>
                    <label class="mb-2 block text-sm text-stone-500" for="username">Pseudo</label>
                    <input
                        class="w-full rounded bg-stone-100 px-4 py-3"
                        type="text"
                        id="username"
                        name="username"
                        value="<?= $username ?>"
                    >
                </div>

                <button
                    type="submit"
                    class="rounded border-2 border-green-600 px-8 py-3 font-bold text-green-600"
                >
                    Enregistrer
                </button>
            </form>
        </div>

    </div>

    <div class="mt-10 overflow-hidden rounded-2xl bg-white">
        <div class="flex items-center justify-between px-6 py-6">
            <h2 class="text-xl font-bold">Votre bibliothèque</h2>
            <a class="rounded bg-green-600 px-5 py-3 font-bold text-white" href="index.php?action=add-book">
                Ajouter un livre
            </a>
        </div>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs font-bold uppercase tracking-wider text-stone-500">
                    <th class="px-6 py-6">Photo</th>
                    <th class="px-6 py-6">Titre</th>
                    <th class="px-6 py-6">Auteur</th>
                    <th class="px-6 py-6">Description</th>
                    <th class="px-6 py-6">Disponibilité</th>
                    <th class="px-6 py-6">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($books)): ?>
                    <tr>
                        <td class="px-6 py-8 text-center text-stone-400" colspan="6">
                            Aucun livre dans la bibliothèque pour le moment.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($books as $index => $book): ?>
                        <?php
                        $bookTitle = Utils::safe($book->getTitle());
                        $bookAuthor = Utils::safe($book->getAuthor());
                        $bookDescription = Utils::safe((string) $book->getDescription());
                        $bookImage = trim((string) $book->getImage());
                        $rowBg = $index % 2 === 0 ? 'bg-white' : 'bg-stone-50';
                        $isAvailable = $book->isAvailable();
                        $deleteUrl = 'index.php?action=delete-book&id=' . $book->getId();
                        ?>
                        <tr class="<?= $rowBg ?>">
                            <td class="px-6 py-6">
                                <?php if ($bookImage !== ''): ?>
                                    <img
                                        class="h-16 w-12 object-cover"
                                        src="<?= Utils::safe($bookImage) ?>"
                                        alt="Couverture de <?= $bookTitle ?>"
                                    >
                                <?php else: ?>
                                    <div class="flex h-16 w-12 items-center justify-center bg-stone-200 text-xs text-stone-400">
                                        N/A
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-6 text-stone-700"><?= $bookTitle ?></td>
                            <td class="px-6 py-6 text-stone-700"><?= $bookAuthor ?></td>
                            <td class="px-6 py-6 italic text-stone-500"><?= $bookDescription ?></td>
                            <td class="px-6 py-6">
                                <?php if ($isAvailable): ?>
                                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                        disponible
                                    </span>
                                <?php else: ?>
                                    <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                                        non dispo.
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-6">
                                <a class="mr-4 underline" href="index.php?action=edit-book&id=<?= $book->getId() ?>">Éditer</a>
                                <a class="text-red-600 underline" href="<?= $deleteUrl ?>">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
