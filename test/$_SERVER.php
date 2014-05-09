<?php

return array (
    'DOCUMENT_ROOT' => realpath(getcwd() . '/public'),
    'REMOTE_ADDR' => '127.0.0.1',
    'REMOTE_PORT' => '61904',
    'SERVER_SOFTWARE' => 'PHP 5.5.12 Development Server',
    'SERVER_PROTOCOL' => 'HTTP/1.1',
    'SERVER_NAME' => '127.0.0.1',
    'SERVER_PORT' => '8080',
    'REQUEST_URI' => $route, // $route taken from parent script
    'REQUEST_METHOD' => 'GET',
    'SCRIPT_NAME' => '/index.php',
    'SCRIPT_FILENAME' => realpath(getcwd() . '/public/index.php'),
    'PATH_INFO' => $route,
    'PHP_SELF' => '/index.php'.$route,
    'HTTP_HOST' => '127.0.0.1:8080',
    'HTTP_CONNECTION' => 'keep-alive',
    'HTTP_CACHE_CONTROL' => 'max-age=0',
    'HTTP_ACCEPT' => 'text/html',
    'HTTP_USER_AGENT' => 'Console tester',
    'HTTP_ACCEPT_ENCODING' => '',
    'HTTP_ACCEPT_LANGUAGE' => 'en-US',
    'HTTP_COOKIE' => '',
    'REQUEST_TIME_FLOAT' => $time = microtime(1),
    'REQUEST_TIME' => (int) $time,
);
