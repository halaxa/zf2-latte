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
    private $viewConfig;

    /** @var LatteConfig  */
    private $latteConfig;

    function __construct(array $viewConfig, LatteConfig $latteConfig)
    {
        $this->viewConfig = $viewConfig;
        $this->latteConfig = $latteConfig;
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
        if (isset($this->viewConfig['template_map']) && isset($this->viewConfig['template_map'][$name])) {
            $tplPath = $this->viewConfig['template_map'][$name];
            if (substr($tplPath, -strlen('.'.$this->latteConfig->extension)) === '.'.$this->latteConfig->extension) {
                return $tplPath;
            }
            return false;
        }
        if (isset($this->viewConfig['template_path_stack'])) {
            $pathStack = $this->viewConfig['template_path_stack'];
            foreach ($pathStack as $dir) {
                $tplPath = realpath($dir . '/' . $name . '.' . $this->latteConfig->extension);
                if (is_file($tplPath)) {
                    return $tplPath;
                }
            }
        }
        return false;
    }

}
