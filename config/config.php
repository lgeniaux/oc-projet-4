<?php

// Chemin absolu vers la racine du projet.
define('ROOT_PATH', dirname(__DIR__) . '/');

// Chargement simple du fichier .env local.
$envPath = ROOT_PATH . '.env';

if (file_exists($envPath)) {
    $envLines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($envLines as $envLine) {
        if (str_starts_with($envLine, '#')) {
            continue;
        }

        $parts = explode('=', $envLine, 2);

        if (count($parts) !== 2) {
            continue;
        }

        $name = trim($parts[0]);
        $value = trim($parts[1]);

        putenv($name . '=' . $value);
        $_ENV[$name] = $value;
    }
}

// Chemin vers le dossier qui contient les vues.
define('TEMPLATE_VIEW_PATH', ROOT_PATH . 'views/templates/');

// Chemin vers le template principal du site.
define('MAIN_VIEW_PATH', TEMPLATE_VIEW_PATH . 'main.php');
