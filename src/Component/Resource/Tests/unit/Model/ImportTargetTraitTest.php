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
use Accard\Component\Resource\Test\Stub\ImportTarget;
use Accard\Component\Resource\Model\ImportTargetInterface;

/**
 * Import target trait tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ImportTargetTraitTest extends Test
{
    public function _before()
    {
        $this->importSubject = Mockery::mock('Accard\Component\Resource\Model\ImportSubjectInterface');
        $this->importTarget = new ImportTarget();

        $this->descriptions = array(
            'Importer 1' => array(
                'Description 1.1',
                'Description 1.2',
            ),
            'Importer 2' => array(),
        );
    }

    // For internal use.
    public function testImportTargetImplementsInterface()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Model\ImportTargetInterface',
            $this->importTarget
        );
    }

    public function testImportTargetStatusIsActiveOnCreation()
    {
        $this->assertAttributeSame(ImportTargetInterface::ACTIVE, 'status', $this->importTarget);
        $this->assertSame(ImportTargetInterface::ACTIVE, $this->importTarget->getStatus());
    }

    public function testImportTargetStatusIsMutable()
    {
        $expected = ImportTargetInterface::ACCEPTED;
        $this->importTarget->setStatus($expected);
        $this->assertSame($expected, $this->importTarget->getStatus());
    }

    public function testImportTargetSubjectIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'subject', $this->importTarget);
        $this->assertNull($this->importTarget->getImportSubject());
        $this->assertFalse($this->importTarget->hasImportSubject());
    }

    public function testImportTargetSubjectIsMutable()
    {
        $expected = $this->importSubject;
        $this->importTarget->setImportSubject($expected);
        $this->assertSame($expected, $this->importTarget->getImportSubject());
    }

    public function testImportTargetSubjectIsFluent()
    {
        $this->assertSame($this->importTarget, $this->importTarget->setImportSubject($this->importSubject));
    }

    public function testImportTargetSubjectIsNullable()
    {
        $this->importTarget->setImportSubject(null);
        $this->assertNull($this->importTarget->getImportSubject());
    }

    public function testImportTargetImportersAreEmptyArrayOnCreation()
    {
        $this->assertAttributeInternalType('array', 'descriptions', $this->importTarget);
        $this->assertAttributeEmpty('descriptions', $this->importTarget);
    }

    // Internal use only
    public function testImportTargetTestRegistersTwoImporters()
    {
        $this->configureDescriptions();
        $this->assertCount(2, $this->importTarget->getRegisteredImporters(), 'You have altered the import descriptions without updating all tests.');
    }

    public function testImportTargetImportersCanBeListed()
    {
        $this->configureDescriptions();
        $expected = array('Importer 1', 'Importer 2');
        $this->assertSame($expected, $this->importTarget->getRegisteredImporters());
    }

    public function testImportTargetImporterCanNotBeFoundWhenNotPresent()
    {
        $this->assertFalse($this->importTarget->hasImporter('Not found'));
    }

    public function testImportTargetImporterCanBeLocatedWhenPresent()
    {
        $this->configureDescriptions();
        $this->assertTrue($this->importTarget->hasImporter('Importer 1'));
    }

    public function testImportTargetImporterCanBeRegistered()
    {
        $this->importTarget->registerImporter('Importer 3');
        $this->assertCount(1, $this->importTarget->getRegisteredImporters());
        $this->assertTrue($this->importTarget->hasImporter('Importer 3'));
    }

    public function testImportTargetDoesNotReregisterImporters()
    {
        $this->configureDescriptions();
        $this->importTarget->registerImporter('Importer 1');

        // If it were reset, the descriptions would be reset...
        $this->assertCount(2, $this->importTarget->getDescriptionsFor('Importer 1'));
    }

    public function testImportTargetRegisterImporterIsFluent()
    {
        $this->assertSame($this->importTarget, $this->importTarget->registerImporter('Importer 1'));
    }

    public function testImportTargetCanUnregisterImporter()
    {
        $this->configureDescriptions();
        $this->importTarget->unregisterImporter('Importer 1');
        $this->assertCount(1, $this->importTarget->getRegisteredImporters());
    }

    public function testImportTargetUnregisterImporterIsFluent()
    {
        $this->configureDescriptions();
        $this->assertSame($this->importTarget, $this->importTarget->unregisterImporter('Importer 1'));
    }

    public function testImporterTargetReturnsAllDescriptions()
    {
        $this->configureDescriptions();
        $this->assertSame($this->descriptions, $this->importTarget->getDescriptions());
    }

    public function testImportTargetCanReturnDescriptionsWhenPresent()
    {
        $this->configureDescriptions();
        $this->assertSame($this->descriptions['Importer 1'], $this->importTarget->getDescriptionsFor('Importer 1'));
    }

    public function testImportTargetReturnsNullWhenRequestedDescriptionsNotFound()
    {
        $this->assertNull($this->importTarget->getDescriptionsFor('Not found'));
    }

    public function testImportTargetCanDetectDescriptionsWhenPresent()
    {
        $this->configureDescriptions();
        $this->assertTrue($this->importTarget->hasDescriptions('Importer 1'));
    }

    public function testImportTargetDoesNotDetectDescriptionsNotPresent()
    {
        $this->assertFalse($this->importTarget->hasDescriptions('Not found'));
    }

    public function testImportTargetDoesNotReportDescriptionsForEmptyImporter()
    {
        $this->assertFalse($this->importTarget->hasDescriptions('Importer 2'));
    }

    public function testImportTargetAddsImporterWhenNotFoundDuringDescriptionAdding()
    {
        $this->importTarget->addDescription('Importer 3', 'Description 3.1');
        $this->assertCount(1, $this->importTarget->getDescriptions());
    }

    public function testImportTargetAddsDescriptionsToExistingImporters()
    {
        $this->configureDescriptions();
        $this->importTarget->addDescription('Importer 1', 'Description 1.3');
        $this->assertCount(3, $this->importTarget->getDescriptionsFor('Importer 1'));
    }

    public function testImportTargetAddDescriptionIsFluent()
    {
        $this->assertSame($this->importTarget, $this->importTarget->addDescription('Importer 1', 'Description 1.1'));
    }

    public function testImportTargetIsAbleToClearDescriptionsForAnImporter()
    {
        $this->configureDescriptions();
        $this->importTarget->clearDescriptions('Importer 1');
        $this->assertCount(0, $this->importTarget->getDescriptionsFor('Importer 1'));
    }

    public function testImportClearDoesNotCreateNewImporters()
    {
        $this->importTarget->clearDescriptions('Not found');
        $this->assertCount(0, $this->importTarget->getRegisteredImporters());
    }

    public function testImportTargetClearDescriptionsIsFluent()
    {
        $this->configureDescriptions();
        $this->assertSame($this->importTarget, $this->importTarget->clearDescriptions('Importer 1'));
    }


    // Privates

    private function configureDescriptions()
    {
        $this->importTarget->mergeDescriptions($this->descriptions);
    }
}