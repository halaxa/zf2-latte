<?php

chdir(__DIR__ . '/app'); // index.php convention
require __DIR__ . '/../vendor/autoload.php';
Tester\Environment::setup();

function dd($var, $depth = 3) {
    \Tracy\Debugger::$maxDepth = $depth;
    dump($var);
    die;
}

/**
 * @param string $route
 * @return string
 */
function runRoute($route) {
    $_SERVER_OLD = $_SERVER;
    $_SERVER = require __DIR__ . '/$_SERVER.php';
    if ($route[0] !== '/') {
        $route = '/' . $route;
    }
    $appConfig = require __DIR__ . '/app/application.config.php';
    Zend\Console\Console::overrideIsConsole(false);
    $app = Zend\Mvc\Application::init($appConfig);
    ob_start();
    $app->run();
    $result = ob_get_clean();
    $_SERVER = $_SERVER_OLD;
    return $result;
}
