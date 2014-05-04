<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zf2Latte;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;

class Module implements ConfigProviderInterface, AutoloaderProviderInterface, BootstrapListenerInterface
{
    /**
     * Listen to the bootstrap event
     *
     * @param EventInterface $e
     * @return array
     */
    public function onBootstrap(EventInterface $e)
    {
        if ($e instanceof MvcEvent) {
            $disableLayouts = function (MvcEvent $e) {
                $vm = $e->getResult();
                if (!$vm instanceof ViewModel) {
                    $vm = new ViewModel($vm);
                    $e->setResult($vm);
                }
                $vm->setTerminal(true);
            };
            $evm = $e->getApplication()->getEventManager();
            $evm->attach(MvcEvent::EVENT_DISPATCH_ERROR, $disableLayouts);
            $shm = $evm->getSharedManager();
            $shm->attach('\Zend\Mvc\Controller\AbstractActionController', MvcEvent::EVENT_DISPATCH, $disableLayouts);
        }
    }

    /**
     * Return an array for passing to Zend\Loader\AutoloaderFactory.
     *
     * @todo: development only
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    'Zf2Latte' => __DIR__ . '/src/Zf2Latte',
                ),
            ),
        );
    }

    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return require __DIR__ . '/config/module.config.php';
    }
}
