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
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2014-06-20 at 14:48:29.
 */
class FileTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var File
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new File;
    }

    /**
     * @covers Fabiang\Cludearg\Definition\File::getParameter
     * @covers Fabiang\Cludearg\Definition\File::setParameter
     */
    public function testSetAndGetParameter()
    {
        $this->assertSame('1', $this->object->setParameter(1)->getParameter());
    }

    /**
     * @covers Fabiang\Cludearg\Definition\File::getSeparator
     * @covers Fabiang\Cludearg\Definition\File::setSeparator
     */
    public function testSetAndGetSeparator()
    {
        $this->assertSame('2', $this->object->setSeparator(2)->getSeparator());
        $this->assertNull($this->object->setSeparator(null)->getSeparator());
    }

    /**
     * @covers Fabiang\Cludearg\Definition\File::isWildcard
     * @covers Fabiang\Cludearg\Definition\File::setWildcard
     */
    public function testSetAndIsWildcard()
    {
        $this->assertTrue($this->object->setWildcard(1)->isWildcard());
    }

    /**
     * @covers Fabiang\Cludearg\Definition\File::isRegex
     * @covers Fabiang\Cludearg\Definition\File::setRegex
     */
    public function testSetAndIsRegex()
    {
        $this->assertTrue($this->object->setRegex(1)->isRegex());
    }

    /**
     * @covers Fabiang\Cludearg\Definition\File::isMultiple
     * @covers Fabiang\Cludearg\Definition\File::setMultiple
     */
    public function testSetAndIsMultiple()
    {
        $this->assertTrue($this->object->setMultiple(1)->isMultiple());
    }

    /**
     * @covers Fabiang\Cludearg\Definition\File::isRelative
     * @covers Fabiang\Cludearg\Definition\File::setRelative
     */
    public function testSetAndIsRelative()
    {
        $this->assertTrue($this->object->setRelative(1)->isRelative());
    }

    /**
     * @covers Fabiang\Cludearg\Definition\File::setOptions
     * @uses Fabiang\Cludearg\Definition\AbstractArgumentDefinition
     */
    public function testSetOptions()
    {
        $this->object->setOptions(array(
            'parameter' => '%s',
            'separator' => null,
            'wildcard'  => true,
            'regex'     => true,
            'multiple'  => true,
            'relative'  => true
        ));
        $this->assertSame('%s', $this->object->getParameter());
        $this->assertNull($this->object->getSeparator());
        $this->assertTrue($this->object->isMultiple());
        $this->assertTrue($this->object->isRegex());
        $this->assertTrue($this->object->isRelative());
    }
}
