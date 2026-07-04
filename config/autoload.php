<?php

/**
 * Charge automatiquement les classes du projet depuis leurs dossiers.
 * @param string $className : le nom de la classe demandée.
 * @return void
 */
spl_autoload_register(function (string $className) {
    $folders = [
        'controllers/',
        'models/',
        'services/',
        'views/',
    ];

    foreach ($folders as $folder) {
        $filePath = ROOT_PATH . $folder . $className . '.php';

        if (file_exists($filePath)) {
            require_once $filePath;
            return;
        }
    }
});
