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

class Module
{
    public function getConfig(): array
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
