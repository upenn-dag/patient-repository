<?php
namespace Accard\Bundle\ResourceBundle\Tests\Import;

/**
 * Test \ Import \ Manager
 * 
 * @author Frank Bardon Jr. <frankf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */

use Accard\Bundle\ResourceBundle\Tests\ImportTestCase;
use Accard\Bundle\ResourceBundle\Import\Manager;

class ManagerTest extends ImportTestCase
{
    private $defaultInitializer;
    private $defaultConverter;
    private $defaultPersister;

    /**
     * Create manager
     */
    private function createManager()
    {
        $this->defaultInitializer = $initializer = $this->getMock(self::INITIALIZER_INTERFACE);
        $this->defaultConverter = $converter = $this->getMock(self::CONVERTER_INTERFACE);
        $this->defaultPersister = $persister = $this->getMock(self::PERSISTER_INTERFACE);

        return new Manager($initializer, $converter, $persister);
    }

    /**
     * Manager calls initalize on initializer
     */
    public function testConstructionSetsParamatersToProperties()
    {
        $manager = $this->createManager();

        $this->assertAttributeSame($this->defaultInitializer, 'initializer', $manager);
        $this->assertAttributeSame($this->defaultConverter, 'converter', $manager);
        $this->assertAttributeSame($this->defaultPersister, 'persister', $manager);
    }

    /**
     * Manager calls initialize on initializer
     */
    public function testInitializerInitialization()
    {
        $manager = $this->createManager();
        $mockEvent = $this->createImportEventMock();

        $this->defaultInitializer
            ->expects($this->once())
            ->method('initialize')
            ->with($this->equalTo($mockEvent));

        $this->assertNull($manager->initialize($mockEvent));
    }

    /**
     * Manager calls convert on converter
     */
    public function testConverterConverts()
    {
        $manager = $this->createManager();
        $mockEvent = $this->createImportEventMock();

        $this->defaultConverter
            ->expects($this->once())
            ->method('convert')
            ->with($this->equalTo($mockEvent));

        $this->assertNull($manager->convert($mockEvent));
    }

    /**
     * Manager calls persist once
     */
    public function testPersisterPersists()
    {
        $manager = $this->createManager();
        $mockEvent = $this->createImportEventMock();

        $this->defaultPersister
            ->expects($this->once())
            ->method('persist')
            ->with($this->equalTo($mockEvent));

        $this->assertNull($manager->persist($mockEvent));
    }

    /**
     * Manager doesn't call persist when dry option is true
     */
    public function testPersisterDoesntPersistWhenDryRunOption()
    {
        $manager = $this->createManager();
        $manager->setDryRunOption(true);
        $mockEvent = $this->createImportEventMock();

        $this->defaultPersister
            ->expects($this->never())
            ->method('persist')
            ->with($this->equalTo($mockEvent));

        $this->assertNull($manager->persist($mockEvent));
    }
}
