<?php
namespace AccardTest\Bundle\ActivityBundle\Form\Type;

/**
 * Activity Choice Type Test
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ActivityBundle\Form\Type\ActivityChoiceType;
use Mockery;

class ActivityChoiceTypeTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->repository = Mockery::mock('Accard\Component\Activity\Repository\ActivityRepositoryInterface')
            ->shouldReceive('getClassName')->andReturn('DATA_CLASS')
            ->getMock()
        ;

        $this->type = new ActivityChoiceType($this->repository);
    }

    // tests
    public function testActivityChoiceTypeSetDefaultOptionsConfiguresResolver()
    {
        $resolver = Mockery::mock('Symfony\Component\OptionsResolver\OptionsResolverInterface')
            ->shouldReceive('setDefaults')
            ->getMock()
        ;

        $this->assertEmpty($this->type->setDefaultOptions($resolver));
    }

    public function testActivityChoiceTypeGetParentReturnsCorrectString()
    {
        $this->assertEquals('entity', $this->type->getParent());
    }

    public function testActivityChoiceTypeGetNameReturnsCorrectString()
    {
        $this->assertEquals('accard_activity_choice', $this->type->getName());
    }
}
