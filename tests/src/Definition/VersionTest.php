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
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2014-06-20 at 15:33:33.
 */
class VersionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Version
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Version;
    }

    /**
     * @covers Fabiang\Cludearg\Definition\Version::getExclude
     * @covers Fabiang\Cludearg\Definition\Version::setExclude
     */
    public function testSetAndGetExclude()
    {
        $exclude = $this->getMock(__NAMESPACE__ . '\\InExcludeInterface');
        $this->assertSame($exclude, $this->object->setExclude($exclude)->getExclude());
    }

    /**
     * @covers Fabiang\Cludearg\Definition\Version::getInclude
     * @covers Fabiang\Cludearg\Definition\Version::setInclude
     */
    public function testSetAndGetInclude()
    {
        $include = $this->getMock(__NAMESPACE__ . '\\InExcludeInterface');
        $this->assertSame($include, $this->object->setInclude($include)->getInclude());
    }

    /**
     * @covers Fabiang\Cludearg\Definition\Version::getVersion
     * @covers Fabiang\Cludearg\Definition\Version::setVersion
     */
    public function testSetAndGetVersion()
    {
        $this->assertSame('1', $this->object->setVersion(1)->getVersion());
    }
}
