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

use Laminas\ServiceManager\ServiceManager;
use Laminas\View\Exception\DomainException;
use Laminas\View\Helper\ViewModel as ViewModelHelper;
use Laminas\View\HelperPluginManager;
use Laminas\View\Model\ModelInterface;
use Laminas\View\Renderer\RendererInterface;
use Laminas\View\Resolver\ResolverInterface;
use Smarty;
use SmartyException;

class SmartyRenderer implements RendererInterface
{
    /** @var \Smarty */
    private $smarty;

    /** @var ResolverInterface */
    private $resolver;

    /** @var bool */
    private $resetAssignedVariablesBeforeRender = true;

    /** @var HelperPluginManager */
    private $helperPluginManager;

    /** @var array Plugins cache. */
    private $pluginsCache;

    /**
     * SmartyRenderer constructor.
     */
    public function __construct(\Smarty $smarty, ResolverInterface $resolver)
    {
        $this->smarty = $smarty;
        $this->resolver = $resolver;
    }

    /**
     * Return the template engine object, if any.
     *
     * If using a third-party template engine, such as Smarty, patTemplate,
     * phplib, etc, return the template engine object. Useful for calling
     * methods on these objects, such as for setting filters, modifiers, etc.
     *
     * @return \Smarty
     */
    public function getEngine()
    {
        return $this->smarty;
    }

    /**
     * Set the resolver used to map a template name to a resource the renderer may consume.
     *
     * @return RendererInterface
     */
    public function setResolver(ResolverInterface $resolver)
    {
        $this->resolver = $resolver;

        return $this;
    }

    public function shouldResetAssignedVariablesBeforeRender(): bool
    {
        return $this->resetAssignedVariablesBeforeRender;
    }

    public function setResetAssignedVariablesBeforeRender(bool $resetAssignedVariablesBeforeRender): SmartyRenderer
    {
        $this->resetAssignedVariablesBeforeRender = $resetAssignedVariablesBeforeRender;

        return $this;
    }

    /**
     * Can the template be rendered?
     *
     * A template can be rendered if the attached resolver can resolve the given
     * template name.
     *
     * @param string|ModelInterface $nameOrModel
     */
    public function canRender($nameOrModel): bool
    {
        if ($nameOrModel instanceof ModelInterface) {
            $nameOrModel = $nameOrModel->getTemplate();
        }

        $file = $this->resolver->resolve($nameOrModel);

        return $file ? true : false;
    }

    /**
     * Processes a view script and returns the output.
     *
     * @param string|ModelInterface                  $nameOrModel The script/resource process, or a view model
     * @param array|\ArrayAccess<string, mixed>|null $values      Values to use during rendering
     *
     * @return string the script output
     *
     * @throws \SmartyException
     */
    public function render($nameOrModel, $values = null)
    {
        if ($nameOrModel instanceof ModelInterface) {
            $model = $nameOrModel;
            $nameOrModel = $model->getTemplate();

            if (empty($nameOrModel)) {
                throw new DomainException(sprintf('%s: received %s argument, but template is empty', __METHOD__, ModelInterface::class));
            }

            foreach ($model->getOptions() as $setting => $value) {
                $setter = [$this, 'set'.$setting];
                if (is_callable($setter)) {
                    call_user_func_array($setter, [$value]);
                }
            }
            unset($setting, $value);

            // give view model awareness via ViewModel helper
            /** @var ViewModelHelper $helper */
            $helper = $this->plugin('view_model');
            $helper->setCurrent($model);

            $values = $model->getVariables();
            unset($model);
        }

        $file = $this->resolver->resolve($nameOrModel);
        if (!$file) {
            throw new DomainException(sprintf('%s: unable to resolve template %s', __METHOD__, $nameOrModel));
        }

        if ($values instanceof \ArrayObject) {
            $values = $values->getArrayCopy();
        }

        $values['this'] = $this;

        if ($this->shouldResetAssignedVariablesBeforeRender()) {
            $this->smarty->clearAllAssign();
        }

        $this->smarty->assign($values); // @phpstan-ignore argument.type

        // add current dir to allow including partials without full path
        $this->smarty->addTemplateDir(dirname($file));

        return $this->smarty->fetch($file);
    }

