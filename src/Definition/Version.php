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
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS 'AS IS' AND
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
class Version implements VersionInterface, DefinitionInterface
{

    /**
     * Version string.
     *
     * @var string
     */
    protected $version;

    /**
     * Ordering of arguments.
     *
     * @var array
     */
    protected $order = array(
        'exclude-paths',
        'exclude-files',
        'include-paths',
        'include-files',
    );

    /**
     * Exclude definition.
     *
     * @var InExcludeInterface
     */
    protected $exclude;

    /**
     * Include definition.
     *
     * @var InExcludeInterface
     */
    protected $include;

    /**
     * {@inheritDoc}
     */
    public function getExclude()
    {
        return $this->exclude;
    }

    /**
     * {@inheritDoc}
     */
    public function getInclude()
    {
        return $this->include;
    }

    /**
     * {@inheritDoc}
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * {@inheritDoc}
     */
    public function setExclude(InExcludeInterface $exclude)
    {
        $this->exclude = $exclude;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setInclude(InExcludeInterface $include)
    {
        $this->include = $include;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setVersion($version)
    {
        $this->version = (string) $version;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * {@inheritDoc}
     */
    public function setOrder(array $order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setOptions(array $options)
    {
        if (isset($options['order'])) {
            $this->setOrder($options['order']);
        }

        if (isset($options['include'])) {
            $include = new IncludeDefinition();
            $include->setOptions((array) $options['include']);
            $this->setInclude($include);
        }

        if (isset($options['exclude'])) {
            $exclude = new ExcludeDefinition();
            $exclude->setOptions((array) $options['exclude']);
            $this->setExclude($exclude);
        }
    }
}
