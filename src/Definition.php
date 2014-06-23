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

/**
 *
 */
class Definition implements DefinitionInterface
{

    /**
     * Application.
     *
     * @var Application[]
     */
    protected $applications;

    /**
     * Get applications.
     *
     * @return Application[]
     */
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * Set applications.
     *
     * @param Application[] $applications
     * @return $this
     */
    public function setApplications(array $applications)
    {
        foreach ($applications as $application) {
            $this->addApplication($application);
        }
        return $this;
    }

    /**
     * Add and application.
     *
     * @param Application $application
     * @return $this
     */
    public function addApplication(Application $application)
    {
        $this->applications[$application->getName()] = $application;
        return $this;
    }

    /**
     *
     * @param string $name
     * @return Application
     */
    public function getApplication($name)
    {
        if (isset($this->applications[$name])) {
            return $this->applications[$name];
        }

        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function setOptions(array $options)
    {
        foreach ($options as $name => $applicationDefinition) {
            $application = new Application();
            $application->setName($name);
            $application->setOptions((array) $applicationDefinition);
            $this->addApplication($application);
        }
    }
}
