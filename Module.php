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
use Zend\ServiceManager\ServiceManager;
use Zend\View\Model\ViewModel;

/**
 * @todo onRender event?, n:macros, register zend filters and some helpers as latte filters?
 *       dump to bars?
 */
class Module implements ConfigProviderInterface, AutoloaderProviderInterface, BootstrapListenerInterface
{
    /** @var  ServiceManager */
    private $sm;
    /**
     * Listen to the bootstrap event
     *
     * @param EventInterface $e
     * @return array
     */
    public function onBootstrap(EventInterface $e)
    {
        // disabling layouts
        if ($e instanceof MvcEvent) {
            $this->sm = $e->getApplication()->getServiceManager();
            /** @var LatteConfig $latteConfig */
            $latteConfig = $this->sm->get('Zf2Latte\LatteConfig');

            if ( ! $latteConfig->disable_zend_layout) {
                return;
            }

            $evm = $e->getApplication()->getEventManager();
            $evm->attach(
                MvcEvent::EVENT_DISPATCH_ERROR,
                array($this, 'disableLayouts'),
                // fine tuned number to fit a hole between MVC listeners. We need
                // data to be already wrapped in ViewModel but not in layout
                -95
            );
            $shm = $evm->getSharedManager();
            $shm->attach(
                'Zend\Mvc\Controller\AbstractActionController',
                MvcEvent::EVENT_DISPATCH,
                array($this, 'disableLayouts'),
                -95 // see above
            );
        }
    }

    public function disableLayouts (MvcEvent $e) {
        $latteResolver = $this->sm->get('Zf2Latte\LatteResolver');
        $viewModel = $e->getResult();
        if ($latteResolver->resolve($viewModel->getTemplate())) {
            $e->getResult()->setTerminal(true);
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
