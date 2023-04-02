<?php

(PHP_SAPI !== 'cli' || isset($_SERVER['HTTP_USER_AGENT'])) && die('cli only');

require 'config/autoload.php';

echo 'begin tests' . PHP_EOL . PHP_EOL;

echo 'test class ComputePathServiceTests' . PHP_EOL . PHP_EOL;

$class = new ComputePathServiceTests();
$methods = get_class_methods($class);

foreach ($methods as $method) {
    try {
        $class->$method();
        echo 'test method ' . $method . ' OK' . PHP_EOL;
    } catch (\Exception $e) {
        echo 'test method ' . $method . ' KO: ' . $e->getMessage() . PHP_EOL;
    }
}

echo PHP_EOL . 'test class ComputePathTests' . PHP_EOL . PHP_EOL;

$class = new ComputePathTests();
$methods = get_class_methods($class);

foreach ($methods as $method) {
    try {
        $class->$method();
        echo 'test method ' . $method . ' OK' . PHP_EOL;
    } catch (\Exception $e) {
        echo 'test method ' . $method . ' KO: ' . $e->getMessage() . PHP_EOL;
    }
}

echo PHP_EOL . 'end tests';