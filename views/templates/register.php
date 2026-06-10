<section class="mx-auto max-w-screen-xl px-6 py-20">
    <div class="max-w-sm">
        <h1 class="mb-12 text-4xl font-bold">Inscription</h1>

        <?php if ($error !== null): ?>
            <p class="mb-6 text-red-600">
                <?= Utils::safe($error) ?>
            </p>
        <?php endif; ?>

        <form method="post" action="index.php?action=register">
            <label class="mb-2 block text-stone-500" for="username">Pseudo</label>
            <input
                class="mb-8 w-full rounded border bg-white px-4 py-3"
                id="username"
                type="text"
                name="username"
                value="<?= Utils::safe($username) ?>"
                required
            >

            <label class="mb-2 block text-stone-500" for="email">Adresse email</label>
            <input
                class="mb-8 w-full rounded border bg-white px-4 py-3"
                id="email"
                type="email"
                name="email"
                value="<?= Utils::safe($email) ?>"
                required
            >

            <label class="mb-2 block text-stone-500" for="password">Mot de passe</label>
            <input
                class="mb-8 w-full rounded border bg-white px-4 py-3"
                id="password"
                type="password"
                name="password"
                required
            >

            <button class="w-full rounded bg-green-600 px-6 py-4 font-bold text-white" type="submit">
                S'inscrire
            </button>
        </form>

        <p class="mt-8">
            Déjà inscrit ? <a class="underline" href="index.php?action=login">Connectez-vous</a>
        </p>
    </div>
</section>
