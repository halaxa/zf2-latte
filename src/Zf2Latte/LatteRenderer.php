<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 2.5.2014
 * Time: 10:58
 */

namespace Zf2Latte;


use Latte\Engine;
use Zend\View\Model\ModelInterface;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\RendererInterface;
use Zend\View\Renderer\TreeRendererInterface;
use Zend\View\Resolver\ResolverInterface;

class LatteRenderer implements RendererInterface, TreeRendererInterface
{
    /** @var  Engine */
    private $engine;

    /** @var  ResolverInterface */
    private $resolver;

    /** @var  ZendHelpers */
    private $helpers;

    function __construct(Engine $engine, LatteResolver $resolver, ZendHelpers $helpers)
    {
        $this->engine = $engine;
        $this->resolver = $resolver;
        $this->helpers = $helpers;
        $this->helpers->getPluginManager()->setRenderer($this);
    }

    /**
     * Return the template engine object, if any
     *
     * If using a third-party template engine, such as Smarty, patTemplate,
     * phplib, etc, return the template engine object. Useful for calling
     * methods on these objects, such as for setting filters, modifiers, etc.
     *
     * @return mixed
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * Set the resolver used to map a template name to a resource the renderer may consume.
     *
     * @param  ResolverInterface $resolver
     * @return RendererInterface
     */
    public function setResolver(ResolverInterface $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * @param string $name
     */
    public function plugin($name)
    {
        return $this->helpers->plugin($name);
    }

    /**
     * Processes a view script and returns the output.
     *
     * @param  string|ModelInterface   $nameOrModel The script/resource process, or a view model
     * @param  null|array|\ArrayAccess $values      Values to use during rendering
     * @return string The script output.
     * @throws \LogicException
     */
    public function render($nameOrModel, $values = null)
    {
        $name = $nameOrModel;
        if ($nameOrModel instanceof ModelInterface) {
            $name = $this->resolver->resolve($nameOrModel->getTemplate(), $this);
            $values = (array) $nameOrModel->getVariables();
        }
        if (array_key_exists('helper', $values)) {
            throw new \LogicException('Variable $helper is reserved for Zend helpers and can\'t be passed to view.');
        }
        $values['helper'] = $this->helpers;
        return $this->engine->renderToString($name, $values);
    }

    /**
     * Indicate whether the renderer is capable of rendering trees of view models
     *
     * @return bool
     */
    public function canRenderTrees()
    {
        return false;
    }
}
