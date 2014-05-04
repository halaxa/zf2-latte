<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(

    'service_manager' => require __DIR__ . '/services.config.php',

    'view_manager' => array(
        'strategies' => array('Zf2Latte\LatteStrategy')
    ),

    'zf2_latte' => array(

        // File extension of latte templates without the comma.
        // Templates are resolved as Latte by this extension.
        'extension' => 'latte',

        // Name of the translation service in the service manager.
        // For the time being it's expected to be a simple callable.
        'translator' => 'zf2latte.underscore_translator',

        // disables ZF2 layout system. You can leverage the power of
        // Latte layouts directly in templates. Array results of actions
        // will then be automatically wrapped in ViewModel to we can disable
        // layout on int. Now the only way.
        'disable_zend_layout' => true
    )
);
