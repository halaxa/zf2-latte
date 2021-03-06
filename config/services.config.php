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
        'Zf2Latte\ZendHelpers' => function(ServiceLocatorInterface $sl) {
            return new \Zf2Latte\ZendHelpers(
                $sl->get('ViewHelperManager')
            );
        },
        'Zf2Latte\LatteResolver' => function(ServiceLocatorInterface $sl) {
            $config = $sl->get('config');
            return new \Zf2Latte\LatteResolver(
                $config['view_manager'],
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
        'Latte\Engine' => function(ServiceLocatorInterface $sl) {
            /** @var \Zf2Latte\LatteConfig $config */
            $config = $sl->get('Zf2Latte\LatteConfig');
            $engine = new \Latte\Engine();

            $engine->addFilter('translate', array(
                $sl->get($config->translator_callback[0]),
                $config->translator_callback[1]
            ));

            $engine->onCompile[] = function ($engine) {
                $set = \Latte\Macros\MacroSet::install($engine->getCompiler());
                $set->addMacro('href', NULL, NULL, 'echo \' href="\' . $helper->url(%node.args) . \'"\'');
            };

            $engine->setTempDirectory($config->temp_directory);
            $engine->setAutoRefresh($config->auto_refresh);

            return $engine;
        }
    ),
);
