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

namespace Fabiang\Cludearg\Util;

/**
 *
 */
class Version
{

    /**
     * Find most matching version.
     *
     * @param string                                          $version
     * @param \Fabiang\Cludearg\Definition\VersionInterface[] $versions
     * @return \Fabiang\Cludearg\Definition\VersionInterface
     */
    public static function findMostMatching($version, array $versions)
    {
        $versionMatches = array();

        if (0 === count($versions)) {
            return false;
        }

        $version = preg_replace('/-.*$/', '', explode('.', $version));

        foreach ($versions as $versionObject) {
            $versionMatchString = $versionObject->getVersion();
            $versionExplode = explode('.', $versionMatchString);

            $w = 0;
            foreach ($version as $i => $versionPart) {
                if (!isset($versionExplode[$i])) {
                    continue 1;
                }

                if ($versionPart === $versionExplode[$i]) {
                    $w++;
                } elseif ('*' !== $versionExplode[$i]) {
                    break;
                }
            }

            $versionMatches[$w] = $versionObject;
        }

        // find highest key and return object for that key
        $key = max(array_keys($versionMatches));

        if (0 === $key) {
            return false;
        }

        return $versionMatches[$key];
    }
}
