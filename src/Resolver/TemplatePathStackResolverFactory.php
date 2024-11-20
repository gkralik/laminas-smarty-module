<?php

/**
 * This file is part of the gkralik/laminas-smarty-module package.
 *
 * (c) Gregor Kralik <g.kralik+gh@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GKralik\SmartyModule\Resolver;

use GKralik\SmartyModule\ModuleOptions;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\View\Resolver\TemplatePathStack;

class TemplatePathStackResolverFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        /** @var ModuleOptions $options */
        $options = $container->get('GKralik\SmartyModule\ModuleOptions');

        /** @var TemplatePathStack $templatePathStack */
        $templatePathStack = clone $container->get('ViewTemplatePathStack');
        $templatePathStack->setDefaultSuffix($options->getSuffix());

        return $templatePathStack;
    }
}
