<?php
namespace AccardTest\Bundle\ActivityBundle\Form\EventListener;

/**
 * Default Activity Field Listener Test
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ActivityBundle\Form\EventListener\DefaultActivityFieldListener;
use Mockery;

class DefaultActivityFieldListenerTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->factory = Mockery::mock('Symfony\Component\Form\FormFactoryInterface');
        $this->builder = Mockery::mock('Accard\Component\Activity\Builder\ActivityBuilderInterface');

        $this->listener = new DefaultActivityFieldListener($this->factory, $this->builder);
    }

    // tests
    public function testDefaultActivityFieldListenerImplementsEventSubscriberInterface()
    {
        $this->assertInstanceOf('Symfony\Component\EventDispatcher\EventSubscriberInterface', $this->listener);
    }

    public function testDefaultActivityFieldListenerSubscribesToEvents()
    {
        $this->assertInternalType('array', $this->listener->getSubscribedEvents());
    }

    public function testDefaultActivityFieldListenerCreatesDrugFieldsFromEventDoesNothingIfNoDataPresent()
    {
        $event = Mockery::mock('Symfony\Component\Form\FormEvent')
            ->shouldReceive('getData')->andReturn(null)
            ->getMock()
        ;

        $this->assertEmpty($this->listener->addDrugField($event));
    }

    public function testDefaultActivityFieldListenerCreatesDrugFieldsFromEventDoesNothingIfDataDoesNotContainPrototype()
    {
        $activity = Mockery::mock()
            ->shouldReceive('getPrototype')->andReturn(null)
            ->getMock()
        ;

        $event = Mockery::mock('Symfony\Component\Form\FormEvent')
            ->shouldReceive('getData')->andReturn($activity)
            ->getMock()
        ;

        $this->assertEmpty($this->listener->addDrugField($event));
    }

    public function testDefaultActivityFieldListenerCreatesDrugFieldsFromEventAndAddsEmptyDrugFieldToPrototypeForm()
    {
        $form = Mockery::mock()
            ->shouldReceive('add')->with('drug', 'accard_drug_choice', ['required' => false])
        ;

        $prototype = Mockery::mock()
            ->shouldReceive('getAllowDrug')->andReturn(false)
            ->getMock()
        ;

        $activity = Mockery::mock()
            ->shouldReceive('getPrototype')->andReturn($prototype)
             ->getMock()
        ;

        $event = Mockery::mock('Symfony\Component\Form\FormEvent')
            ->shouldReceive('getData')->andReturn($activity)
            ->shouldReceive('getForm')->andReturn($form)
            ->getMock()
        ;

        $this->assertEmpty($this->listener->addDrugField($event));
    }

    public function testDefaultActivityFieldListenerCreatesDrugFieldsFromEventAddsPopulatedDrugGroupToPrototypeForm()
    {
        $drugGroup = Mockery::mock()
            ->shouldReceive('getPresentation')->andReturn('PRESENTATION')
            ->getMock()
        ;

        $form = Mockery::mock()
            ->shouldReceive('add')->with('drug', 'accard_drug_choice', [
                'label' => 'PRESENTATION',
                'group' => $drugGroup,
                'required' => false
            ])
        ;

        $prototype = Mockery::mock()
            ->shouldReceive('getAllowDrug')->andReturn(true)
            ->shouldReceive('getDrugGroup')->andReturn($drugGroup)
            ->getMock()
        ;

        $activity = Mockery::mock()
            ->shouldReceive('getPrototype')->andReturn($prototype)
             ->getMock()
        ;

        $event = Mockery::mock('Symfony\Component\Form\FormEvent')
            ->shouldReceive('getData')->andReturn($activity)
            ->shouldReceive('getForm')->andReturn($form)
            ->getMock()
        ;

        $this->assertEmpty($this->listener->addDrugField($event));
    }

    public function testHidePrototypeDoesNothingIfEventDataIsEmpty()
    {
        $event = Mockery::mock('Symfony\Component\Form\FormEvent')
            ->shouldReceive('getData')->andReturn(null)
            ->getMock()
        ;

        $this->assertEmpty($this->listener->hidePrototype($event));
    }

    public function testDefaultActivityFieldListenerHidePrototypeFromEventDoesNothingIfDataDoesNotContainPrototype()
    {
        $activity = Mockery::mock()
            ->shouldReceive('getPrototype')->andReturn(null)
            ->getMock()
        ;

        $event = Mockery::mock('Symfony\Component\Form\FormEvent')
            ->shouldReceive('getData')->andReturn($activity)
            ->getMock()
        ;

        $this->assertEmpty($this->listener->hidePrototype($event));
    }

    public function testDefaultActivityFieldListenerHidePrototypeRemovesPrototypeIfItHasOne()
    {
        $form = Mockery::mock()
            ->shouldReceive('has')->with('prototype')->andReturn(true)
            ->shouldReceive('remove')->with('prototype')
            ->getMock()
        ;

        $activity = Mockery::mock()
            ->shouldReceive('getPrototype')->andReturn('NOT NULL')
            ->getMock()
        ;

        $event = Mockery::mock('Symfony\Component\Form\FormEvent')
            ->shouldReceive('getData')->andReturn($activity)
            ->shouldReceive('getForm')->andReturn($form)
            ->getMock()
        ;

        $this->assertEmpty($this->listener->hidePrototype($event));
    }

    public function testDefaultActivityFieldListenerCanCreateMultipleFields()
    {
        $field1 = Mockery::mock()
            ->shouldReceive('getName')->andReturn('FIELD1_NAME')
            ->shouldReceive('getPresentation')->andReturn('FIELD1_PRESENTATION')
            ->getMock()
        ;

        $field2 = Mockery::mock()
            ->shouldReceive('getName')->andReturn('FIELD2_NAME')
            ->shouldReceive('getPresentation')->andReturn('FIELD2_PRESENTATION')
            ->getMock()
        ;

        $fields = [$field1, $field2];

        $prototype = Mockery::mock()
            ->shouldReceive('getFields')->once()->andReturn($fields)
            ->getMock()
        ;

        $activity = Mockery::mock()
            ->shouldReceive('getPrototype')->andReturn($prototype)
            ->shouldReceive('hasFieldByName')->andReturn(false)
            ->getMock()
        ;

        $this->builder
            ->shouldReceive('addField')->twice()
            ->shouldReceive('set');

        $event = Mockery::mock('Symfony\Component\Form\FormEvent')
            ->shouldReceive('getData')->andReturn($activity)
            ->getMock()
        ;

        $this->assertEmpty($this->listener->createFields($event));
    }
}
