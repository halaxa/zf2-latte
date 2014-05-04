<?php

use Zend\ServiceManager\ServiceLocatorInterface;

return array(
    'factories' => array(
        'Zf2Latte\LatteStrategy' => function(ServiceLocatorInterface $sl) {
            return new \Zf2Latte\LatteStrategy(
                $sl->get('Zf2Latte\LatteRenderer'),
                $sl->get('Zf2Latte\LatteResolver'),
                $sl->get('Zf2Latte\LatteConfig')
            );
        },
        'Zf2Latte\LatteRenderer' => function(ServiceLocatorInterface $sl) {
            return new \Zf2Latte\LatteRenderer(
                $sl->get('Latte\Engine'),
                $sl->get('Zf2Latte\LatteResolver'),
                $sl->get('Zf2Latte\ZendHelpers')
            );
        },
        'Zf2Latte\LatteResolver' => function(ServiceLocatorInterface $sl) {
            $config = $sl->get('config');
            return new \Zf2Latte\LatteResolver(
                $config['view_manager']['template_map'],
                $sl->get('Zf2Latte\LatteConfig')
            );
        },
        'Zf2Latte\LatteConfig' => function(ServiceLocatorInterface $sl) {
            $config = $sl->get('config');
            $latteConfig = new \Zf2Latte\LatteConfig();
            foreach ($config['zf2_latte'] as $name => $value) {
                $latteConfig->{$name} = $value;
            }
            return $latteConfig;
        },
        'zf2latte.underscore_translator' => function(){
            return function($param) {
                return '_'.$param;
            };
        },
        'Latte\Engine' => function(ServiceLocatorInterface $sl) {
            $engine = new \Latte\Engine();
            $engine->addFilter('translate', $sl->get($sl->get('Zf2Latte\LatteConfig')->translator));
            return $engine;
        }
    ),
    'invokables' => array(
        'Zf2Latte\ZendHelpers' => 'Zf2Latte\ZendHelpers'
    )
);
