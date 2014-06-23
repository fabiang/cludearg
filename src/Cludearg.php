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

    /**
     *
     * @param Definition $definition
     */
    public function __construct(Definition $definition = null)
    {
        if (null === $definition) {
            $definition = Loader::loadJSON(__DIR__ . '/../definition.json');
        }

        $this->definition = $definition;
    }

    /**
     * Get argument for an application.
     *
     * @param string $application Application name
     * @param string $version     Application version
     * @param array  $include     Includes
     * @param array  $exclude     Excludes
     * @param string $path        Path for checking files
     * @return string
     */
    public function getArgument($application, $version, array $include, array $exclude, $path)
    {
        $definition = $this->findDefinition($application, $version);
        $path       = rtrim($path, '/');

        $arguments      = array('exclude' => array(), 'include' => array());
        $loopDefinition = array('exclude' => $definition->getExclude(), 'include' => $definition->getInclude());
        foreach ($loopDefinition as $type => $definitionObject) {
            // ugly but intentionally
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
                    $this->addPaths(
                        $argument,
                        $loopPaths,
                        $path,
                        function ($file) use ($path) {
                            return is_dir($path . '/' . $file);
                        },
                        $definitionObject->getPath()
                    );
                }

                if (null !== $definitionObject->getFile()) {

                    // continue if only either path or file can be defined
                    if ($definitionObject->isOnlyOne() && !empty($argument)) {
                        continue;
                    }

                    $this->addPaths(
                        $argument,
                        $loopPaths,
                        $path,
                        function ($file) use ($path) {
                            return is_file($path . '/' . $file);
                        },
                        $definitionObject->getFile()
                    );
                }
            }

        }

        return trim(trim(implode(' ', $arguments['exclude'])) . ' ' . trim(implode(' ', $arguments['include'])));
    }

    /**
     * Add paths.
     *
     * @param array                       $argument
     * @param array                       $loopPaths
     * @param string                      $path
     * @param callable                    $callback
     * @param ArgumentDefinitionInterface $definitionObject
     */
    protected function addPaths(
        array &$argument,
        array $loopPaths,
        $path,
        $callback,
        ArgumentDefinitionInterface $definitionObject
    ) {
        $files = array_filter($loopPaths, $callback);

        $this->concat(
            $argument,
            $definitionObject,
            $this->makeAbsolute($files, $path, $definitionObject->isRelative())
        );
    }

    /**
     * Make paths absolute if definition matches.
     *
     * @param string $paths
     * @param string $path
     * @param bool   $relative
     * @return string
     */
    protected function makeAbsolute($paths, $path, $relative)
    {
        if (false === $relative) {
            foreach ($paths as $no => $subpath) {
                $paths[$no] = $path . '/' . $subpath;
            }
        }

        return $paths;
    }

    /**
     * Concat paths.
     *
     * @param array                       $argument
     * @param ArgumentDefinitionInterface $definition
     * @param array                       $paths
     */
    protected function concat(array &$argument, ArgumentDefinitionInterface $definition, $paths)
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

    /**
     * Find right application version from definition.
     *
     * @param string $applicationName
     * @param string $version
     * @return Fabiang\Cludearg\Definition\Version
     */
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
