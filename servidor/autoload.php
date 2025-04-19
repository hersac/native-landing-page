<?php

function autoload($class)
{
    $file = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';

    if (file_exists($file)) {
        include_once $file;
    }
}

spl_autoload_register('autoload');
