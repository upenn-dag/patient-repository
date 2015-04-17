<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Prototype\Model;

use Mockery;
use Accard\Component\Field\Test\FieldSubjectTest;
use Accard\Component\Field\Test\Stub\FieldSubject;
use Accard\Component\Prototype\Test\Stub\PrototypeSubject;
use Accard\Component\Prototype\Model\Prototype;

/**
 * Accard prototype model tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PrototypeTest extends \Codeception\TestCase\Test
{
    use FieldSubjectTest; // Include field subjects tests.

    protected function _before()
    {
        $this->prototype = new Prototype();
        $this->fieldSubject = new PrototypeSubject();
    }

    public function testPrototypeInterfaceIsFollowed()
    {
        $this->assertInstanceOf(
            'Accard\Component\Prototype\Model\PrototypeInterface',
            $this->prototype
        );
    }

    public function testPrototypeIsAccardResource()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Model\ResourceInterface',
            $this->prototype
        );
    }

    public function testPrototypeIdIsUnsetOnCreation()
    {
        $this->assertNull($this->prototype->getId());
    }

    public function testPrototypeNameIsMutable()
    {
        $this->prototype->setName('NAME');
        $this->assertAttributeSame('NAME', 'name', $this->prototype);
        $this->assertSame('NAME', $this->prototype->getName());
    }

    public function testPrototypePresentationIsMutable()
    {
        $this->prototype->setPresentation('PRESENTATION');
        $this->assertAttributeSame('PRESENTATION', 'presentation', $this->prototype);
        $this->assertSame('PRESENTATION', $this->prototype->getPresentation());
    }

    public function testPrototypeDescriptionIsMutable()
    {
        $this->prototype->setDescription('DESCRIPTION');
        $this->assertAttributeSame('DESCRIPTION', 'description', $this->prototype);
        $this->assertSame('DESCRIPTION', $this->prototype->getDescription());
    }

    /**
     * Currently inactive, as we need to refactor the language component.
     *
     * @expectedException LogicException
     */
    public function testPrototypeDescriptionCanBeParsed()
    {
        $subject = $this->createCommonSubject();
        $this->prototype->setDescription('"DESCRIPTION"');
        $this->prototype->getParsedDescription($subject);
    }


    // Prototype subject tests.

    public function testPrototypeSubjectsAreInitializedAndEmptyOnCreation()
    {
        $this->assertAttributeInstanceOf(
            'Doctrine\Common\Collections\Collection',
            'subjects',
            $this->prototype
        );
        $this->assertAttributeCount(0, 'subjects', $this->prototype);
        $this->assertCount(0, $this->prototype->getSubjects());
    }

    public function testPrototypeSubjectCollectionCanBeSetOnItsOwn()
    {
        $collection = Mockery::mock('Doctrine\Common\Collections\Collection');
        $this->prototype->setSubjects($collection);
        $this->assertAttributeSame($collection, 'subjects', $this->prototype);
        $this->assertSame($collection, $this->prototype->getSubjects());
    }

    public function testPrototypeSubjectIsNotDetectedIfNotPresent()
    {
        $this->assertFalse($this->prototype->hasSubject($this->createCommonSubject()));
    }

    public function testPrototypeSubjectIsFoundWhenPresent()
    {
        $subject = $this->createCommonSubject();
        $this->prototype->addSubject($subject);
        $this->assertTrue($this->prototype->hasSubject($subject));
    }

    public function testPrototypeSubjectCanBeAdded()
    {
        $this->prototype->addSubject($this->createCommonSubject());
        $this->assertAttributeCount(1, 'subjects', $this->prototype);
        $this->assertCount(1, $this->prototype->getSubjects());
    }

    public function testPrototypeSubjectPrototypeSetWhenAdded()
    {
        $subject = Mockery::mock('Accard\Component\Prototype\Model\PrototypeSubjectInterface')
            ->shouldReceive('setPrototype')->once()->andReturn(Mockery::self())
            ->getMock();

        $this->prototype->addSubject($subject);
    }

    public function testPrototypeSubjectIsNotAddedTwice()
    {
        $subject = $this->createCommonSubject();
        $this->prototype->addSubject($subject);
        $this->prototype->addSubject($subject);
        $this->assertAttributeCount(1, 'subjects', $this->prototype);
    }

    public function testPrototypeSubjectCanBeRemoved()
    {
        $subject = $this->createCommonSubject();
        $this->prototype->addSubject($subject);
        $this->prototype->removeSubject($subject);
        $this->assertAttributeCount(0, 'subjects', $this->prototype);
    }

    public function testPrototypeStringConversionValueIsRepresented()
    {
        $this->assertInternalType('string', (string) $this->prototype);
        $this->assertEquals('', (string) $this->prototype);
    }

    public function testPrototypeStringConversionYieldsName()
    {
        $this->prototype->setName('NAME');
        $this->assertEquals('NAME', (string) $this->prototype);
    }


    // Prototype field tests.

    public function testPrototypeFieldsAreInitializedAndEmptyOnCreation()
    {
        $this->assertAttributeInstanceOf(
            'Doctrine\Common\Collections\Collection',
            'fields',
            $this->prototype
        );
        $this->assertAttributeCount(0, 'fields', $this->prototype);
        $this->assertCount(0, $this->prototype->getFields());
    }

    public function testPrototypeFieldCollectionCanBeSetOnItsOwn()
    {
        $collection = Mockery::mock('Doctrine\Common\Collections\Collection');
        $this->prototype->setFields($collection);
        $this->assertAttributeSame($collection, 'fields', $this->prototype);
        $this->assertSame($collection, $this->prototype->getFields());
    }

    public function testPrototypeFieldIsNotDetectedIfNotPresent()
    {
        $this->assertFalse($this->prototype->hasField($this->createCommonField()));
    }

    public function testPrototypeFieldIsFoundWhenPresent()
    {
        $field = $this->createCommonField();
        $this->prototype->addField($field);
        $this->assertTrue($this->prototype->hasField($field));
    }

    public function testPrototypeFieldIsNotDetectedByNameIfNotPresent()
    {
        $this->assertFalse($this->prototype->hasFieldByName('NAME'));
    }

    public function testPrototypeFieldIsFoundByNameWhenPresent()
    {
        $field = $this->createCommonField();
        $this->prototype->addField($field);
        $this->assertTrue($this->prototype->hasFieldByName('NAME'));
    }

    public function testPrototypeFieldCanBeAdded()
    {
        $this->prototype->addField($this->createCommonField());
        $this->assertAttributeCount(1, 'fields', $this->prototype);
        $this->assertCount(1, $this->prototype->getFields());
    }

    public function testPrototypeFieldIsNotAddedTwice()
    {
        $field = $this->createCommonField();
        $this->prototype->addField($field);
        $this->prototype->addField($field);
        $this->assertAttributeCount(1, 'fields', $this->prototype);
    }

    public function testPrototypeFieldCanBeRemoved()
    {
        $field = $this->createCommonField();
        $this->prototype->addField($field);
        $this->prototype->removeField($field);
        $this->assertAttributeCount(0, 'fields', $this->prototype);
    }

    public function testPrototypeFieldIsNotRemovedWhenNotPresent()
    {
        $field = $this->createCommonField();
        $this->prototype->removeField($field);
        $this->assertAttributeCount(0, 'fields', $this->prototype);
    }

    public function testPrototypeFieldIsNotFoundIfNotPresent()
    {
        $this->assertNull($this->prototype->getFieldByName('NAME'));
    }

    public function testPrototypeFieldCanBeFoundByNameWhenPresent()
    {
        $field = $this->createCommonField();
        $this->prototype->addField($field);
        $this->assertSame($field, $this->prototype->getFieldByName('NAME'));
    }


    // Helper methods.

    protected function createCommonSubject()
    {
        return Mockery::mock('Accard\Component\Prototype\Model\PrototypeSubjectInterface')
            ->shouldReceive('setPrototype')->zeroOrMoreTimes()->andReturn(Mockery::self())
            ->getMock();
    }

    protected function createCommonField()
    {
        return Mockery::mock('Accard\Component\Field\Model\FieldInterface')
            ->shouldReceive('getName')->zeroOrMoreTimes()->andReturn('NAME')
            ->getMock();
    }
}
