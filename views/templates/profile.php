<?php
$username = Utils::safe($profileUser->getUsername());
$profileImage = trim((string) $profileUser->getProfileImage());

$createdAt = new DateTime($profileUser->getCreatedAt());
$now = new DateTime();
$yearsSinceRegistration = $now->diff($createdAt)->y;

$messageUrl = 'index.php?action=messages&user=' . $profileUser->getId();
?>

<section class="mx-auto max-w-screen-xl px-6 py-16">
    <div class="grid grid-cols-3 gap-8">

        <aside class="col-span-1 flex flex-col items-center rounded-2xl bg-white px-8 py-12">
            <?php if ($profileImage !== ''): ?>
                <img
                    class="mb-8 h-40 w-40 rounded-full object-cover"
                    src="<?= Utils::safe($profileImage) ?>"
                    alt="Photo de profil de <?= $username ?>"
                >
            <?php else: ?>
                <div class="mb-8 flex h-40 w-40 items-center justify-center rounded-full bg-stone-200 text-5xl font-bold text-stone-500">
                    <?= strtoupper(substr($username, 0, 1)) ?>
                </div>
            <?php endif; ?>

            <hr class="mb-8 w-2/3 border-stone-200">

            <h1 class="mb-2 text-2xl font-bold"><?= $username ?></h1>
            <p class="mb-10 text-sm text-stone-400">
                Membre depuis <?= $yearsSinceRegistration ?> an<?= $yearsSinceRegistration > 1 ? 's' : '' ?>
            </p>

            <p class="mb-2 text-xs font-bold uppercase tracking-wider text-stone-500">
                Bibliothèque
            </p>
            <p class="mb-10 flex items-center gap-2 text-stone-700">
                <span class="text-lg">📖</span>
                <span><?= $bookCount ?> livre<?= $bookCount > 1 ? 's' : '' ?></span>
            </p>

            <a
                class="w-full rounded border-2 border-green-600 px-6 py-3 text-center font-bold text-green-600"
                href="<?= $messageUrl ?>"
            >
                Écrire un message
            </a>
        </aside>

        <div class="col-span-2 overflow-hidden rounded-2xl bg-white">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs font-bold uppercase tracking-wider text-stone-500">
                        <th class="px-6 py-6">Photo</th>
                        <th class="px-6 py-6">Titre</th>
                        <th class="px-6 py-6">Auteur</th>
                        <th class="px-6 py-6">Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($books)): ?>
                        <tr>
                            <td class="px-6 py-8 text-center text-stone-400" colspan="4">
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
                                <td class="px-6 py-6 italic text-stone-500">
                                    <?= $bookDescription ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</section>
