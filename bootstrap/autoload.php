<?php 

require_once __DIR__ . '/../vendor/autoload.php';

spl_autoload_register(function(string $className){


    $className = substr($className, 4);

    $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);

    $classPath = __DIR__ . '/../classes/' . $className . '.php';

    if (file_exists($classPath)){
        require_once($classPath);
    }

});