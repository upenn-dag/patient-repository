<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Prototype\Test;

use Mockery;
use Accard\Component\Prototype\Model\PrototypeSubjectInterface;

/**
 * Prototype common test case.
 *
 * This test case is to be included within prototype subject tests. It
 * will automatically test prototyping functionality for that subject.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
trait PrototypeTest
{
    public function testPrototypeSubjectFollowsPrototypeSubjectInterface()
    {
        if (!$this->hasValidSubject()) {
            return $this->fail('Invalid or no prototype subject provided.');
        }

        $this->assertInstanceOf(
            'Accard\Component\Prototype\Model\PrototypeSubjectInterface',
            $this->prototypeSubject
        );
    }

    public function testPrototypeSubjectPrototypeIsMutable()
    {
        if (!$this->hasValidSubject()) {
            return $this->fail('Invalid or no prototype subject provided.');
        }

        $prototype = $this->createCommonPrototype();
        $this->prototypeSubject->setPrototype($prototype);
        $this->assertAttributeSame($prototype, 'prototype', $this->prototypeSubject);
        $this->assertSame($prototype, $this->prototypeSubject->getPrototype());
    }

    public function testPrototypeSubjectDescriptionProxyIsTriggeredWhenGettingDescription()
    {
        if (!$this->hasValidSubject()) {
            return $this->fail('Invalid or no prototype subject provided.');
        }

        $prototype = Mockery::mock('Accard\Component\Prototype\Model\PrototypeInterface')
            ->shouldReceive('getParsedDescription')->once()->andReturn('DESCRIPTION')
            ->getMock();

        $this->prototypeSubject->setPrototype($prototype);
        $this->assertSame('DESCRIPTION', $this->prototypeSubject->getDescription());
    }

    protected function createCommonPrototype()
    {
        return Mockery::mock('Accard\Component\Prototype\Model\PrototypeInterface');
    }

    protected function hasValidSubject()
    {
        return isset($this->prototypeSubject) && $this->prototypeSubject instanceof PrototypeSubjectInterface;
    }
}
