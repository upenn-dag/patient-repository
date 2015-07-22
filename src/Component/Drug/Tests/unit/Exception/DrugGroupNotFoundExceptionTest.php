<?php
namespace AccardTest\Component\Drug\Exception;

/**
 * Drug Group Not Found Exception Test
 *
 * @author Dylan Pierce <piecedy@upenn.edu>
 */
use Accard\Component\Drug\Exception\DrugGroupNotFoundException;
use DAG\Component\Field\Model\Field;
use Mockery;

class DrugGroupNotFoundExceptionTest extends \Codeception\TestCase\Test
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
    public function testDrugGroupExceptionInterfaceIsFollowed()
    {
        $this->exception = Mockery::mock('Accard\Component\Drug\Exception\DrugGroupNotFoundException');

        $this->assertInstanceOf(
            'Accard\Component\Drug\Exception\DrugException',
            $this->exception
        );
    }

    /**
     * Constructor tests
     */
    public function testDrugGroupNotFoundExceptionMessageIsCorrectWithNumericField()
    {
        $this->field = 1;
        $this->exception = new DrugGroupNotFoundException($this->field);

        $this->assertSame('Drug group with id "1" cound not be found.', $this->exception->getMessage());
    }

    public function testDrugGroupNotFoundExceptionMessageIsCorrectWithNullField()
    {
        $this->field = Mockery::mock('DAG\Component\Field\Model\FieldInterface')
            ->shouldReceive('__toString()')->zeroOrMoreTimes()->andReturn('NAME');
        $this->field = 'NAME';

        $this->exception = new DrugGroupNotFoundException($this->field, null);
        $this->assertSame("Drug group count not be found in this NAME.", $this->exception->getMessage());
    }

    public function testDrugNotFoundExceptionMessageIsCorrectWhenFieldIsNotNumericAndFieldIsPresent()
    {
        $this->field = Mockery::mock('DAG\Component\Field\Model\FieldInterface')
            ->shouldReceive('__toString()')->zeroOrMoreTimes()->andReturn('NAME');
        $this->field = 'FIELDNAME';

        $this->value = 'VALUENAME';
        $this->exception = new DrugGroupNotFoundException($this->field, $this->value);
        $this->assertSame('Drug group could not be found using FIELDNAME with value VALUENAME', $this->exception->getMessage());
    }

}