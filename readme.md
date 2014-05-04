# Latte integration module to Zend Framework 2

[Latte](https://github.com/nette/latte) is state of the art templating system, part of [Nette framework](https://github.com/nette/nette), leaving others behind mainly in powerful XSS defence.

## Work in progress
This is not a stable solution yet. Feel free to participate on development:)

## What it does
Basic latte support works. Zend view helpers work by accessing `$helper` object in template.

```latte
{$helper->headScript()} // will be printed and escaped
{?$helper->headScript()} // will not be printed
```
Layouts work. It also disables native layout in ZF, as Latte has great and simple support for them, also supporting multiple layouts depending on template. Translation macro `{_}` maps to `translate()` to `ViewHelperManager`. Loads only `template_map` yet. `template_path_stack` will come.

## What it does not (yet)
Macros like `control`, `form` and similar are not present, as they are based on Nette internal components. Some nette specific n:macros like `n:href` don't yet work either but will be probably mapped to `$helper->url()`

## Installation
Use Composer.
```
"require": {
    "halaxa/zf2-latte": "dev-master"
}
```
