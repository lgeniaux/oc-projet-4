<section class="mx-auto grid max-w-screen-xl grid-cols-2 gap-12 p-6 py-20">
    <div>
        <h1 class="mb-6 text-5xl font-bold">
            Rejoignez nos lecteurs passionnés
        </h1>

        <p class="mb-8 text-stone-600">
            Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux de la lecture.
        </p>

        <a class="rounded bg-green-600 px-6 py-3 text-white" href="#books">
            Découvrir
        </a>
    </div>

    <img
        class="w-full"
        src="https://images.unsplash.com/photo-1526243741027-444d633d7365?auto=format&fit=crop&w=900&q=80"
        alt="Lecteur entouré de livres"
    >
</section>

<section id="books" class="bg-white p-6 py-16">
    <div class="mx-auto max-w-screen-xl">
        <h2 class="mb-10 text-center text-3xl font-bold">
            Les derniers livres ajoutés
        </h2>

        <?php if (empty($books)): ?>
            <p class="text-center">Aucun livre disponible pour le moment.</p>
        <?php else: ?>
            <div class="grid grid-cols-4 gap-6">
                <?php foreach ($books as $book): ?>
                    <?php
                    $bookTitle = Utils::safe($book->getTitle());
                    $bookAuthor = Utils::safe($book->getAuthor());
                    $ownerUsername = Utils::safe($book->getOwnerUsername());
                    $bookImage = trim((string) $book->getImage());
                    $bookUrl = 'index.php?action=book&id=' . $book->getId();
                    ?>

                    <a class="block border bg-white" href="<?= $bookUrl ?>">
                        <?php if ($bookImage !== ''): ?>
                            <img
                                class="h-48 w-full object-cover"
                                src="<?= Utils::safe($bookImage) ?>"
                                alt="Couverture de <?= $bookTitle ?>"
                            >
                        <?php endif; ?>

                        <div class="p-4">
                            <h3 class="font-bold"><?= $bookTitle ?></h3>
                            <p class="text-sm text-stone-500"><?= $bookAuthor ?></p>
                            <p class="mt-4 text-xs text-stone-400">Vendu par : <?= $ownerUsername ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="mt-10 text-center">
            <a class="rounded bg-green-600 px-6 py-3 text-white" href="index.php?action=books">
                Voir tous les livres
            </a>
        </div>
    </div>
</section>
