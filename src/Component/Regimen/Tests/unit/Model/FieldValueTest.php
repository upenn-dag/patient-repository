<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Regimen\Model;

use Mockery;
use Codeception\TestCase\Test;
use Accard\Component\Regimen\Model\FieldValue;
use Accard\Component\Regimen\Model\FieldValueInterface;

class FieldValueTest extends Test
{
    protected function _before()
    {
        $this->regimen = Mockery::mock('Accard\Component\Regimen\Model\Regimen');
        $this->fieldValue = new FieldValue();
    }

    /**
     * Interface tests
     */
    public function testFieldValueInterfaceIsFollowed()
    {
        $this->assertInstanceOf(
            'Accard\Component\Regimen\Model\FieldValueInterface',
            $this->fieldValue
        );
    }

    public function testFieldValueIdIsUnsetOnCreation()
    {
        $this->assertNull($this->fieldValue->getId());
    }

    public function testFieldValueSubjectIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'subject', $this->fieldValue);
    }

    public function testFieldValueHasRegimenAliasForSettingSubject()
    {
        $this->fieldValue->setRegimen($this->regimen);
        $this->assertAttributeSame($this->regimen, 'subject', $this->fieldValue);
    }

    public function testFieldValueHasRegimenAliasForGettingSubject()
    {
        $this->fieldValue->setRegimen($this->regimen);
        $this->assertSame($this->regimen, $this->fieldValue->getRegimen());
    }
}
