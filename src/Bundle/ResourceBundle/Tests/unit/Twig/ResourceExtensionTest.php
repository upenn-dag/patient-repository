<?php
namespace AccardTest\Bundle\ResourceBundle\Twig;

/**
 * Resource Extension Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Twig\ResourceExtension;
use Mockery;

class ResourceExtensionTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->router = Mockery::mock('Symfony\Component\Routing\RouterInterface');
        $this->importSignals = ['IMPORT_SIGNAL'];
        $this->pageTemplate = Mockery::mock();
        $this->sortingTemplate = Mockery::mock();

        $this->twig = new ResourceExtension($this->router, $this->importSignals, $this->pageTemplate, $this->sortingTemplate);
    }

    // tests
    public function testResourceExpressionGetFunctionsReturnsArrayOfTwigSimpleFunctions()
    {
        $this->assertContainsOnlyInstancesOf('Twig_SimpleFunction', $this->twig->getFunctions());
    }

    public function testResourceExpressionGetGlobalsReturnsImportSignals()
    {
        $this->assertEquals(['accard_import_signals' => $this->importSignals], $this->twig->getGlobals());
    }

    public function testResourceExpressionImportSignalsAreRetrievable()
    {
        $this->assertSame($this->importSignals, $this->twig->getImportSignals());
    }

    public function testResourceExpressionFetchRequestDoesNothingIfRequestIsNotMasterRequest()
    {
        $request = Mockery::mock('Symfony\Component\HttpFoundation\Request');

        $event = Mockery::mock('Symfony\Component\HttpKernel\Event\GetResponseEvent')
            ->shouldReceive('getRequestType')->andReturn(false)
            ->getMock()
        ;

        $this->assertEmpty($this->twig->fetchRequest($event));
    }

    public function testResourceExpressionFetchRequestManipulatesRoutes()
    {

        $request = Mockery::mock('Symfony\Component\HttpFoundation\Request');
        $attributes = Mockery::mock()
            ->shouldReceive('get')->with('_route_params', array())->andReturn(array())
            ->getMock()
        ;

        $request->attributes = $attributes;


        $event = Mockery::mock('Symfony\Component\HttpKernel\Event\GetResponseEvent')
            ->shouldReceive('getRequestType')->andReturn(true)
            ->shouldReceive('getRequest')->andReturn($request)
            ->getMock()
        ;

        $this->assertEmpty($this->twig->fetchRequest($event));
    }

    public function testResourceExpressionGetNameReturnsCorrectString()
    {
        $this->assertEquals('accard_resource', $this->twig->getName());
    }
}