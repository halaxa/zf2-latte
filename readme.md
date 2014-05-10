[![Build Status](https://travis-ci.org/halaxa/zf2-latte.svg?branch=master)](https://travis-ci.org/halaxa/zf2-latte)

# Latte integration module to Zend Framework 2

[Latte](https://github.com/nette/latte) is state of the art templating system, part of [Nette framework](https://github.com/nette/nette), leaving others behind mainly in powerful XSS defence.

## Work in progress
This is not a stable solution yet. Feel free to participate on development:)

## What it does
Basic latte support works. Zend view helpers work by accessing `$helper` object in template.

```smarty
{$helper->headScript()} {* will be printed and escaped *}
{?$helper->headScript()} {* will not be printed *}
```

Layouts work. It by default disables native layout in ZF, as Latte has great and simple support for them, also supporting multiple layouts depending on template. If you still want to use default ZF layout system in some actions, you can. It disables is only if latte
template is active template.

Translation macro `{_}` is configurable via ['translator_callback'](https://github.com/halaxa/zf2-latte/blob/master/config/module.config.php#L26) key.

Loads `template_map` and `template_path_stack`.

Supports `n:href` which maps to `$helper->url()`. Can be used like this even if you use PHP without short array syntax []:

```smarty
<a n:href="application, [controller => application, action => index]">link</a>
```

## What it does not (yet)
Macros like `control`, `form` and similar are not present, as they are based on Nette internal components.

## Installation
This is [composer](http://getcomposer.org) package. For **library instalation** include into your `composer.json` following line
```json
"require": {
    "halaxa/zf2-latte": "dev-master"
}
```
For **development installation** and running tests you can do something like:
```bash
composer create-project halaxa/zf2-latte zf2-latte dev-master --prefer-source --no-install --keep-vcs
cd zf2-latte
composer install --prefer-dist --dev
./vendor/bin/tester test/tests
```
