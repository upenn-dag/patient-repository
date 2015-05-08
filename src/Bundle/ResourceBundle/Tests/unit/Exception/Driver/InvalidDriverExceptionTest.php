<?php
namespace AccardTest\Bundle\ResourceBundle\Exception\Driver;

/**
 * Invalid Driver Exception Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Exception\Driver\InvalidDriverException;

class InvalidDriverExceptionTest extends \Codeception\TestCase\Test
{
    public function testInvalidDriverExceptionFormatsStringCorrectly()
    {
        $exception = new InvalidDriverException('DRIVER', 'CLASS_NAME');

        $this->assertSame('Driver "DRIVER" is not supported by CLASS_NAME.', $exception->getMessage());
    }

}