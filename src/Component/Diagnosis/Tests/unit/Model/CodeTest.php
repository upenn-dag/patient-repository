<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Diagnosis\Model;

use Mockery;
use Accard\Component\Diagnosis\Model\Code;

/**
 * Diagnosis code model tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class CodeTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
      $this->code = new Code;
    }

    public function testCodeInterfaceIsFollowed()
    {
        $this->assertInstanceOf(
            'Accard\Component\Diagnosis\Model\CodeInterface',
            $this->code
        );
    }

    public function testCodeIsAccardResource()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Model\ResourceInterface',
            $this->code
        );
    }

    public function testCodeIdIsUnsetOnCreation()
    {
        $this->assertNull($this->code->getId());
    }

    public function testCodeDescriptionIsMutable()
    {
        $this->code->setDescription('NAME');
        $this->assertAttributeSame('NAME', 'description', $this->code);
        $this->assertSame('NAME', $this->code->getDescription());
    }

    public function testCodeGroupsIsMutable()
    {
        $group = Mockery::mock('Accard\Component\Diagnosis\Model\CodeGroupInterface');
        $this->code->addGroup($group);
        $this->assertEquals($this->code->getGroups()->count(),1);
    }
}
