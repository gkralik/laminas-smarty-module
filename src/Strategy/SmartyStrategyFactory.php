<?php

/**
 * This file is part of the gkralik/laminas-smarty-module package.
 *
 * (c) Gregor Kralik <g.kralik+gh@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GKralik\SmartyModule\Strategy;

use GKralik\SmartyModule\Renderer\SmartyRenderer;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class SmartyStrategyFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new SmartyStrategy($container->get(SmartyRenderer::class));
    }
}
