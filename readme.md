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

Layouts work. It also disables native layout in ZF, as Latte has great and simple support for them, also supporting multiple layouts depending on template.

Translation macro `{_}` is configurable via ['translator_callback'](https://github.com/halaxa/zf2-latte/blob/master/config/module.config.php#L26) key.

Loads `template_map` and `template_path_stack`.

Supports `n:href` which maps to `$helper->url()`. Can be used like this even if you use PHP without short array syntax []:

```smarty
<a n:href="application, [controller => application, action => index]">link</a>
```

## What it does not (yet)
Macros like `control`, `form` and similar are not present, as they are based on Nette internal components.

## Installation
Use Composer.
```json
"require": {
    "halaxa/zf2-latte": "dev-master"
}
```
