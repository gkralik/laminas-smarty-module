<?php

/**
 * This file is part of the gkralik/laminas-smarty-module package.
 *
 * (c) Gregor Kralik <g.kralik+gh@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GKralik\SmartyModule\Renderer;

use GKralik\SmartyModule\ModuleOptions;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\View\Resolver\ResolverInterface;

class SmartyRendererFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        /** @var ModuleOptions $options */
        $options = $container->get('GKralik\SmartyModule\ModuleOptions');

        /** @var ResolverInterface $resolver */
        $resolver = $container->get('GKralik\SmartyModule\Resolver\SmartyResolver');

        $smartyEngine = new \Smarty();

        foreach ($options->getSmartyOptions() as $option => $value) {
            $setter = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $option)));

            if (method_exists($smartyEngine, $setter)) {
                call_user_func_array([$smartyEngine, $setter], [$value]); // @phpstan-ignore argument.type
            } elseif (property_exists($smartyEngine, $option)) {
                $smartyEngine->$option = $value;
            }
        }
        unset($option, $value);

        $smartyEngine->setCompileDir($options->getCompileDir());
        $smartyEngine->setCacheDir($options->getCacheDir());
        $smartyEngine->setConfigDir($options->getConfigDir());

        $renderer = new SmartyRenderer($smartyEngine, $resolver);
        $renderer->setHelperPluginManager($container->get('ViewHelperManager'));
        $renderer->setResetAssignedVariablesBeforeRender($options->shouldResetAssignedVariablesBeforeRender());

        if ($options->shouldRegisterDefaultTemplateHandlerFunc()) {
            $renderer->registerDefaultTemplateHandlerFunc();
        }

        return $renderer;
    }
}
