<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 3.5.2014
 * Time: 12:44
 */

namespace Zf2Latte;


use Latte\Object;

class LatteConfig extends Object
{
    /** @var string  */
    public $extension;

    /** @var string */
    public $translator;

    /** @var  bool */
    public $disable_zend_layout;
}
