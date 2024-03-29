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
}
