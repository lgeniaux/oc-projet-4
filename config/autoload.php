<?php

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
