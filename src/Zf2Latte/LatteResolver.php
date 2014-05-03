<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 3.5.2014
 * Time: 9:51
 */

namespace Zf2Latte;


use Zend\View\Renderer\RendererInterface as Renderer;
use Zend\View\Resolver\ResolverInterface;

/**
 * Now only supports resolving based on configured template_map
 */
class LatteResolver implements ResolverInterface
{
    /** @var  array */
    private $templateMap;

    /** @var LatteConfig  */
    private $config;

    function __construct(array $templateMap, LatteConfig $config)
    {
        $this->templateMap = $templateMap;
        $this->config = $config;
    }

    /**
     * Resolve a template/pattern name to a resource the renderer can consume
     *
     * @param  string        $name
     * @param  null|Renderer $renderer
     * @return mixed
     */
    public function resolve($name, Renderer $renderer = null)
    {
        if ($name === 'layout/layout') {
            return false;
        }
        $tplPath = $this->templateMap[$name];
        if (substr($tplPath, -strlen('.'.$this->config->extension)) === '.'.$this->config->extension) {
            return $tplPath;
        }
        return false;
    }

}
