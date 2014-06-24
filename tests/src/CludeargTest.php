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

use org\bovigo\vfs\vfsStream;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2014-06-23 at 14:56:03.
 */
class CludeargTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Cludearg
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Cludearg;
        vfsStream::setup('test', null, array(
            'foo.php' => '1',
            'bar.php' => '2',
            'baz.php' => '3',
            'bat.php' => '4',
            'bar' => array(),
            'bat' => array(),
            'moo' => array(),
            'moo.php' => '5',
            'abc' => array()
        ));
    }

    /**
     * @param string $application
     * @param string $version
     * @param array  $include
     * @param array  $exclude
     * @param string $argument
     * @covers Fabiang\Cludearg\Cludearg::getArgument
     * @covers Fabiang\Cludearg\Cludearg::__construct
     * @covers Fabiang\Cludearg\Cludearg::makeAbsolute
     * @covers Fabiang\Cludearg\Cludearg::concat
     * @covers Fabiang\Cludearg\Cludearg::findDefinition
     * @covers Fabiang\Cludearg\Cludearg::addPaths
     * @uses Fabiang\Cludearg\Loader
     * @uses Fabiang\Cludearg\Definition
     * @uses Fabiang\Cludearg\Definition\AbstractInExclude
     * @uses Fabiang\Cludearg\Definition\Application
     * @uses Fabiang\Cludearg\Definition\Version
     * @uses Fabiang\Cludearg\Definition\AbstractArgumentDefinition
     * @uses Fabiang\Cludearg\Util\Version::findMostMatching
     * @dataProvider provideApplications
     */
    public function testGetArgument($application, $version, array $include, array $exclude, $argument)
    {
        $this->assertSame(
            $argument,
            $this->object->getArgument($application, $version, $include, $exclude, vfsStream::url('test/'))
        );
    }

    /**
     * @covers Fabiang\Cludearg\Cludearg::getArgument
     * @covers Fabiang\Cludearg\Cludearg::findDefinition
     * @uses Fabiang\Cludearg\Cludearg::__construct
     * @uses Fabiang\Cludearg\Loader
     * @uses Fabiang\Cludearg\Definition
     * @uses Fabiang\Cludearg\Definition\AbstractInExclude
     * @uses Fabiang\Cludearg\Definition\Application
     * @uses Fabiang\Cludearg\Definition\Version
     * @uses Fabiang\Cludearg\Definition\AbstractArgumentDefinition
     */
    public function testGetArgumentApplicationNotfound()
    {
        $this->assertFalse($this->object->getArgument(
            'not/existing',
            '1.0.0',
            array(),
            array(),
            vfsStream::url('test/')
        ));
    }

    /**
     * @covers Fabiang\Cludearg\Cludearg::getArgument
     * @covers Fabiang\Cludearg\Cludearg::findDefinition
     * @uses Fabiang\Cludearg\Cludearg::__construct
     * @uses Fabiang\Cludearg\Loader
     * @uses Fabiang\Cludearg\Definition
     * @uses Fabiang\Cludearg\Definition\AbstractInExclude
     * @uses Fabiang\Cludearg\Definition\Application
     * @uses Fabiang\Cludearg\Definition\Version
     * @uses Fabiang\Cludearg\Definition\AbstractArgumentDefinition
     * @uses Fabiang\Cludearg\Util\Version::findMostMatching
     */
    public function testGetArgumentVersionNotfound()
    {
        $this->assertFalse($this->object->getArgument(
            'squizlabs/php_codesniffer',
            '2.0.0',
            array(),
            array(),
            vfsStream::url('test/')
        ));
    }

    /**
     * @return array
     */
    public function provideApplications()
    {
        return array(
            array(
                'application' => 'php/lint',
                'version'     => '*',
                'include'     => array('foo.php', 'bar.php'),
                'exclude'     => array('baz.php', 'bat.php'),
                'argument'    => "-l 'vfs://test/foo.php'"
            ),
            array(
                'application' => 'squizlabs/php_codesniffer',
                'version'     => '1.0.1',
                'include'     => array('foo.php', 'bar'),
                'exclude'     => array('baz.php', 'bat'),
                'argument'    => "--ignore='vfs://test/baz.php,vfs://test/bat' 'vfs://test/bar' 'vfs://test/foo.php'"
            ),
            array(
                'application' => 'phpmd/phpmd',
                'version'     => '2.0.0',
                'include'     => array('foo.php', 'bar'),
                'exclude'     => array('baz.php', 'bat'),
                'argument'    => "--exclude 'vfs://test/baz.php,vfs://test/bat' 'vfs://test/bar'"
            ),
            array(
                'application' => 'phpdocumentor/phpdocumentor',
                'version'     => '2.1.0',
                'include'     => array('foo.php', 'bar', 'moo'),
                'exclude'     => array('baz.php', 'bat', 'moo.php', 'abc'),
                'argument'    => "-i 'vfs://test/bat,vfs://test/abc' -d 'vfs://test/bar,vfs://test/moo' "
                . "-f 'vfs://test/foo.php'"
            ),
            array(
                'application' => 'pdepend/pdepend',
                'version'     => '1.1.0',
                'include'     => array('foo.php', 'bar', 'moo'),
                'exclude'     => array('baz.php', 'bat', 'moo.php', 'abc'),
                'argument'    => "--ignore='bat,abc' 'vfs://test/foo.php,vfs://test/bar,vfs://test/moo'"
            ),
            array(
                'application' => 'sebastian/phpcpd',
                'version'     => '2.1.0',
                'include'     => array('foo.php', 'bar', 'moo'),
                'exclude'     => array('baz.php', 'bat', 'moo.php', 'abc'),
                'argument'    => "--exclude='baz.php' --exclude='bat' --exclude='moo.php' --exclude='abc' "
                . "--names='foo.php' 'vfs://test/bar' 'vfs://test/moo'"
            ),
        );
    }
}
