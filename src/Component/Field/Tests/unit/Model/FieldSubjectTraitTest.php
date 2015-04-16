<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Model;

require __DIR__.'/../Stub/FieldSubject.php';

use Mockery;
use Stub\FieldSubject;

/**
 * Field subject trait tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FieldSubjectTraitTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->fieldSubject = new FieldSubject();
        $this->fieldValue = Mockery::mock('Accard\Component\Field\Model\FieldValueInterface')
            ->shouldReceive('setSubject')->zeroOrMoreTimes()->andReturn($this->fieldSubject)
            ->shouldReceive('getName')->zeroOrMoreTimes()->andReturn('NAME')
            ->getMock();
    }

    public function testFieldSubjectCanProvideFields()
    {
        // This test works ONLY because the stub initalizes the data properly.
        $this->assertAttributeInstanceOf(
            'Doctrine\Common\Collections\Collection',
            'fields',
            $this->fieldSubject
        );

        $this->assertInstanceOf(
            'Doctrine\Common\Collections\Collection',
            $this->fieldSubject->getFields()
        );
    }

    public function testFieldSubjectCanSetAllFieldsAtOnce()
    {
        $iterator = new \ArrayIterator(array($this->fieldValue));
        $collection = Mockery::mock('Doctrine\Common\Collections\Collection')
            ->shouldReceive('getIterator')->zeroOrMoreTimes()->andReturn($iterator)
            ->getMock();

        $this->fieldSubject->setFields($collection);
        $this->assertAttributeCount(1, 'fields', $this->fieldSubject);
        $this->assertCount(1, $this->fieldSubject->getFields());
    }

    public function testFieldSubjectCanAddField()
    {
        $this->fieldSubject->addField($this->fieldValue);
        $this->assertCount(1, $this->fieldSubject->getFields());
    }

    public function testFieldSubjectDoesNotAddFieldTwice()
    {
        $this->fieldSubject->addField($this->fieldValue);
        $this->fieldSubject->addField($this->fieldValue);
        $this->assertCount(1, $this->fieldSubject->getFields());
    }

    public function testFieldSubjectDoesNotFindFieldWhenNotPresent()
    {
        $this->assertFalse($this->fieldSubject->hasField($this->fieldValue));
    }

    public function testFieldSubjectFindsFieldWhenPresent()
    {
        $this->fieldSubject->addField($this->fieldValue);
        $this->assertTrue($this->fieldSubject->hasField($this->fieldValue));
    }

    public function testFieldSubjectCanRemoveField()
    {
        $this->fieldSubject->addField($this->fieldValue);
        $this->fieldSubject->removeField($this->fieldValue);
        $this->assertCount(0, $this->fieldSubject->getFields());
    }

    public function testFieldSubjectDoesNotFindFieldByNameWhenNotPresent()
    {
        $this->assertFalse($this->fieldSubject->hasFieldByName('NAME'));
    }

    public function testFieldSubjectCanFindFieldByNameWhenPresent()
    {
        $this->fieldSubject->addField($this->fieldValue);
        $this->assertTrue($this->fieldSubject->hasFieldByName('NAME'));
    }

    public function testFieldSubjectCanGetFieldByNameWhenPresent()
    {
        $this->fieldSubject->addField($this->fieldValue);
        $this->assertSame($this->fieldValue, $this->fieldSubject->getFieldByName('NAME'));
    }

    public function testFieldSubjectFieldByNameReturnsNullWhenNotPresent()
    {
        $this->assertNull($this->fieldSubject->getFieldByName('NAME'));
    }
}
