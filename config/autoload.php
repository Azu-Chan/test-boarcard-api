<?php

spl_autoload_register(function($class){
    $paths = array(
        join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'api']),
        join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'model']),
        join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'service']),
        join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'tests']),
        join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'tests', 'unit'])
    );
    
    foreach($paths as $path){
        $file = join(DIRECTORY_SEPARATOR, [$path, $class.'.php']) ;
        if(file_exists($file))
            return require_once $file;
    }
}); 