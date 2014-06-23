<?php

/**
 * Copyright 2014 Fabian Grutschus. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright notice, this
 *   list of conditions and the following disclaimer.
 *
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 *   this list of conditions and the following disclaimer in the documentation
 *   and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * The views and conclusions contained in the software and documentation are those
 * of the authors and should not be interpreted as representing official policies,
 * either expressed or implied, of the copyright holders.
 *
 * @author    Fabian Grutschus <f.grutschus@lubyte.de>
 * @copyright 2014 Fabian Grutschus. All rights reserved.
 * @license   BSD-2-Clause
 * @link      http://github.com/purr-php/purr
 */

namespace Fabiang\Cludearg;

use Fabiang\Cludearg\Definition\ArgumentDefinitionInterface;

/**
 *
 */
class Cludearg
{

    /**
     *
     * @var Definition
     */
    protected $definition;

    public function __construct(Definition $definition = null)
    {
        if (null === $definition) {
            $definition = Loader::loadJSON(__DIR__ . '/../definition.json');
        }

        $this->definition = $definition;
    }

    public function getArgument($application, $version, array $include, array $exclude, $path)
    {
        $definition = $this->findDefinition($application, $version);
        $path       = rtrim($path, '/');

        $arguments      = array('exclude' => array(), 'include' => array());
        $loopDefinition = array('exclude' => $definition->getExclude(), 'include' => $definition->getInclude());
        foreach ($loopDefinition as $type => $definitionObject) {
            $loopPaths = $$type;
            $argument  = &$arguments[$type];

            if ($definitionObject->isCombined() && ($definitionObject->getPath() || $definitionObject->getFile())) {
                $definition = $definitionObject->getPath() ? $definitionObject->getPath()
                    : $definitionObject->getFile();
                $this->concat(
                    $argument,
                    $definition,
                    $this->makeAbsolute($loopPaths, $path, $definition->isRelative())
                );
            } else {
                if (null !== $definitionObject->getPath()) {
                    $pathObject = $definitionObject->getPath();

                    $paths = array_filter($loopPaths, function ($file) use ($path) {
                        return is_dir($path . '/' . $file);
                    });

                    $this->concat(
                        $argument,
                        $pathObject,
                        $this->makeAbsolute($paths, $path, $pathObject->isRelative())
                    );
                }

                if (null !== $definitionObject->getFile()) {

                    // continue if either path or file can be defined
                    if ($definitionObject->isOnlyOne() && !empty($argument)) {
                        continue;
                    }

                    $fileObject = $definitionObject->getFile();

                    $files = array_filter($loopPaths, function ($file) use ($path) {
                        return is_file($path . '/' . $file);
                    });


                    $this->concat(
                        $argument,
                        $fileObject,
                        $this->makeAbsolute($files, $path, $fileObject->isRelative())
                    );
                }
            }

        }

        return trim(trim(implode(' ', $arguments['exclude'])) . ' ' . trim(implode(' ', $arguments['include'])));
    }

    protected function makeAbsolute($paths, $path, $relative)
    {
        if (false === $relative) {
            foreach ($paths as $no => $subpath) {
                $paths[$no] = $path . '/' . $subpath;
            }
        }

        return $paths;
    }

    protected function concat(&$argument, $definition, $paths)
    {
        if (null !== $definition->getSeparator()) {
            $argument[] = sprintf(
                $definition->getParameter(),
                escapeshellarg(implode($definition->getSeparator(), $paths))
            );
        } elseif (false !== $definition->isMultiple()) {
            foreach ($paths as $path) {
                $argument[] = sprintf($definition->getParameter(), escapeshellarg($path));
            }
        } else {
            $argument[] = sprintf($definition->getParameter(), escapeshellarg(array_shift($paths)));
        }
    }

    private function findDefinition($applicationName, $version)
    {
        $foundApplication = null;
        foreach ($this->definition->getApplications() as $application) {
            if ($applicationName === $application->getName()) {
                $foundApplication = $application;
                break;
            }
        }

        $versions = $foundApplication->getVersions();
        // @todo find right version
        return $versions[0];
    }
}
