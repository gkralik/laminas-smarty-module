# laminas-smarty-module

This is a module for integrating the [Smarty](http://www.smarty.net) template engine with [Laminas](https://getlaminas.org/).

Based on [gkralik/zf3-smarty-module](https://github.com/gkralik/zf3-smarty-module).

## Installation with Composer

Installing via [Composer](http://getcomposer.org) is the only supported method.

```shell
$ composer require gkralik/laminas-smarty-module:^4.0.0
```

Add the module to your applications configuration to enable it:

```php
'modules' => [
  'GKralik\SmartyModule',
  // ...
]
```

## Usage

To enable the Smarty rendering strategy, it must be registered as a strategy with the Laminas ViewManager
(eg. in the application's default module configuration):

```php
use GKralik\SmartyModule\Strategy\SmartyStrategy;

return [
    // ...
    'view_manager' => [
        'strategies' => [
            /* Register view strategy with the view manager (REQUIRED). */
            SmartyStrategy::class,
        ],
    ],
];
```

**Important:** As of version _4.0.0_, this is no longer done automatically.

## Configuration

For information on supported options refer to the [module config file](config/module.config.php).

There is also a [sample configuration file](config/laminas-smarty-module.config.php.dist) with all available configuration options.

You can set options for the Smarty engine under the `smarty_options` configuration key (eg `force_compile`, etc).

Pay attention to the `compile_dir` and `cache_dir` keys. Smarty needs write access to the directories specified there.

## Documentation

### Using Zend Framework view helpers

Using view helpers of Laminas is supported. Just call the view helper as you would do in a PHTML template:

```smarty
{$this->doctype()}

{$this->basePath('some/path')}
```
