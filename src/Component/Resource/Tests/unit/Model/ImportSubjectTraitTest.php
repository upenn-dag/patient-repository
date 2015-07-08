<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Resource\Model;

use Mockery;
use Codeception\TestCase\Test;
use Accard\Component\Resource\Test\Stub\ImportSubject;

/**
 * Import subject trait tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ImportSubjectTraitTest extends Test
{
    public function _before()
    {
        $this->importTarget = Mockery::mock('Accard\Component\Resource\Model\ImportTargetInterface');
        $this->importSubject = new ImportSubject();
    }

    // For internal testing purposes.
    public function testImportSubjectImplementsInterfacE()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Model\ImportSubjectInterface',
            $this->importSubject
        );
    }

    public function testImportSubjectTargetIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'target', $this->importSubject);
        $this->assertNull($this->importSubject->getImportTarget());
        $this->assertFalse($this->importSubject->hasImportTarget());
    }

    public function testImportSubjectIsMutable()
    {
        $this->configureTarget();
        $this->importSubject->setImportTarget($this->importTarget);
        $this->assertAttributeSame($this->importTarget, 'target', $this->importSubject);
    }

    /**
     * @expectedException Accard\Component\Resource\Exception\ImportTargetAlreadySetException
     */
    public function testImportSubjectMayNotBeReset()
    {
        $this->configureTarget();
        $this->importSubject->setImportTarget($this->importTarget);
        $this->importSubject->setImportTarget($this->importTarget);
    }


    // Privates

    private function configureTarget()
    {
        $this->importTarget->shouldReceive('setImportSubject')->with($this->importSubject)->once();
    }
}
