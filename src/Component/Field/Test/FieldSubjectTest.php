<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Field\Test;

use Mockery;
use Accard\Component\Field\Model\FieldSubjectInterface;

/**
 * Field test subject tests trait.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
trait FieldSubjectTest
{
    public function testFieldSubjectFollowsInterface()
    {
        if (!$this->hasValidSubject()) {
            return $this->fail('Invalid or no field subject provided.');
        }

        $this->assertInstanceOf(
            'Accard\Component\Field\Model\FieldSubjectInterface',
            $this->fieldSubject
        );
    }

    public function testFieldSubjectCanProvideFields()
    {
        if (!$this->hasValidSubject()) {
            return $this->fail('Invalid or no field subject provided.');
        }

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
        if (!$this->hasValidSubject()) {
            return $this->fail('Invalid or no field subject provided.');
        }

        $fieldValue = $this->createCommonFieldValue();
        $iterator = new \ArrayIterator(array($fieldValue));
        $collection = Mockery::mock('Doctrine\Common\Collections\Collection')
            ->shouldReceive('getIterator')->zeroOrMoreTimes()->andReturn($iterator)
            ->getMock();

        $this->fieldSubject->setFields($collection);
        $this->assertAttributeCount(1, 'fields', $this->fieldSubject);
        $this->assertCount(1, $this->fieldSubject->getFields());
    }

    public function testFieldSubjectCanAddField()
    {
        if (!$this->hasValidSubject()) {
            return $this->fail('Invalid or no field subject provided.');
        }

        $fieldValue = $this->createCommonFieldValue();
        $this->fieldSubject->addField($fieldValue);
        $this->assertCount(1, $this->fieldSubject->getFields());
    }

    public function testFieldSubjectDoesNotAddFieldTwice()
    {
        if (!$this->hasValidSubject()) {
            return $this->fail('Invalid or no field subject provided.');
        }

        $fieldValue = $this->createCommonFieldValue();
        $this->fieldSubject->addField($fieldValue);
        $this->fieldSubject->addField($fieldValue);
        $this->assertCount(1, $this->fieldSubject->getFields());
    }

    public function testFieldSubjectDoesNotFindFieldWhenNotPresent()
    {
        if (!$this->hasValidSubject()) {
            return $this->fail('Invalid or no field subject provided.');
        }

        $fieldValue = $this->createCommonFieldValue();
        $this->assertFalse($this->fieldSubject->hasField($fieldValue));
    }

    public function testFieldSubjectFindsFieldWhenPresent()
    {
        if (!$this->hasValidSubject()) {
            return $this->fail('Invalid or no field subject provided.');
        }

        $fieldValue = $this->createCommonFieldValue();
        $this->fieldSubject->addField($fieldValue);
        $this->assertTrue($this->fieldSubject->hasField($fieldValue));
    }

    public function testFieldSubjectCanRemoveField()
    {
        if (!$this->hasValidSubject()) {
            return $this->fail('Invalid or no field subject provided.');
        }

        $fieldValue = $this->createCommonFieldValue();
        $this->fieldSubject->addField($fieldValue);
        $this->fieldSubject->removeField($fieldValue);
        $this->assertCount(0, $this->fieldSubject->getFields());
    }

    public function testFieldSubjectDoesNotFindFieldByNameWhenNotPresent()
    {
        if (!$this->hasValidSubject()) {
            return $this->fail('Invalid or no field subject provided.');
        }

        $this->assertFalse($this->fieldSubject->hasFieldByName('NAME'));
    }

    public function testFieldSubjectCanFindFieldByNameWhenPresent()
    {
        if (!$this->hasValidSubject()) {
            return $this->fail('Invalid or no field subject provided.');
        }

        $fieldValue = $this->createCommonFieldValue();
        $this->fieldSubject->addField($fieldValue);
        $this->assertTrue($this->fieldSubject->hasFieldByName('NAME'));
    }

    public function testFieldSubjectCanGetFieldByNameWhenPresent()
    {
        if (!$this->hasValidSubject()) {
            return $this->fail('Invalid or no field subject provided.');
        }

        $fieldValue = $this->createCommonFieldValue();
        $this->fieldSubject->addField($fieldValue);
        $this->assertSame($fieldValue, $this->fieldSubject->getFieldByName('NAME'));
    }

    public function testFieldSubjectFieldByNameReturnsNullWhenNotPresent()
    {
        if (!$this->hasValidSubject()) {
            return $this->fail('Invalid or no field subject provided.');
        }

        $this->assertNull($this->fieldSubject->getFieldByName('NAME'));
    }

    protected function createCommonFieldValue()
    {
        return Mockery::mock('Accard\Component\Field\Model\FieldValueInterface')
            ->shouldReceive('setSubject')->zeroOrMoreTimes()->andReturn($this->fieldSubject)
            ->shouldReceive('getName')->zeroOrMoreTimes()->andReturn('NAME')
            ->getMock();
    }

    protected function hasValidSubject()
    {
        return isset($this->fieldSubject) && $this->fieldSubject instanceof FieldSubjectInterface;
    }
}
