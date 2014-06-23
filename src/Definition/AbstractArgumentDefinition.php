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

use Fabiang\Cludearg\DefinitionInterface;

/**
 *
 */
abstract class AbstractArgumentDefinition implements ArgumentDefinitionInterface, DefinitionInterface
{

    /**
     * Parameter defintion.
     *
     * %s will be replaced by path defintion.
     *
     * @var string
     */
    protected $parameter;

    /**
     * Separator between paths or files.
     *
     * @var string
     */
    protected $separator = null;

    /**
     * Path or file definition supports wildcards.
     *
     * @var bool
     */
    protected $wildcard = false;

    /**
     * Path or file definition supports regex.
     *
     * @var bool
     */
    protected $regex = false;

    /**
     * Parameter can be used multiple times.
     *
     * @var bool
     */
    protected $multiple = false;

    /**
     * Path or file definition must be relative to the source path.
     *
     * @var bool
     */
    protected $relative = false;

    /**
     * {@inheritDoc}
     */
    public function getParameter()
    {
        return $this->parameter;
    }

    /**
     * {@inheritDoc}
     */
    public function getSeparator()
    {
        return $this->separator;
    }

    /**
     * {@inheritDoc}
     */
    public function isWildcard()
    {
        return $this->wildcard;
    }

    /**
     * {@inheritDoc}
     */
    public function isRegex()
    {
        return $this->regex;
    }

    /**
     * {@inheritDoc}
     */
    public function isMultiple()
    {
        return $this->multiple;
    }

    /**
     * {@inheritDoc}
     */
    public function isRelative()
    {
        return $this->relative;
    }

    /**
     * {@inheritDoc}
     */
    public function setParameter($parameter)
    {
        $this->parameter = (string) $parameter;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setSeparator($separator)
    {
        if (null === $separator) {
            $this->separator = null;
        } else {
            $this->separator = (string) $separator;
        }
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setWildcard($wildcard)
    {
        $this->wildcard = (bool) $wildcard;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setRegex($regex)
    {
        $this->regex = (bool) $regex;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setMultiple($multiple)
    {
        $this->multiple = (bool) $multiple;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setRelative($relative)
    {
        $this->relative = (bool) $relative;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setOptions(array $options)
    {
        foreach ($options as $option => $value) {
            $method = 'set' . ucfirst($option);

            if (method_exists($this, $method)) {
                call_user_func(array($this, $method), $value);
            }
        }
    }
}
