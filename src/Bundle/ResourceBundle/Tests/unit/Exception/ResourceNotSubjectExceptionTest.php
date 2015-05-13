<?php
namespace AccardTest\Bundle\ResourceBundle\Exception;

/**
 * Resource Not Subject Exception
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */

use Accard\Bundle\ResourceBundle\Exception\ResourceNotSubjectException;
use Accard\Bundle\ResourceBundle\Test\Stub\ImportStub;

class ResourceNotSubjectExceptionTest extends \Codeception\TestCase\Test
{
    public function testResourceNotSubjectExceptionFormatsMessageCorrectly()
    {
        $stub = new ImportStub();
        $exception = new ResourceNotSubjectException($stub);
        $message = 'Object of class Accard\Bundle\ResourceBundle\Test\Stub\ImportStub must be registered as a subject.';

        $this->assertSame($exception->getMessage(), $message);
    }

}