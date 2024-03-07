<?php
/**
 * Copyright 2024 Gregor Kralik <g.kralik+gh@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @author Gregor Kralik <g.kralik+gh@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace GKralik\SmartyModule;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class ModuleOptionsFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
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
