<?php

return array(
    'modules' => array(
        'Zf2Latte',
        'Application'
    ),

    'module_listener_options' => array(
        'module_paths' => array(
            'Zf2Latte' => __DIR__ . '/../Module.php',
            __DIR__ . '/module'
        ),
    ),
);
