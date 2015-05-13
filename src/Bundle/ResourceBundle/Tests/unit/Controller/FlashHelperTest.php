<?php
namespace AccardTest\Bundle\ResourceBundle\Controller;

/**
 * Flash Helper Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Controller\FlashHelper;
use Mockery;

class FlashHelperTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->config = Mockery::mock('Accard\Bundle\ResourceBundle\Controller\Configuration');
        $this->translator = Mockery::mock('Symfony\Component\Translation\TranslatorInterface');
        $this->session = Mockery::mock('Symfony\Component\HttpFoundation\Session\SessionInterface');

        $this->flashHelper = new FlashHelper($this->config, $this->translator, $this->session);
    }

    protected function _after()
    {
    }

    public function testFlashHelperSetFlashShouldFormatAccardEventsCorrectly()
    {
        $flashBag = Mockery::mock('Symfony\Component\HttpFoundation\Session\Flash\FlashBag')
            ->shouldReceive('add')
            ->with('TYPE')
        ;

        $this->session->shouldReceive('getBag')
            ->once()
            ->with('flashes')
            ->andReturn($flashBag);
        ;

        $this->translator->shouldReceive('trans')
            ->with('accard.RESOURCE', ['%resource%' => 'RESOURCE NAME', '%resource_lower%' => 'resource name'], 'flashes')
        ;

        $this->config->shouldReceive('getResourceName')
            ->once()
            ->andReturn('RESOURCE_NAME')
        ;

        $this->flashHelper->setFlash('TYPE', 'accard.RESOURCE', array());
    }

    public function testFlashHelperSetFlashShouldFormatNonAccardEventsCorrectly()
    {
        $flashBag = Mockery::mock('Symfony\Component\HttpFoundation\Session\Flash\FlashBag')
            ->shouldReceive('add')
            ->with('TYPE')
        ;

        $this->session->shouldReceive('getBag')
            ->once()
            ->with('flashes')
            ->andReturn($flashBag);
        ;

        $this->config->shouldReceive('getFlashMessage')
            ->once()
            ->andReturn('FLASH_MESSAGE')
        ;

        $this->config->shouldReceive('getResourceName')
            ->once()
            ->andReturn('RESOURCE_NAME')
        ;

        $this->translator->shouldReceive('trans')
            ->with('FLASH_MESSAGE', ['%resource%' => 'RESOURCE NAME', '%resource_lower%' => 'resource name'], 'flashes')
        ;

        $this->flashHelper->setFlash('TYPE', 'RESOURCE', array());
    }

    public function testFlashHelperSetFlashShouldFormatCorrectlyWhenMessageEqualsTranslatedMessage()
    {
        $flashBag = Mockery::mock('Symfony\Component\HttpFoundation\Session\Flash\FlashBag')
            ->shouldReceive('add')
            ->with('TYPE')
        ;

        $this->session->shouldReceive('getBag')
            ->once()
            ->with('flashes')
            ->andReturn($flashBag);
        ;

        $this->config->shouldReceive('getFlashMessage')
            ->once()
            ->andReturn('RESOURCE_NAME')
        ;

        $this->config->shouldReceive('getResourceName')
            ->once()
            ->andReturn('RESOURCE_NAME')
        ;

        $this->translator->shouldReceive('trans');

        $this->flashHelper->setFlash('TYPE', 'RESOURCE', array());
    }
}