<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 6.5.14
 * Time: 15:20
 */

namespace Application;


use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;

class BootstrapListener extends AbstractListenerAggregate
{
    /**
     * Attach one or more listeners
     *
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param EventManagerInterface $events
     *
     * @return void
     */
    public function attach(EventManagerInterface $events)
    {
//        $this->listeners[] = $events->attach(MvcEvent::EVENT_BOOTSTRAP, function(MvcEvent $e){
//            $request = $e->getRequest();
//            $sm = $e->getApplication()->getServiceManager();
//            if ($request instanceof \Zend\Http\PhpEnvironment\Request) {
//                $request->setServer($sm->get('Zf2LatteTest.FakeHttpServerParams'));
////                dd($request->getServer());
//            }
//        }, 777);
    }

}
