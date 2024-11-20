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

use Laminas\Stdlib\AbstractOptions;

final class ModuleOptions extends AbstractOptions
{
    /** @var string */
    private $suffix = 'tpl';

    /** @var string */
    private $compileDir;

    /** @var string */
    private $cacheDir;

    /** @var ?string */
    private $configDir = null;

    /** @var bool */
    private $resetAssignedVariablesBeforeRender = true;

    /** @var array */
    private $smartyOptions = [];

    private bool $registerDefaultTemplateHandlerFunc = true;

    /**
     * @return string
     */
    public function getSuffix(): string
    {
        return $this->suffix;
    }

    /**
     * @param string $suffix
     */
    public function setSuffix(string $suffix): void
    {
        $this->suffix = $suffix;
    }

    /**
     * @return string
     */
    public function getCompileDir(): string
    {
        return $this->compileDir;
    }

    /**
     * @param string $compileDir
     */
    public function setCompileDir(string $compileDir): void
    {
        $this->compileDir = $compileDir;
    }

    /**
     * @return string
     */
    public function getCacheDir(): string
    {
        return $this->cacheDir;
    }

    /**
     * @param string $cacheDir
     */
    public function setCacheDir(string $cacheDir): void
    {
        $this->cacheDir = $cacheDir;
    }

    /**
     * @return string
     */
    public function getConfigDir(): ?string
    {
        return $this->configDir;
    }

    /**
     * @param string $configDir
     */
    public function setConfigDir(?string $configDir): void
    {
        $this->configDir = $configDir;
    }

    /**
     * @return bool
     */
    public function shouldResetAssignedVariablesBeforeRender(): bool
    {
        return $this->resetAssignedVariablesBeforeRender;
    }

    /**
     * @param bool $resetAssignedVariablesBeforeRender
     */
    public function setResetAssignedVariablesBeforeRender(bool $resetAssignedVariablesBeforeRender): void
    {
        $this->resetAssignedVariablesBeforeRender = $resetAssignedVariablesBeforeRender;
    }

    /**
     * @return array
     */
    public function getSmartyOptions(): array
    {
        return $this->smartyOptions;
    }

    /**
     * @param array $smartyOptions
     */
    public function setSmartyOptions(array $smartyOptions): void
    {
        $this->smartyOptions = $smartyOptions;
    }

    public function shouldRegisterDefaultTemplateHandlerFunc(): bool
    {
        return $this->registerDefaultTemplateHandlerFunc;
    }

    public function setRegisterDefaultTemplateHandlerFunc(bool $registerDefaultTemplateHandlerFunc): void
    {
        $this->registerDefaultTemplateHandlerFunc = $registerDefaultTemplateHandlerFunc;
    }


}
