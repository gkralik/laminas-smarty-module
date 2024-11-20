<?php

/**
 * This file is part of the gkralik/laminas-smarty-module package.
 *
 * (c) Gregor Kralik <g.kralik+gh@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use GKralik\SmartyModule\ModuleOptions;
use GKralik\SmartyModule\ModuleOptionsFactory;
use GKralik\SmartyModule\Renderer\SmartyRenderer;
use GKralik\SmartyModule\Renderer\SmartyRendererFactory;
use GKralik\SmartyModule\Resolver\SmartyResolverFactory;
use GKralik\SmartyModule\Resolver\TemplateMapResolverFactory;
use GKralik\SmartyModule\Resolver\TemplatePathStackResolverFactory;
use GKralik\SmartyModule\Strategy\SmartyStrategy;
use GKralik\SmartyModule\Strategy\SmartyStrategyFactory;

return [
    'laminas-smarty-module' => [
        /* Template suffix */
        'suffix' => 'tpl',

        /* Directory for compiled templates */
        'compile_dir' => getcwd().'/cache/templates_c',

        /* Directory for cached templates */
        'cache_dir' => getcwd().'/cache/templates',

        /* Path to smarty config file */
        'config_dir' => null,

        /* Clear all assigned variables before rendering a template
         * (if false, variables from child models can spill into the layout). */
        'reset_assigned_variables_before_render' => true,

        /* Additional smarty engine options */
        'smarty_options' => [],

        /* Register a default template handler function to resolve <code>{include file="..."}</code>
         * via SmartyResolver. */
        // 'register_default_template_handler_func' => true,
    ],

    'service_manager' => [
        'factories' => [
            ModuleOptions::class => ModuleOptionsFactory::class,
            SmartyStrategy::class => SmartyStrategyFactory::class,
            SmartyRenderer::class => SmartyRendererFactory::class,
            'GKralik\SmartyModule\Resolver\SmartyResolver' => SmartyResolverFactory::class,
            'GKralik\SmartyModule\Resolver\TemplateMapResolver' => TemplateMapResolverFactory::class,
            'GKralik\SmartyModule\Resolver\TemplatePathStack' => TemplatePathStackResolverFactory::class,
        ],
    ],

    'view_manager' => [
        'strategies' => [
            /* Register view strategy with the view manager (REQUIRED). */
            SmartyStrategy::class,
        ],
    ],
];
