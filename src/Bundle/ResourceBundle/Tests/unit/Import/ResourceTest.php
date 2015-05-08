<?php
namespace AccardTest\Bundle\ResourceBundle\Import;

/**
 * Resource Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Import\Resource;
use Mockery;

class ResourceTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
    	$this->om = Mockery::mock('Doctrine\Common\Persistence\ObjectManager');
    	$this->repository = Mockery::mock('Doctrine\Common\Persistence\ObjectRepository');
    	$this->formType = Mockery::mock('Symfony\Component\Form\FormTypeInterface');
        
        $this->resource = new Resource('RESOURCE_NAME', $this->om, $this->repository, 0, $this->formType);
    }

    public function testResourceAdheresToResourceInterface()
    {
    	$this->assertInstanceOf(
    		'Accard\Bundle\ResourceBundle\Import\ResourceInterface',
    		$this->resource
    	);
    }

    public function testResourceNameIsRetrieveable()
    {
    	$this->assertEquals('RESOURCE_NAME', $this->resource->getName());
    }

    public function testResourceManagerIsRetreveable()
    {
    	$this->assertSame($this->om, $this->resource->getManager());
    }

    public function testResourceRepositoryIsRetrieveable()
    {
    	$this->assertSame($this->repository, $this->resource->getRepository());
    }

    public function testResourceFormIsRetreiveable()
    {
    	$this->assertSame($this->formType, $this->resource->getForm());
    }

    public function testResourceIsSubjectIsFalseWhenTypeIsNotZero()
    {
    	$resource = new Resource('RESOURCE_NAME', $this->om, $this->repository, 1, $this->formType);

    	$this->assertEquals(false, $resource->isSubject());
    }

    public function testResourceIsSubjectIsTrueWhenTypeIsZero()
    {
        $this->assertEquals(true, $this->resource->isSubject());
    }

    public function testResourceIsTargetIsFalseWhenTypeIsNotOne()
    {
    	$this->assertEquals(false, $this->resource->isTarget());
    }

    public function testResourceIsTargetIsTrueWhenTypeIsOne()
    {
		$resource = new Resource('RESOURCE_NAME', $this->om, $this->repository, 1, $this->formType);

    	$this->assertEquals(true, $resource->isTarget());
    }

    public function testResourceThrowsExceptionIfTypeNotPresentInGetValuesArray()
    {
    	$this->setExpectedException('Accard\Bundle\ResourceBundle\Exception\ResourceInvalidTypeException');

        $resource = new Resource('RESOURCE_NAME', $this->om, $this->repository, 'NOT_VALID_RESOURCE_TYPE', $this->formType);
    }
}