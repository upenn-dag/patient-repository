<?php
namespace AccardTest\Bundle\ResourceBundle\Exception;

/**
 * Duplicate Importer Exception Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Exception\DuplicateImporterException;

class DuplicateImporterExceptionTest extends \Codeception\TestCase\Test
{
    public function testDuplicateImporterExceptionFormatsCorrectly()
    {
        $name = 'NAME';
        $string = 'An importer with the name "NAME" has already been registered.';

        $exception = new DuplicateImporterException($name);

        $this->assertSame($string, $exception->getMessage());
    }

}