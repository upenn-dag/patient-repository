<?php
namespace AccardTest\Bundle\ResourceBundle\Import;

/**
 * Manager Registry Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Import\ManagerRegistry;
use Accard\Bundle\ResourceBundle\Test\Stub\Stub;
use Mockery;

class ManagerRegistryTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->manager = Mockery::mock('Accard\Bundle\RegistryBundle\Import\ManagerInterface');
        $this->container = Mockery::mock('Symfony\Component\DependencyInjection\ContainerInterface');

        $this->registry = new ManagerRegistry();

        $this->registry->setContainer($this->container);
    }

    public function testManagerRegistryManagersIsArrayOnCreation()
    {
        $this->assertInternalType('array', $this->registry->getManagers());
    }

    public function testManagerRegistryManagerIsRegisterableAndRetrievable()
    {
        $name = 'TEST_MANAGER';

        $this->container->shouldReceive('get')->once()->andReturn($this->manager);

        $this->assertEmpty($this->registry->registerManager($name, $this->manager));

        $this->assertSame($this->registry->getManager($name), $this->manager);
    }

    public function testManagerRegistryManagerCanUnregisterManagers()
    {
        $name = 'TEST_MANAGER';

        $this->assertEmpty($this->registry->registerManager($name, $this->manager));

        $this->registry->unregisterManager($name);

        $this->assertEmpty($this->registry->getManagers());
    }

    public function testManagerRegistryCannotReRegisterTheSameManager()
    {
        $name = 'TEST_MANAGER';

        $this->setExpectedException('Accard\Bundle\ResourceBundle\Exception\DuplicateManagerException');

        $this->registry->registerManager($name, $this->manager);
        $this->registry->registerManager($name, $this->manager);
    }

    public function testManagerRegistryHasManagerReturnsFalseWhenManagerNotPresent()
    {
        $this->assertEquals(false, $this->registry->hasManager('NAME'));
    }

    public function testManagerRegistryManagerReturnsTrueWhenManagerNameGiven()
    {
        $name = 'TEST_MANAGER';

        $this->registry->registerManager($name, $this->manager);

        $this->assertEquals(true, $this->registry->hasManager($name));
    }

    public function testManagerRegistryManagerCallsGetNameOnNamesThatAreObjects()
    {
        $stub = new Stub();

        $this->assertEquals(false, $this->registry->hasManager($stub));
    }

    public function testManagerUnregisterManagerThrowsExceptionIfManagerNotFound()
    {
        $this->setExpectedException('Accard\Bundle\ResourceBundle\Exception\ManagerAccessException');

        $this->registry->unregisterManager('TEST_MANAGER');
    }

    public function testManagerGetManagerThrowsExceptionIfManagerNotPresent()
    {
        $this->setExpectedException('Accard\Bundle\ResourceBundle\Exception\ManagerAccessException');

        $this->registry->getManager('TEST_MANAGER');
    }
}