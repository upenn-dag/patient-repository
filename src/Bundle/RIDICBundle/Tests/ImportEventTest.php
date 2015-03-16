<?php
namespace Accard\Bundle\RIDICBundle\Tests;

use Accard\Bundle\ResourceBundle\Event\ImportEvent;

class ImportEventTest extends \PHPUnit_Framework_TestCase
{
	private $import;

	 public function setUp() 
	 {
	 	
	 	$this->import = new ImportEvent();
	 }

	 public function tearDown() 
	 {
	   $this->converter = null;
	 }
}