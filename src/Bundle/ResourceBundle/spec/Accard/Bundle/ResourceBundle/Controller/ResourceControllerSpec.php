<?php

namespace spec\Accard\Bundle\ResourceBundle\Controller;

use PhpSpec\ObjectBehavior;
use Accard\Bundle\ResourceBundle\Controller\Configuration;

/**
 * Resource controller spec.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ResourceControllerSpec extends ObjectBehavior
{
    function let(Configuration $configuration)
    {
        $this->beConstructedWith($configuration);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Accard\Bundle\ResourceBundle\Controller\ResourceController');
    }

    function it_is_a_controller()
    {
        $this->shouldHaveType('Symfony\Bundle\FrameworkBundle\Controller\Controller');
    }
}
