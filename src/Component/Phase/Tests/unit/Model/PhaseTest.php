<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Phase\Model;

use Codeception\TestCase\Test;
use Accard\Component\Phase\Model\Phase;

class PhaseTest extends Test
{
    protected function _before()
    {
        $this->phase = new Phase();
    }

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
            'DAG\Component\Resource\Model\ResourceInterface',
            $this->phase
        );
    }

    public function testPhaseIdIsUnsetOnCreation()
    {
        $this->assertAttributeSame(null, 'id', $this->phase);
        $this->assertNull($this->phase->getId());
    }

    public function testPhaseLabelIsMutable()
    {
        $expected = 'NAME';
        $this->phase->setLabel($expected);
        $this->assertAttributeSame($expected, 'label', $this->phase);
        $this->assertSame($expected, $this->phase->getLabel());
    }

    public function testPhaseLabelSettingIsFluent()
    {
        $this->assertSame($this->phase, $this->phase->setLabel('LABEL'));
    }

    public function testPhasePresentationIsUnsetOnCreation()
    {
        $this->assertAttributeSame(null, 'presentation', $this->phase);
        $this->assertNull($this->phase->getPresentation());
    }

    public function testPhasePresentationIsMutable()
    {
        $expected = 'PRESENTATION';
        $this->phase->setPresentation($expected);
        $this->assertAttributeSame($expected, 'presentation', $this->phase);
        $this->assertSame($expected, $this->phase->getPresentation());
    }

    public function testPhasePresentationSettingIsMutable()
    {
        $this->assertSame($this->phase, $this->phase->setPresentation('PRESENTATION'));
    }

    public function testPhaseOrderIs99OnCreation()
    {
        $this->assertSame(99, $this->phase->getOrder());
    }

    public function testPhaseOrderIsMutable()
    {
        $expected = 1;
        $this->phase->setOrder($expected);
        $this->assertAttributeSame($expected, 'order', $this->phase);
        $this->assertSame($expected, $this->phase->getOrder());
    }

    public function testPhaseOrderSettingIsFluent()
    {
        $this->assertSame($this->phase, $this->phase->setOrder(1));
    }
}