    /**
     * Sets the HelperPluginManagers renderer instance to $this.
     *
     * @return SmartyRenderer
     */
    public function setHelperPluginManager(HelperPluginManager $helperPluginManager)
    {
        $helperPluginManager->setRenderer($this);
        $this->helperPluginManager = $helperPluginManager;

        return $this;
    }

    /**
     * @return HelperPluginManager
     */
    public function getHelperPluginManager()
    {
        if ($this->helperPluginManager === null) {
            $this->setHelperPluginManager(new HelperPluginManager(new ServiceManager()));
        }

        return $this->helperPluginManager;
    }

    public function __clone()
    {
        $this->smarty = clone $this->smarty;
    }

    /**
     * Magic method overloading.
     *
     * Proxies calls to the attached HelperPluginManager.
     * * Helpers without an __invoke() method are simply returned.
     * * Helpers with an __invoke() method will be called and their return
     *   value is returned.
     *
     * A cache is used to speed up successive calls to the same helper.
     *
     * @param string $name
     * @param array  $arguments
     */
    public function __call($name, $arguments)
    {
        if (!isset($this->pluginsCache[$name])) {
            $this->pluginsCache[$name] = $this->plugin($name);
        }
        if (is_callable($this->pluginsCache[$name])) {
            return call_user_func_array($this->pluginsCache[$name], $arguments);
        }

        return $this->pluginsCache[$name];
    }

    /**
     * Retrieve plugin instance.
     *
     * Proxies to HelperPluginManager::get.
     *
     * @param string $name    plugin name
     * @param array  $options Plugin options. Passed to the plugin constructor.
     *
     * @return \Laminas\View\Helper\AbstractHelper
     */
    public function plugin($name, ?array $options = null)
    {
        return $this->getHelperPluginManager()
            ->setRenderer($this)
            ->get($name, $options);
    }

    /**
     * Register the default template handler function for Smarty.
     */
    public function registerDefaultTemplateHandlerFunc(): void
    {
        $handlerFunc = \Closure::fromCallable([$this, '_handleFileResourceNotFound']);
        $this->smarty->registerDefaultTemplateHandler($handlerFunc); // @phpstan-ignore argument.type
    }

    /**
     * Default template handler.
     *
     * This function is called when Smarty's <code>file:</code> resource is unable to load a requested file.
     *
     * The function resolves the resource via the configured {@link $resolver}.
     * This allows <code>{include file=""}</code> to work with everything the resolver can resolve (eg. using the
     * template map resolver to include partials).
     *
     * @param string      $type      Resource type (e.g. "file", "string", "eval", "resource")
     * @param string      $name      Resource name (e.g. "foo/bar.tpl")
     * @param string|null &$content  Template's content
     * @param int|null    &$modified Template's modification time
     * @param \Smarty     $smarty    Smarty instance
     *
     * @return string|bool path to file or boolean true if $content and $modified
     *                     have been filled, boolean false if no default template
     *                     could be loaded
     */
    private function _handleFileResourceNotFound(string $type, string $name, ?string &$content, ?int &$modified, \Smarty $smarty): bool|string
    {
        if ($type !== 'file') {
            // The default handler is currently only invoked for file resources.
            // It is not triggered when the resource itself cannot be found, in which case a SmartyException is thrown.
            // To be on the safe side with future changes from Smarty, return early if the resource type is not 'file'.
            return false;
        }

        $resolvedTemplate = $this->resolver->resolve($name);

        // Return the resolved template path or false to tell Smarty we could not find anything.
        return $resolvedTemplate ?: false;
    }
}
