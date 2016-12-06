<?php
error_reporting(E_ALL);
require_once 'Config.class.php';

// Core classes autoloader
spl_autoload_register(function ($class) {
    $searchPaths = [Config::CORE_PATH, Config::MODEL_PATH];
    foreach($searchPaths as $dir) {
        $path = $dir . DIRECTORY_SEPARATOR . $class . '.class.php';
        if (file_exists($path)) {
            include $path;
            break;
        }
    }
});

// This line makes it all <3
Router::route();
