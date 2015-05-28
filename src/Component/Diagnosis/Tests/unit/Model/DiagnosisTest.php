<?php
namespace model;
use Accard\Component\Diagnosis\Model\Diagnosis;
use Mockery;

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

    protected function _after()
    {
    }

    /**
     * Interface tests
     */
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

    /**
     * Diagnosis->id
     */
    public function testDiagnosisIdIsUnsetOnCreation()
    {
        $this->assertNull($this->diagnosis->getId());
    }

    /**
     * Diagnosis->parent
     */
    public function testDiagnosisParentIsUnsetOnCreation()
    {
        $this->assertNull($this->diagnosis->getParent());
    }

    /**
     * Diagnosis->primary
     */
    public function testDiagnosisPrimaryIsUnsetOnCreation()
    {
        $this->assertNull($this->diagnosis->getPrimary());
    }


    /**
     * Diagnosis->startDate
     */
    public function testDiagnosisStartDateIsUnsetOnCreation()
    {
        $this->assertNull($this->diagnosis->getStartDate());
    }

    /**
     * Diagnosis->endDate
     */
    public function testDiagnosisEndDateIsUnsetOnCreation()
    {
        $this->assertNull($this->diagnosis->getEndDate());
    }

   public function testDiagnosisFieldsAreArrayCollectionOnCreation()
    {
        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $this->diagnosis->getFields());
    }

   
}