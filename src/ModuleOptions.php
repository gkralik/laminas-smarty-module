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
    private $configDir;

    /** @var bool */
    private $resetAssignedVariablesBeforeRender = true;

    /** @var array */
    private $smartyOptions = [];

    private bool $registerDefaultTemplateHandlerFunc = true;

    public function getSuffix(): string
    {
        return $this->suffix;
    }

    public function setSuffix(string $suffix): void
    {
        $this->suffix = $suffix;
    }

    public function getCompileDir(): string
    {
        return $this->compileDir;
    }

    public function setCompileDir(string $compileDir): void
    {
        $this->compileDir = $compileDir;
    }

    public function getCacheDir(): string
    {
        return $this->cacheDir;
    }

    public function setCacheDir(string $cacheDir): void
    {
        $this->cacheDir = $cacheDir;
    }

    public function getConfigDir(): ?string
    {
        return $this->configDir;
    }

    public function setConfigDir(?string $configDir): void
    {
        $this->configDir = $configDir;
    }

    public function shouldResetAssignedVariablesBeforeRender(): bool
    {
        return $this->resetAssignedVariablesBeforeRender;
    }

    public function setResetAssignedVariablesBeforeRender(bool $resetAssignedVariablesBeforeRender): void
    {
        $this->resetAssignedVariablesBeforeRender = $resetAssignedVariablesBeforeRender;
    }

    public function getSmartyOptions(): array
    {
        return $this->smartyOptions;
    }

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
