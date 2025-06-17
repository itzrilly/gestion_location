<?php
spl_autoload_register(function ($class_name) {
    $paths = [
        'models/' . $class_name . '.php',
        'controllers/' . $class_name . '.php',
        'config/' . $class_name . '.php'
    ];
    
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});