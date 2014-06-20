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

namespace Fabiang\Cludearg\Definition;

/**
 *
 */
interface ArgumentDefinitionInterface
{
    /**
     * Get parameter defintion.
     *
     * @return string
     */
    public function getParameter();

    /**
     * Get separator between paths or files.
     *
     * @return string
     */
    public function getSeparator();

    /**
     * Path or file definition supports wildcards.
     *
     * @return bool
     */
    public function isWildcard();

    /**
     * Path or file definition supports regex.
     *
     * @return bool
     */
    public function isRegex();

    /**
     * Parameter can be used multiple times.
     *
     * @return bool
     */
    public function isMultiple();

    /**
     * Path or file definition must be relative to the source path.
     *
     * @return bool
     */
    public function isRelative();

    /**
     * Set parameter defintion.
     *
     * @param string $parameter
     * @return $this
     */
    public function setParameter($parameter);
    /**
     * Set separator between paths or files.
     *
     * @param string $separator
     * @return $this
     */
    public function setSeparator($separator);

    /**
     * Path or file definition supports wildcards.
     *
     * @param bool $wildcard
     * @return $this
     */
    public function setWildcard($wildcard);

    /**
     * Path or file definition supports regex.
     *
     * @param string $regex
     * @return $this
     */
    public function setRegex($regex);

    /**
     * Parameter can be used multiple times.
     *
     * @param string $multiple
     * @return $this
     */
    public function setMultiple($multiple);
    /**
     * Path or file definition must be relative to the source path.
     *
     * @param string $relative
     * @return $this
     */
    public function setRelative($relative);
}
