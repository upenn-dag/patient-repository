<?php

namespace Accard\Bundle\ResourceBundle\Tests\Import;

/**
 * Test \ Import \ Default Initializer
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Tests\ImportTestCase;
use Accard\Bundle\ResourceBundle\Import\Initializer;

class InitializerTest extends ImportTestCase
{
	public function createInitializer()
	{
		return new Initializer();
	}

	public function testInitialize()
	{
        $mockEvent = $this->createImportEventMock();
        $mockImporter = $this->createImporterInterfaceMock();
        $initializer = $this->createInitializer();

        $mockEvent
        	->expects($this->once())
        	->method('getImport');
        $mockEvent
        	->expects($this->once())
        	->method('getHistory');
        $mockEvent
        	->expects($this->once())
        	->method('getImporter');

        $mockImporter
        	->expects($this->once())
        	->method('getDefaultCriteria');

        $this->assertNull($initializer->initialize($mockEvent));
	}
}