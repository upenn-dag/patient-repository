<?php
namespace AccardTest\Bundle\ResourceBundle\Exception;

/**
 * Importer Access Exception Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Exception\ImporterAccessException;

class ImporterAccessExceptionTest extends \Codeception\TestCase\Test
{
    public function testImporterAccessExceptionTestFormatsMessageCorrectly()
    {
        $exception = new ImporterAccessException('NAME');
        $string = 'No importer with the name "NAME" has been registered.';

        $this->assertSame($string, $exception->getMessage());
    }

}