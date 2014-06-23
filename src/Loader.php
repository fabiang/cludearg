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

use Fabiang\Cludearg\Definition\Application;
use Fabiang\Cludearg\Definition\Version;
use Fabiang\Cludearg\Definition\InExcludeInterface;
use Fabiang\Cludearg\Definition\IncludeDefinition;
use Fabiang\Cludearg\Definition\ExcludeDefinition;
use Fabiang\Cludearg\Definition\File;
use Fabiang\Cludearg\Definition\Path;

/**
 *
 */
class Loader
{

    /**
     *
     * @param array $definition
     * @return Definition
     */
    public static function load(array $definition)
    {
        $definitionObject = new Definition;

        foreach ($definition as $name => $applicationDefinition) {
            $application = new Application();
            $application->setName($name);

            $versions = array();
            foreach ($applicationDefinition as $version => $versionDefinition) {
                self::addVersion($versions, $version, $versionDefinition);
            }

            $application->setVersions($versions);
            $definitionObject->addApplication($application);
        }

        return $definitionObject;
    }

    private static function addVersion(array &$versions, $version, array $versionDefinition)
    {
        $versionsStrings = explode(',', $version);
        $count = count($versionsStrings);

        if (count($versionsStrings) > 1) {
            for ($i = 0; $i < $count - 1; $i++) {
                self::addVersion($versions, $versionsStrings[$i], $versionDefinition);
            }
        }

        $versionObject = new Version();
        $versionObject->setVersion($versionsStrings[$count - 1]);
        if (isset($versionDefinition['include'])) {
            self::addInclude($versionObject, $versionDefinition['include']);
        }
        if (isset($versionDefinition['exclude'])) {
            self::addExclude($versionObject, $versionDefinition['exclude']);
        }
        $versions[] = $versionObject;
    }

    private static function addInclude(Version $version, $definition)
    {
        $include = new IncludeDefinition();
        $include->setOptions($definition);
        $version->setInclude($include);
    }

    private static function addExclude(Version $version, $definition)
    {
        $exclude = new ExcludeDefinition();
        $exclude->setOptions($definition);
        $version->setExclude($exclude);
    }
}
