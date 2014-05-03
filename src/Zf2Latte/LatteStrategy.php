<?php

namespace Zf2Latte;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\View\ViewEvent;

class LatteStrategy implements ListenerAggregateInterface
{
    /** @var \Zend\Stdlib\CallbackHandler[] */
    private $listeners = array();

    /** @var  LatteRenderer */
    private $renderer;

    /** @var  LatteResolver */
    private $resolver;

    /** @var  LatteConfig */
    private $config;

    /**
     * @param LatteRenderer $renderer
     */
    public function __construct(LatteRenderer $renderer, LatteResolver $resolver, LatteConfig $config)
    {
        $this->renderer = $renderer;
        $this->resolver = $resolver;
        $this->config = $config;
    }

    /**
     * Attach one or more listeners
     *
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param EventManagerInterface $events
     * @param int $priority
     */
    public function attach(EventManagerInterface $events, $priority = 100)
    {
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RENDERER, array($this, 'selectRenderer'), $priority);
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RESPONSE, array($this, 'injectResponse'), $priority);
    }

    /**
     * Detach all previously attached listeners
     *
     * @param EventManagerInterface $events
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            $events->detach($listener);
            unset($this->listeners[$index]);
        }
    }

    /**
     * Determine if the renderer can load the requested template.
     *
     * @param ViewEvent $e
     * @return bool|LatteRenderer
     */
    public function selectRenderer(ViewEvent $e)
    {
        $tplPath = $this->resolver->resolve($e->getModel()->getTemplate(), $this->renderer);
        if ($tplPath) {
            return $this->renderer;
        }
        return false;
    }

    /**
     * Inject the response from the renderer.
     *
     * @param \Zend\View\ViewEvent $e
     */
    public function injectResponse(ViewEvent $e)
    {
        $renderer = $e->getRenderer();
        if ($renderer !== $this->renderer) {
            return;
        }
        $result   = $e->getResult();
        $response = $e->getResponse();

        $response->setContent($result);
    }
}
