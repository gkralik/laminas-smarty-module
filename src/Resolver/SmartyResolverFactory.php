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

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\View\Resolver\AggregateResolver;

class SmartyResolverFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $resolver = new AggregateResolver();
        $resolver->attach($container->get('GKralik\SmartyModule\Resolver\TemplateMapResolver'));
        $resolver->attach($container->get('GKralik\SmartyModule\Resolver\TemplatePathStack'));

        return $resolver;
    }
}
