<?php
spl_autoload_register(function ($class) {
    // Base directory for API classes
    $baseDir = __DIR__;

    // Only handle classes in the API namespace
    if (strpos($class, 'API\\') !== 0) {
        return;
    }

    // Remove API\ namespace prefix
    $relativeClass = substr($class, 4);

    // Convert namespace separators to directory separators
    $file = $baseDir . '/' . str_replace('\\', '/', $relativeClass) . '.php';

    // If the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});
