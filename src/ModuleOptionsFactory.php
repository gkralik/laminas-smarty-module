<?php

/**
 * This file is part of the gkralik/laminas-smarty-module package.
 *
 * (c) Gregor Kralik <g.kralik+gh@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GKralik\SmartyModule;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class ModuleOptionsFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $config = $container->get('Config');

        $moduleConfig = $config['laminas-smarty-module'] ?? null;

        // For BC reasons, merge configuration from `zf3-smarty-module` if set.
        if (isset($config['zf3-smarty-module'])) {
            // Merge with zf3-smarty-module (BC)
            $moduleConfig = array_merge($moduleConfig, $config['zf3-smarty-module']);
        }

        return new ModuleOptions($moduleConfig);
    }
}
