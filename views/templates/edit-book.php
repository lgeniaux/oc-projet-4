<?php
$titleValue = $formValues['title'];
$authorValue = $formValues['author'];
$descriptionValue = $formValues['description'];
$imageValue = $formValues['image'];
$statusValue = $formValues['status'];
?>

<section class="mx-auto max-w-screen-xl px-6 py-12">
    <a class="mb-8 inline-block text-sm text-stone-400" href="index.php?action=myprofile">&lt; retour</a>

    <h1 class="mb-8 text-3xl font-bold"><?= $pageTitle ?></h1>

    <?php if ($error !== null): ?>
        <div class="mb-6 rounded border border-red-600 bg-red-50 p-4 text-red-800">
            <?= Utils::safe($error) ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= Utils::safe($formAction) ?>" class="rounded-2xl bg-white px-10 py-12">
        <div class="grid grid-cols-1 gap-10 lg:grid-cols-2 lg:gap-20">
            <div>
                <label class="mb-3 block text-sm text-stone-400" for="image">Photo</label>

                <?php if ($imageValue !== ''): ?>
                    <img
                        class="mb-5 h-[430px] w-full object-cover"
                        src="<?= Utils::safe($imageValue) ?>"
                        alt="Couverture de <?= Utils::safe($titleValue) ?>"
                    >
                <?php else: ?>
                    <div class="mb-5 flex h-[430px] w-full items-center justify-center bg-stone-100 text-stone-400">
                        Aucune photo
                    </div>
                <?php endif; ?>

                <details class="text-right">
                    <summary class="cursor-pointer text-sm text-stone-600 underline">Modifier la photo</summary>
                    <div class="mt-3">
                        <input
                            class="w-full rounded bg-slate-100 px-4 py-3 text-left"
                            type="url"
                            id="image"
                            name="image"
                            placeholder="https://exemple.com/image.jpg"
                            value="<?= Utils::safe($imageValue) ?>"
                        >
                    </div>
                </details>
            </div>

            <div class="space-y-8">
                <div>
                    <label class="mb-3 block text-sm text-stone-400" for="title">Titre</label>
                    <input
                        class="w-full rounded bg-slate-100 px-4 py-4"
                        type="text"
                        id="title"
                        name="title"
                        value="<?= Utils::safe($titleValue) ?>"
                    >
                </div>

                <div>
                    <label class="mb-3 block text-sm text-stone-400" for="author">Auteur</label>
                    <input
                        class="w-full rounded bg-slate-100 px-4 py-4"
                        type="text"
                        id="author"
                        name="author"
                        value="<?= Utils::safe($authorValue) ?>"
                    >
                </div>

                <div>
                    <label class="mb-3 block text-sm text-stone-400" for="description">Commentaire</label>
                    <textarea
                        class="min-h-72 w-full rounded bg-slate-100 px-4 py-4"
                        id="description"
                        name="description"
                    ><?= Utils::safe($descriptionValue) ?></textarea>
                </div>

                <div>
                    <label class="mb-3 block text-sm text-stone-400" for="status">Disponibilité</label>
                    <select class="w-full rounded bg-slate-100 px-4 py-4" id="status" name="status">
                        <option value="available" <?= $statusValue === 'available' ? 'selected' : '' ?>>disponible</option>
                        <option value="unavailable" <?= $statusValue === 'unavailable' ? 'selected' : '' ?>>non disponible</option>
                    </select>
                </div>

                <button class="w-full rounded bg-green-600 px-6 py-4 font-bold text-white lg:w-3/4" type="submit">
                    Valider
                </button>
            </div>
        </div>
    </form>
</section>
