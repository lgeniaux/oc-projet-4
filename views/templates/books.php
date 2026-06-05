<section class="mx-auto max-w-5xl p-6 py-12">
    <div class="mb-10 flex items-center justify-between gap-6">
        <h1 class="text-3xl font-bold">Nos livres à l'échange</h1>

        <form class="flex gap-2" method="get" action="index.php">
            <input type="hidden" name="action" value="books">
            <input
                class="border bg-white px-4 py-2"
                type="search"
                name="search"
                placeholder="Rechercher un livre"
                value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>"
            >
            <button class="bg-green-600 px-4 py-2 text-white" type="submit">
                Rechercher
            </button>
        </form>
    </div>

    <?php if (empty($books)): ?>
        <p>Aucun livre disponible pour le moment.</p>
    <?php else: ?>
        <div class="grid grid-cols-4 gap-6">
            <?php foreach ($books as $book): ?>
                <?php
                $bookTitle = htmlspecialchars($book->getTitle(), ENT_QUOTES, 'UTF-8');
                $bookAuthor = htmlspecialchars($book->getAuthor(), ENT_QUOTES, 'UTF-8');
                $ownerUsername = htmlspecialchars($book->getOwnerUsername(), ENT_QUOTES, 'UTF-8');
                $bookImage = trim((string) $book->getImage());
                $bookUrl = 'index.php?action=book&id=' . $book->getId();
                ?>

                <a class="block bg-white" href="<?= $bookUrl ?>">
                    <?php if ($bookImage !== ''): ?>
                        <img
                            class="h-56 w-full object-cover"
                            src="<?= htmlspecialchars($bookImage, ENT_QUOTES, 'UTF-8') ?>"
                            alt="Couverture de <?= $bookTitle ?>"
                        >
                    <?php endif; ?>

                    <div class="p-4">
                        <h2 class="font-bold"><?= $bookTitle ?></h2>
                        <p class="text-sm text-stone-500"><?= $bookAuthor ?></p>
                        <p class="mt-4 text-xs text-stone-400">Vendu par : <?= $ownerUsername ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
