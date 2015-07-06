<?php
namespace AccardTest\Bundle\ResourceBundle\EventListener;

/**
 * Kernel Controler Subscriber Test
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\EventListener\KernelControllerSubscriber;
use Mockery;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class KernelControllerSubscriberTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        //$this->securityContext = new Security;
        $this->securityContext = Mockery::mock('Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface');
        $this->exprLanguage = Mockery::mock('Accard\Bundle\ResourceBundle\ExpressionLanguage\ExpressionLanguage');

        $this->kernelControllerSubscriber = new KernelControllerSubscriber($this->securityContext, $this->exprLanguage);
    }

    public function testKernelControllerSubscriberAdheresToEventSubscriberInterface()
    {
        $this->assertInstanceOf(
            'Symfony\Component\EventDispatcher\EventSubscriberInterface',
            $this->kernelControllerSubscriber);
    }

    public function testKernelControllerSubscriberGetSubscribedEventsReturnsCorrectListeners()
    {
        $listeners = [
            'kernel.controller' => array('onKernelController', 0)
        ];

        $this->assertSame($listeners, KernelControllerSubscriber::getSubscribedEvents());
    }

    public function testKernelControllerSubscriberOnKernelControllerReturnsVoidIfControllerArray()
    {
        $event = Mockery::mock('Symfony\Component\HttpKernel\Event\FilterControllerEvent')
            ->shouldReceive('getController')->andReturn(['TEST_ARRAY'])
            ->getMock();

        $this->assertEmpty($this->kernelControllerSubscriber->onKernelController($event));
    }

    public function testKernelControllerSubscriberOnKernelControllerCorrectlyRespondsToResourceControllerResponse()
    {
        $resourceController = Mockery::mock('Accard\Bundle\ResourceBundle\Controller\ResourceController')
            ->shouldReceive('getController')
            ->shouldReceive('setRequest')->with('REQUEST')
        ;

        $event = Mockery::mock('Symfony\Component\HttpKernel\Event\FilterControllerEvent')
            ->shouldReceive('getController')
            ->andReturn([$resourceController])
            ->shouldReceive('getRequest')->andReturn('REQUEST')
            ->getMock()
        ;

        $this->assertEmpty($this->kernelControllerSubscriber->onKernelController($event));
    }

    public function testKernelControllerSubscriberOnKernelControllerCorrectlyOnInitializableController()
    {
        $initializableController = Mockery::mock('Accard\Bundle\ResourceBundle\Controller\InitializableController')
            ->shouldReceive('initialize')
            ->with('REQUEST', $this->securityContext)
        ;

        $event = Mockery::mock('Symfony\Component\HttpKernel\Event\FilterControllerEvent')
            ->shouldReceive('getController')
            ->andReturn([$initializableController])
            ->shouldReceive('getRequest')->once()->andReturn('REQUEST')
            ->getMock()
        ;

        $this->assertEmpty($this->kernelControllerSubscriber->onKernelController($event));
    }

    public function testKernelControllerSubscriberRejectsNonArrayControllerReponse()
    {
        $event = Mockery::mock('Symfony\Component\HttpKernel\Event\FilterControllerEvent')
            ->shouldReceive('getController')
            ->andReturn('NOT_AN_ARRAY')
            ->getMock()
        ;

        $this->assertEmpty($this->kernelControllerSubscriber->onKernelController($event));
    }
}