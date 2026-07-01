<section class="auth-page auth-page--register">
    <div class="auth-panel">
        <h1 class="auth-title">Inscription</h1>

        <?php if ($error !== null): ?>
            <p class="auth-error">
                <?= Utils::safe($error) ?>
            </p>
        <?php endif; ?>

        <form class="auth-form" method="post" action="index.php?action=register">
            <div class="auth-fields">
                <div class="auth-field">
                    <label for="username">Pseudo</label>
                    <input
                        id="username"
                        type="text"
                        name="username"
                        value="<?= Utils::safe($username) ?>"
                        required
                    >
                </div>

                <div class="auth-field">
                    <label for="email">Adresse email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="<?= Utils::safe($email) ?>"
                        required
                    >
                </div>

                <div class="auth-field">
                    <label for="password">Mot de passe</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        autocomplete="new-password"
                        required
                    >
                </div>
            </div>

            <button class="btn btn-primary auth-submit" type="submit">
                S'inscrire
            </button>
        </form>

        <p class="auth-switch">
            Déjà inscrit ? <a class="underline" href="index.php?action=login">Connectez-vous</a>
        </p>
    </div>

    <div class="auth-visual">
        <img src="images/auth-visual-auth_visual.png" alt="Livres sur une étagère">
    </div>
</section>
