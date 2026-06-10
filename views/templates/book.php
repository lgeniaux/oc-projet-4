<?php
$bookTitle = Utils::safe($book->getTitle());
$bookAuthor = Utils::safe($book->getAuthor());
$bookDescription = nl2br(Utils::safe((string) $book->getDescription()));
$ownerUsername = Utils::safe($book->getOwnerUsername());
$bookImage = trim((string) $book->getImage());
?>

<section class="mx-auto max-w-screen-xl px-6 py-8 text-sm text-stone-400">
    <a href="index.php?action=books">Nos livres</a>
    <span>&gt;</span>
    <span><?= $bookTitle ?></span>
</section>

<section class="grid grid-cols-2 bg-stone-50">
    <div>
        <?php if ($bookImage !== ''): ?>
            <img
                class="h-full min-h-[650px] w-full object-cover"
                src="<?= Utils::safe($bookImage) ?>"
                alt="Couverture de <?= $bookTitle ?>"
            >
        <?php endif; ?>
    </div>

    <div class="px-20 py-16">
        <h1 class="mb-3 text-4xl font-bold"><?= $bookTitle ?></h1>
        <p class="mb-10 text-lg text-stone-400">par <?= $bookAuthor ?></p>

        <div class="mb-10 h-px w-8 bg-stone-400"></div>

        <h2 class="mb-4 text-xs font-bold uppercase tracking-wider">Description</h2>
        <p class="mb-10 leading-relaxed text-stone-700"><?= $bookDescription ?></p>

        <h2 class="mb-4 text-xs font-bold uppercase tracking-wider">Propriétaire</h2>
        <a
            class="mb-14 inline-flex items-center gap-4 rounded-full bg-white px-5 py-3 text-stone-700"
            href="index.php?action=profile&id=<?= $book->getUserId() ?>"
        >
            <span class="flex h-12 w-12 items-center justify-center rounded-full bg-stone-200 text-lg font-bold text-stone-500">
                <?= strtoupper(substr($ownerUsername, 0, 1)) ?>
            </span>
            <span><?= $ownerUsername ?></span>
        </a>

        <a
            class="block rounded bg-green-600 px-6 py-4 text-center font-bold text-white"
            href="index.php?action=messages&user=<?= $book->getUserId() ?>"
        >
            Envoyer un message
        </a>
    </div>
</section>
