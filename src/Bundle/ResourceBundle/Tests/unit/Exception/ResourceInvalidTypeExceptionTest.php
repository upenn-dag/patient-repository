<?php
namespace AccardTest\Bundle\ResourceBundle\Exception;

/**
 * Resource Invalid Type Exception
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Exception\ResourceInvalidTypeException;

class ResourceInvalidTypeExceptionTest extends \Codeception\TestCase\Test
{
    public function testResourceInvalidTypeExceptionFormatsCorrectly()
    {
        $exception = new ResourceInvalidTypeException(3);

        $message = 'Resource type must be one of ["0" for subject, "1" for target], 3 given.';

        $this->assertSame($message, $exception->getMessage());
    }

}