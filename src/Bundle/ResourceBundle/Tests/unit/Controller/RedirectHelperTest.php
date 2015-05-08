<?php
namespace AccardTest\Bundle\ResourceBundle\Controller;

/**
 * Redirect Handler Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Mockery;
use Accard\Bundle\ResourceBundle\Controller\RedirectHandler;
use Accard\Bundle\ResourceBundle\Test\Stub\Stub;

class RedirectHandlerTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->router = Mockery::mock('Symfony\Component\Routing\RouterInterface');
        $this->config = Mockery::mock('Accard\Bundle\ResourceBundle\Controller\Configuration');

        $this->redirectHandler = new RedirectHandler($this->config, $this->router);
    }

    protected function _after()
    {
    }

    public function testRedirectHandlerRedirectsToResourceShowWithConfigParams()
    {
        $resource = new Stub();
        $params = ['PARAMS' => 'VALUE'];

        $this->config
            ->shouldReceive('getRedirectParameters')
            ->once()
            ->with($resource)
            ->andReturn($params)
            ->shouldReceive('getRedirectRoute')
            ->once()
            ->with('show')
            ->andReturn('ROUTE')
        ;

        $this->router
            ->shouldReceive('generate')
            ->once()
            ->with('ROUTE', $params)
            ->andReturn('URL')
        ;

        $response = $this->redirectHandler->redirectTo($resource);

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\RedirectResponse', $response);
    }

    public function testRedirectHandlerRedirectsToRefererWhenPresent()
    {
        $resource = new Stub();
        $params = ['PARAMS' => 'VALUE'];

        $request = Mockery::mock();
        $request->headers = Mockery::mock()
            ->shouldReceive('get')
            ->once()
            ->andReturn('URL')
            ->getMock()
        ;


        $this->config
            ->shouldReceive('getRedirectParameters')
            ->once()
            ->andReturn(['PARAMS' => 'VALUE'])
            ->shouldReceive('getRedirectRoute')
            ->once()
            ->with('show')
            ->andReturn('referer')
            ->shouldReceive('getRequest')
            ->once()
            ->andReturn($request)
        ;

        $this->router
            ->shouldReceive('generate')
            ->never()
        ;

        $response = $this->redirectHandler->redirectTo($resource);

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\RedirectResponse', $response);
    }

    public function testRedirectHandlerRedirectsToIndexWithConfigParameters()
    {
        $this->config
            ->shouldReceive('getRedirectParameters')
            ->once()
            ->andReturn(['PARAMS' => 'VALUE'])
            ->shouldReceive('getRedirectRoute')
            ->once()
            ->with('index')
            ->andReturn('INDEX_URL')
            ->shouldReceive('getRequest')
            ->never()
        ;

        $this->router
            ->shouldReceive('generate')
            ->once()
            ->with('INDEX_URL', ['PARAMS' => 'VALUE'])
            ->andReturn('INDEX_URL')
        ;
        
        $response = $this->redirectHandler->redirectToIndex();

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\RedirectResponse', $response);
    }
}