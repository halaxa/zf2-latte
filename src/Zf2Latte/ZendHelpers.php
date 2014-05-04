<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 4.5.2014
 * Time: 9:59
 */

namespace Zf2Latte;


use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Helper\AbstractHelper;
use Zend\View\HelperPluginManager;

/**
 * Convenience methods for build in helpers (@see __call):
 *
 * @method \Zend\View\Helper\BasePath basePath($file = null)
 * @method \Zend\View\Helper\Cycle cycle(array $data = array(), $name = \Zend\View\Helper\Cycle::DEFAULT_NAME)
 * @method \Zend\View\Helper\DeclareVars declareVars()
 * @method \Zend\View\Helper\Doctype doctype($doctype = null)
 * @method mixed escapeCss($value, $recurse = \Zend\View\Helper\Escaper\AbstractHelper::RECURSE_NONE)
 * @method mixed escapeHtml($value, $recurse = \Zend\View\Helper\Escaper\AbstractHelper::RECURSE_NONE)
 * @method mixed escapeHtmlAttr($value, $recurse = \Zend\View\Helper\Escaper\AbstractHelper::RECURSE_NONE)
 * @method mixed escapeJs($value, $recurse = \Zend\View\Helper\Escaper\AbstractHelper::RECURSE_NONE)
 * @method mixed escapeUrl($value, $recurse = \Zend\View\Helper\Escaper\AbstractHelper::RECURSE_NONE)
 * @method \Zend\View\Helper\FlashMessenger flashMessenger($namespace = null)
 * @method \Zend\View\Helper\Gravatar gravatar($email = "", $options = array(), $attribs = array())
 * @method \Zend\View\Helper\HeadLink headLink(array $attributes = null, $placement = \Zend\View\Helper\Placeholder\Container\AbstractContainer::APPEND)
 * @method \Zend\View\Helper\HeadMeta headMeta($content = null, $keyValue = null, $keyType = 'name', $modifiers = array(), $placement = \Zend\View\Helper\Placeholder\Container\AbstractContainer::APPEND)
 * @method \Zend\View\Helper\HeadScript headScript($mode = \Zend\View\Helper\HeadScript::FILE, $spec = null, $placement = 'APPEND', array $attrs = array(), $type = 'text/javascript')
 * @method \Zend\View\Helper\HeadStyle headStyle($content = null, $placement = 'APPEND', $attributes = array())
 * @method \Zend\View\Helper\HeadTitle headTitle($title = null, $setType = null)
 * @method string htmlFlash($data, array $attribs = array(), array $params = array(), $content = null)
 * @method string htmlList(array $items, $ordered = false, $attribs = false, $escape = true)
 * @method string htmlObject($data = null, $type = null, array $attribs = array(), array $params = array(), $content = null)
 * @method string htmlPage($data, array $attribs = array(), array $params = array(), $content = null)
 * @method string htmlQuicktime($data, array $attribs = array(), array $params = array(), $content = null)
 * @method mixed|null identity()
 * @method \Zend\View\Helper\InlineScript inlineScript($mode = \Zend\View\Helper\HeadScript::FILE, $spec = null, $placement = 'APPEND', array $attrs = array(), $type = 'text/javascript')
 * @method string|void json($data, array $jsonOptions = array())
 * @method \Zend\View\Helper\Layout layout($template = null)
 * @method \Zend\View\Helper\Navigation navigation($container = null)
 * @method string paginationControl(\Zend\Paginator\Paginator $paginator = null, $scrollingStyle = null, $partial = null, $params = null)
 * @method string|\Zend\View\Helper\Partial partial($name = null, $values = null)
 * @method string partialLoop($name = null, $values = null)
 * @method \Zend\View\Helper\Placeholder\Container\AbstractContainer placeHolder($name = null)
 * @method string renderChildModel($child)
 * @method void renderToPlaceholder($script, $placeholder)
 * @method string serverUrl($requestUri = null)
 * @method string url($name = null, array $params = array(), $options = array(), $reuseMatchedParams = false)
 * @method \Zend\View\Helper\ViewModel viewModel()
 * @method \Zend\View\Helper\Navigation\Breadcrumbs breadCrumbs($container = null)
 * @method \Zend\View\Helper\Navigation\Links links($container = null)
 * @method \Zend\View\Helper\Navigation\Menu menu($container = null)
 * @method \Zend\View\Helper\Navigation\Sitemap sitemap($container = null)
 */
class ZendHelpers
{
    /** @var  HelperPluginManager */
    private $pluginManager;

    /**
     * Overloading: proxy to helpers
     *
     * Proxies to the attached plugin manager to retrieve, return, and potentially
     * execute helpers.
     *
     * * If the helper does not define __invoke, it will be returned
     * * If the helper does define __invoke, it will be called as a functor
     *
     * @param  string $method
     * @param  array $argv
     * @return mixed
     */
    public function __call($method, $argv)
    {
        $plugin = $this->plugin($method);
        if (is_callable($plugin)) {
            return call_user_func_array($plugin, $argv);
        }
        return $plugin;
    }

    /**
     * Get plugin instance
     *
     * @param  string     $name Name of plugin to return
     * @return AbstractHelper
     */
    public function plugin($name)
    {
        return $this->getPluginManager()->get($name);
    }

    /**
     * @return HelperPluginManager
     */
    public function getPluginManager()
    {
        if ( ! $this->pluginManager) {
            $this->pluginManager = new HelperPluginManager();
        }
        return $this->pluginManager;
    }

    /**
     * @param ServiceLocatorInterface $pluginManager
     */
    public function setPluginManager(ServiceLocatorInterface $pluginManager)
    {
        $this->pluginManager = $pluginManager;
        return $this;
    }
}
