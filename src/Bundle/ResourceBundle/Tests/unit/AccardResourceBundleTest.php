<?php
namespace AccardTest\Bundle\ResourceBundle;

/**
 * Accard Resource Bundle Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Mockery;
use Accard\Bundle\ResourceBundle\AccardResourceBundle;
use Accard\Bundle\ResourceBundle\DependencyInjection\Compiler\ObjectToIdentifierServicePass;


class AccardResourceBundleTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->bundle = new AccardResourceBundle();
    }

    // tests
    public function testBuildRegistersExpectedNumberOfBundles()
    {
        $container = Mockery::mock('Symfony\Component\DependencyInjection\ContainerBuilder')
            ->shouldReceive('addCompilerPass')->times(6)
            ->getMock()
        ;

        $this->bundle->build($container);
    }   

}