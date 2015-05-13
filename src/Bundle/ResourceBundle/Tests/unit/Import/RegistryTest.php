<?php
namespace AccardTest\Bundle\ResourceBundle\Import;

/**
 * Importer Registry Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Import\Registry;
use Accard\Bundle\ResourceBundle\Test\Stub\Stub;
use Mockery;

class RegistryTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->importer = Mockery::mock('Accard\Bundle\RegistryBundle\Import\ImporterInterface');
        $this->container = Mockery::mock('Symfony\Component\DependencyInjection\ContainerInterface');

        $this->registry = new Registry();

        $this->registry->setContainer($this->container);
    }

    public function testImporterRegistryImportersIsArrayOnCreation()
    {
        $this->assertInternalType('array', $this->registry->getImporters());
    }

    public function testImporterRegistryImporterIsRegisterableAndRetrievable()
    {
        $name = 'TEST_IMPORTER';

        $this->container->shouldReceive('get')->once()->andReturn($this->importer);

        $this->assertEmpty($this->registry->registerImporter($name, $this->importer));

        $this->assertSame($this->registry->getImporter($name), $this->importer);
    }

    public function testImporterRegistryImporterCanUnregisterImporters()
    {
        $name = 'TEST_IMPORTER';

        $this->assertEmpty($this->registry->registerImporter($name, $this->importer));

        $this->registry->unregisterImporter($name);

        $this->assertEmpty($this->registry->getImporters());
    }

    public function testImporterRegistryCannotReRegisterTheSameImporter()
    {
        $name = 'TEST_IMPORTER';

        $this->setExpectedException('Accard\Bundle\ResourceBundle\Exception\DuplicateImporterException');

        $this->registry->registerImporter($name, $this->importer);
        $this->registry->registerImporter($name, $this->importer);
    }

    public function testImporterRegistryHasImporterReturnsFalseWhenImporterNotPresent()
    {
        $this->assertEquals(false, $this->registry->hasImporter('NAME'));
    }

    public function testImporterRegistryImporterReturnsTrueWhenImporterNameGiven()
    {
        $name = 'TEST_IMPORTER';

        $this->registry->registerImporter($name, $this->importer);

        $this->assertEquals(true, $this->registry->hasImporter($name));
    }

    public function testImporterRegistryImporterCallsGetNameOnNamesThatAreObjects()
    {
        $stub = new Stub();

        $this->assertEquals(false, $this->registry->hasImporter($stub));
    }

    public function testImporterUnregisterImporterThrowsExceptionIfImporterNotFound()
    {
        $this->setExpectedException('Accard\Bundle\ResourceBundle\Exception\ImporterAccessException');

        $this->registry->unregisterImporter('TEST_IMPORTER');
    }

    public function testImporterGetImporterThrowsExceptionIfImporterNotPresent()
    {
        $this->setExpectedException('Accard\Bundle\ResourceBundle\Exception\ImporterAccessException');

        $this->registry->getImporter('TEST_IMPORTER');
    }
}