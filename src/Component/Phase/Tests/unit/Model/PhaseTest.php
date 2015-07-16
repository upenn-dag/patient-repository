<?php
namespace AccardTest\Component\Phase\Model;

/**
 * Phase test
 * 
 * @author Dylan Pierce <piecedy@upenn.edu>
 */
use Accard\Component\Phase\Model\Phase;

class PhaseTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->phase = new Phase();
    }

    protected function _after()
    {
    }

    /**
     * Interface tests
     */
    public function testPhaseInterfaceIsFollowed()
    {
        $this->assertInstanceOf(
            'Accard\Component\Phase\Model\PhaseInterface',
            $this->phase
        );
    }

    public function testPhaseIsAccardResource()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Model\ResourceInterface',
            $this->phase
        );
    }

    /**
     * Phase->id
     */
    public function testPhaseIdIsUnsetOnCreation()
    {
        $this->assertNull($this->phase->getId());
    }

    /**
     * Phase->label
     */
    public function testPhaseLabelIsMutable()
    {
        $this->phase->setLabel('NAME');
        $this->assertAttributeSame('NAME', 'label', $this->phase);
        $this->assertSame('NAME', $this->phase->getLabel());
    }

    /**
     * Phase->presentation
     */
    public function testPhasePresentationIsMutable()
    {
        $this->phase->setPresentation('NAME');
        $this->assertAttributeSame('NAME', 'presentation', $this->phase);
        $this->assertSame('NAME', $this->phase->getPresentation());
    }

    /**
     * Phase->order
     */
    public function testPhaseOrderIs99OnCreation()
    {
        $this->assertSame(99, $this->phase->getOrder());
    }

    public function testPhaseOrderIsMutable()
    {
        $this->phase->setOrder(1);
        $this->assertAttributeSame(1, 'order', $this->phase);
        $this->assertSame(1, $this->phase->getOrder());
    }

}