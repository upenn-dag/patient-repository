<?php
namespace AccardTest\Component\Drug\Exception;

/**
 * Drug Group Not Found Exception Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Component\Drug\Exception\DrugNotFoundException;
use Accard\Component\Field\Model\Field;
use Mockery;

class DrugNotFoundExceptionTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {

    }

    protected function _after()
    {
    }

    /**
     * Interface tests
     */
    public function testDrugExceptionInterfaceIsFollowed()
    {
        $this->exception = Mockery::mock('Accard\Component\Drug\Exception\DrugNotFoundException');

        $this->assertInstanceOf(
            'Accard\Component\Drug\Exception\DrugException',
            $this->exception
        );
    }

    /**
     * Constructor tests
     */
    public function testDrugNotFoundExceptionMessageIsCorrectWithNumericField()
    {
        $this->field = 1;
        $this->exception = new DrugNotFoundException($this->field);
        
        $this->assertSame('Drug with id "1" cound not be found.', $this->exception->getMessage());
    }

    public function testDrugNotFoundExceptionMessageIsCorrectWithNullField()
    {
        $this->field = Mockery::mock('Accard\Component\Field\Model\FieldInterface')
            ->shouldReceive('__toString()')->zeroOrMoreTimes()->andReturn('NAME');
        $this->field = 'NAME';

        $this->exception = new DrugNotFoundException($this->field, null);
        $this->assertSame("Drug count not be found in this NAME.", $this->exception->getMessage());
    }

    public function testDrugNotFoundExceptionMessageIsCorrectWhenFieldIsNotNumericAndFieldIsPresent()
    {
        $this->field = Mockery::mock('Accard\Component\Field\Model\FieldInterface')
            ->shouldReceive('__toString()')->zeroOrMoreTimes()->andReturn('NAME');
        $this->field = 'FIELDNAME';

        $this->value = 'VALUENAME';
        $this->exception = new DrugNotFoundException($this->field, $this->value);
        $this->assertSame('Drug could not be found using FIELDNAME with value VALUENAME', $this->exception->getMessage());
    }

}