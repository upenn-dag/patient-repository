<?php
namespace AccardTest\Bundle\ActivityBundle\Form\Type;

/**
 * Activity Prototype Type Test
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ActivityBundle\Form\Type\ActivityPrototypeType;

class ActivityPrototypeTypeTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->type = new ActivityPrototypeType();
    }

    // tests
    public function testActivityPrototypeTypeBuildForm()
    {
        $builder = Mockery::mock('Symfony\Component\Form\FormBuilderInterface');

        $options = array();

        $this->type->buildForm($builder, $options);
    }
}
