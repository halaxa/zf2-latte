<?php

return array(

    'service_manager' => require __DIR__ . '/services.config.php',

    'view_manager' => array(
        'strategies' => array('Zf2Latte\LatteStrategy')
    ),

    'zf2_latte' => array(

        // File extension of latte templates without the comma.
        // Templates are resolved as Latte by this extension.
        'extension' => 'latte',

        // Disables ZF2 layout system. You can leverage the power of
        // Latte layouts directly in templates.
        // Array results of actions will then be automatically wrapped
        // in ViewModel so we can disable layout on it. Now the only way.
        'disable_zend_layout' => true,

        // If no temp is set, templates are parsed and eval'd every request.
        'temp_directory' => __DIR__ . '/../../../../data/cache',

        // If true, templates are checked for changes and recompiled if needed.
        // Should be false on production.
        'auto_refresh' => true
    )
);
