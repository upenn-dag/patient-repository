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

use DateTime;
use Mockery;
use Codeception\TestCase\Test;
use Accard\Component\Diagnosis\Model\Diagnosis;
use Accard\Component\Field\Test\FieldSubjectTest;

/**
 * Diagnosis model tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DiagnosisTest extends Test
{
    use FieldSubjectTest;

    protected function _before()
    {
        $this->diagnosis = new Diagnosis;
        $this->startDate = new DateTime('1970-01-01 00:00:00');
        $this->endDate = new DateTime('1980-01-01 00:00:00');
        $this->primary = Mockery::mock('Accard\\Component\\Diagnosis\\Model\\DiagnosisInterface');
        $this->parent = Mockery::mock('Accard\\Component\\Diagnosis\\Model\\DiagnosisInterface');
        $this->recurrence = Mockery::mock('Accard\\Component\\Diagnosis\\Model\\DiagnosisInterface')
            ->shouldReceive('setPrimary')->zeroOrMoreTimes()->andReturn(Mockery::self())
            ->getMock();
        $this->comorbidity = Mockery::mock('Accard\\Component\\Diagnosis\\Model\\DiagnosisInterface')
            ->shouldReceive('setParent')->zeroOrMoreTimes()->andReturn(Mockery::self())
            ->getMock();

        $this->code = Mockery::mock('Accard\\Component\\Diagnosis\\Model\\CodeInterface');

        // Required by field subject test trait above.
        $this->fieldSubject = $this->diagnosis;
    }

    public function testDiagnosisInterfaceIsFollowed()
    {
        $this->assertInstanceOf(
            'Accard\Component\Diagnosis\Model\DiagnosisInterface',
            $this->diagnosis
        );
    }

    public function testDiagnosisIsAccardResource()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Model\ResourceInterface',
            $this->diagnosis
        );
    }

    public function testDiagnosisIdIsUnsetOnCreation()
    {
        $this->assertAttributeSame(null, 'id', $this->diagnosis);
        $this->assertNull($this->diagnosis->getId());
    }

    public function testDiagnosisParentIsUnsetOnCreation()
    {
        $this->assertAttributeSame(null, 'parent', $this->diagnosis);
        $this->assertNull($this->diagnosis->getParent());
    }

    public function testDiagnosisParentIsMutable()
    {
        $expected = $this->parent;
        $this->diagnosis->setParent($expected);
        $this->assertSame($expected, $this->diagnosis->getParent());
    }

    public function testDiagnosisParentIsNullable()
    {
        $this->diagnosis->setParent(null);
        $this->assertNull($this->diagnosis->getParent());
    }

    public function testDiagnosisParentSettingIsFluent()
    {
        $this->assertSame($this->diagnosis, $this->diagnosis->setParent($this->parent));
    }

    public function testDiagnosisPrimaryIsUnsetOnCreation()
    {
        $this->assertAttributeSame(null, 'primary', $this->diagnosis);
        $this->assertNull($this->diagnosis->getPrimary());
    }

    public function testDiagnosisPrimaryIsMutable()
    {
        $expected = $this->primary;
        $this->diagnosis->setPrimary($expected);
        $this->assertSame($expected, $this->diagnosis->getPrimary());
    }

    public function testDiagnosisPrimaryIsNullable()
    {
        $this->diagnosis->setPrimary(null);
        $this->assertNull($this->diagnosis->getPrimary());
    }

    public function testDiagnosisPrimarySettingIsFluent()
    {
        $this->assertSame($this->diagnosis, $this->diagnosis->setPrimary($this->primary));
    }

    public function testDiagnosisCodeIsUnsetOnCreation()
    {
        $this->assertAttributeSame(null, 'code', $this->diagnosis);
        $this->assertNull($this->diagnosis->getCode());
    }

    public function testDiagnosisCodeIsMutable()
    {
        $expected = $this->code;
        $this->diagnosis->setCode($expected);
        $this->assertSame($expected, $this->diagnosis->getCode());
    }

    public function testDiagnosisCodeSettingIsFluent()
    {
        $this->assertSame($this->diagnosis, $this->diagnosis->setCode($this->code));
    }

    public function testDiagnosisStartDateIsUnsetOnCreation()
    {
        $this->assertAttributeSame(null, 'startDate', $this->diagnosis);
        $this->assertNull($this->diagnosis->getStartDate());
    }

    public function testDiagnosisStartDateIsMutable()
    {
        $expected = $this->startDate;
        $this->diagnosis->setStartDate($expected);
        $this->assertSame($expected, $this->diagnosis->getStartDate());
    }

    public function testDiagnosisStartDateSettingIsFluent()
    {
        $this->assertSame($this->diagnosis, $this->diagnosis->setStartDate($this->startDate));
    }

    public function testDiagnosisEndDateIsUnsetOnCreation()
    {
        $this->assertAttributeSame(null, 'endDate', $this->diagnosis);
        $this->assertNull($this->diagnosis->getEndDate());
    }

    public function testDiagnosisEndDateIsMutable()
    {
        $expected = $this->endDate;
        $this->diagnosis->setEndDate($expected);
        $this->assertSame($expected, $this->diagnosis->getEndDate());
    }

    public function testDiagnosisEndDateIsNullable()
    {
        $this->diagnosis->setEndDate(null);
        $this->assertNull($this->diagnosis->getEndDate());
    }

    public function testDiagnosisEndDateSettingIsFluent()
    {
        $this->assertSame($this->diagnosis, $this->diagnosis->setEndDate($this->endDate));
    }

    public function testDiagnosisIsOnGoingWhenNoEndDateIsSet()
    {
        $this->assertTrue($this->diagnosis->isOngoing());
    }

    public function testDiagnosisIsNotOngoingWhenEndDateIsSet()
    {
        $this->diagnosis->setEndDate($this->endDate);
        $this->assertFalse($this->diagnosis->isOngoing());
    }

    public function testDiagnosisRecurrencesAreEmptyCollectionOnCreation()
    {
        $this->assertAttributeInstanceOf('Doctrine\\Common\\Collections\\Collection', 'recurrences', $this->diagnosis);
        $this->assertAttributeCount(0, 'recurrences', $this->diagnosis);
        $this->assertInstanceOf('Doctrine\\Common\\Collections\\Collection', $this->diagnosis->getRecurrences());
        $this->assertCount(0, $this->diagnosis->getRecurrences());
    }

    public function testDiagnosisRecurrenceCanBeAdded()
    {
        $this->diagnosis->addRecurrence($this->recurrence);
        $this->assertCount(1, $this->diagnosis->getRecurrences());
    }

    public function testDiagnosisRecureencesAreNotAddedTwice()
    {
        $this->diagnosis->addRecurrence($this->recurrence);
        $this->diagnosis->addRecurrence($this->recurrence);
        $this->assertCount(1, $this->diagnosis->getRecurrences());
    }

    public function testDiagnosisRecurrenceAddIsFluent()
    {
        $this->assertSame($this->diagnosis, $this->diagnosis->addRecurrence($this->recurrence));
    }

    public function testDiagnosisRecurrencesCanNotBeDetectedWhenNotPresent()
    {
        $this->assertFalse($this->diagnosis->hasRecurrence($this->recurrence));
    }

    public function testDiagnosisRecurrenceCanBeFoundWhenPresent()
    {
        $this->diagnosis->addRecurrence($this->recurrence);
        $this->assertTrue($this->diagnosis->hasRecurrence($this->recurrence));
    }

    public function testDiagnosisRecurrencesCanBeRemoved()
    {
        $this->diagnosis->addRecurrence($this->recurrence);
        $this->diagnosis->removeRecurrence($this->recurrence);
        $this->assertCount(0, $this->diagnosis->getRecurrences());
    }

    public function testDiagnosisRecurrenceDoesNotRemoveNonRequestedRecurrences()
    {
        $recurrence = Mockery::mock('Accard\\Component\\Diagnosis\\Model\\DiagnosisInterface');
        $this->diagnosis->addRecurrence($this->recurrence);
        $this->diagnosis->removeRecurrence($recurrence);
        $this->assertCount(1, $this->diagnosis->getRecurrences());
    }

    public function testDiagnosisRecurrenceRemoveIsFluent()
    {
        $this->assertSame($this->diagnosis, $this->diagnosis->removeRecurrence($this->recurrence));
    }

    public function testDiagnosisComorbiditiesAreEmptyCollectionOnCreation()
    {
        $this->assertAttributeInstanceOf('Doctrine\\Common\\Collections\\Collection', 'comorbidities', $this->diagnosis);
        $this->assertAttributeCount(0, 'comorbidities', $this->diagnosis);
        $this->assertInstanceOf('Doctrine\\Common\\Collections\\Collection', $this->diagnosis->getComorbidities());
        $this->assertCount(0, $this->diagnosis->getComorbidities());
    }

    public function testDiagnosisComorbiditiesCanBeAdded()
    {
        $this->diagnosis->addComorbidity($this->comorbidity);
        $this->assertCount(1, $this->diagnosis->getComorbidities());
    }

    public function testDiagnosisComorbidityIsNotAddedTwice()
    {
        $this->diagnosis->addComorbidity($this->comorbidity);
        $this->diagnosis->addComorbidity($this->comorbidity);
        $this->assertCount(1, $this->diagnosis->getComorbidities());
    }

    public function testDiagnosisComorbidityAddIsFluent()
    {
        $this->assertSame($this->diagnosis, $this->diagnosis->addComorbidity($this->comorbidity));
    }

    public function testDiagnosisComorbidityCanNotBeDetectedWhenNotPresent()
    {
        $this->assertFalse($this->diagnosis->hasComorbidity($this->comorbidity));
    }

    public function testDiagnosisComorbidityCanBeDetectedWhenPresent()
    {
        $this->diagnosis->addComorbidity($this->comorbidity);
        $this->assertTrue($this->diagnosis->hasComorbidity($this->comorbidity));
    }

    public function testDiagnosisComorbidityCanBeRemoved()
    {
        $this->diagnosis->addComorbidity($this->comorbidity);
        $this->diagnosis->removeComorbidity($this->comorbidity);
        $this->assertCount(0, $this->diagnosis->getComorbidities());
    }

    public function testDiagnosisComorbidityDoesNotRemoveNonRequestedComorbidity()
    {
        $comorbidity = Mockery::mock('Accard\\Component\\Diagnosis\\Model\\DiagnosisInterface');
        $this->diagnosis->addComorbidity($this->comorbidity);
        $this->diagnosis->removeComorbidity($comorbidity);
        $this->assertCount(1, $this->diagnosis->getComorbidities());
    }

    public function testDiagnosisComorbidityRemoveIsFluent()
    {
        $this->assertSame($this->diagnosis, $this->diagnosis->removeComorbidity($this->comorbidity));
    }

    public function testDiagnosisCanonicalWithNullCodeAndNullDate()
    {
        $expected = 'Diagnosis';
        $this->assertSame($expected, $this->diagnosis->getCanonical());
    }

    public function testDiagnosisCanonicalWithCodeAndNullDate()
    {
        $expected = 'DESCRIPTION';
        $this->code->shouldReceive('getDescription')->andReturn('DESCRIPTION');
        $this->diagnosis->setCode($this->code);
        $this->assertSame($expected, $this->diagnosis->getCanonical());
    }

    public function testDiagnosisCanonicalWithCodeAndDate()
    {
        $expected = 'DESCRIPTION on 01/01/1970';
        $this->code->shouldReceive('getDescription')->andReturn('DESCRIPTION');
        $this->diagnosis->setCode($this->code);
        $this->diagnosis->setStartDate($this->startDate);
        $this->assertSame($expected, $this->diagnosis->getCanonical());
    }

    public function testDiagnosisCanonicalWithNullCodeAndDate()
    {
        $expected = 'Diagnosis on 01/01/1970';
        $this->diagnosis->setStartDate($this->startDate);
        $this->assertSame($expected, $this->diagnosis->getCanonical());
    }

    public function testDiagnosisToString()
    {
        $expected = 'Diagnosis #0';
        $this->assertSame($expected, (string) $this->diagnosis);
    }
}
