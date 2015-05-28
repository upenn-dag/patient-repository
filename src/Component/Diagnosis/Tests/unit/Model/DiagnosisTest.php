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

use Accard\Component\Diagnosis\Model\Diagnosis;
use Mockery;

/**
 * Diagnosis model tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DiagnosisTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
         $this->diagnosis = new Diagnosis;
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
        $this->assertNull($this->diagnosis->getId());
    }

    public function testDiagnosisParentIsUnsetOnCreation()
    {
        $this->assertNull($this->diagnosis->getParent());
    }

    public function testDiagnosisPrimaryIsUnsetOnCreation()
    {
        $this->assertNull($this->diagnosis->getPrimary());
    }

    public function testDiagnosisStartDateIsUnsetOnCreation()
    {
        $this->assertNull($this->diagnosis->getStartDate());
    }

    public function testDiagnosisEndDateIsUnsetOnCreation()
    {
        $this->assertNull($this->diagnosis->getEndDate());
    }

   public function testDiagnosisFieldsAreArrayCollectionOnCreation()
    {
        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $this->diagnosis->getFields());
    }
}
