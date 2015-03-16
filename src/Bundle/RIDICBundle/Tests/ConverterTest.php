<?php
namespace Accard\Bundle\RIDICBundle\Tests;

use Accard\Bundle\RIDICBundle\Import\Converter;

class ConverterTest extends \PHPUnit_Framework_TestCase
{
	 private $converter;

	 public function setUp() 
	 {
		$this->converter = $this->getMockBuilder('Accard\Bundle\RIDICBundle\Import\Converter')
							->disableOriginalConstructor()
							->getMock();
	 }

	 public function tearDown() 
	 {
	   $this->converter = null;
	 }
	
	public function testConverterCallsConverts()
	{
    	$this->converter->expects($this->once())
    					->method('convert');

	 	$importEventMock = $this->getMockBuilder('Accard\Bundle\ResourceBundle\Event\ImportEvent')
							->disableOriginalConstructor()
							->getMock();

    	$this->converter->convert($importEventMock);
	}
}