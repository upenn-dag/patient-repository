<?php
namespace Accard\Component\Widget\Grid;

/**
 * Column Builder
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Component\Widget\Grid\Column;
use Accard\Component\Widget\Grid\Row;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Accard\Component\Widget\WidgetFactory;

class ColumnBuilder
{
    /**
     * column
     */
    public $column;

    /**
     * row
     */
    public $row;

    /**
     * options
     */
    public $options;

    /**
     * Widget factory
     */
    public $widgetFactory;


    /**
     * Constructor
     */
    public function __construct(WidgetFactory $widgetFactory)
    {
        $this->factory = $widgetFactory;
    }

    /**
     * Create a column
     */
    public function create(Row $row, $id, $widget = null)
    {
        $this->column = new Column($row, $id);

        if($widget) {
            $this->addWidget($widget);
        }

        return $this;
    }

    /**
     * Set row
     */
    public function setRow(Row $row)
    {
        $this->column->row = $row;

        return $this;
    }

    /**
     * Set Widget
     * 
     * @todo make this accept multiple widgets
     * @param array|widget
     */
    public function addWidget($widget)
    {
        if (empty($widget)) {
            return $this;
        }

        $builder = $this->factory->createBuilder('widget');

        unset($widget['vars']['block_prefixes']);
        unset($widget['vars']['cache_key']);
        unset($widget['vars']['full_name']);
        unset($widget['vars']['id']);
        unset($widget['vars']['unique_block_prefix']);
        unset($widget['vars']['name']);


        $builder->add($widget['name'], $widget['type'], $widget['vars']);
        $widget = $builder->getWidget();
        $this->column->setWidget($widget->createView());

        return $this;
    }

    /**
     * Add config to row
     */
    public function resolveConfig($config)
    {
        $resolver = new OptionsResolver;
        $this->configureOptions($resolver);

        return $resolver->resolve($config);
    }

    /**
     * Configure options
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('widget' => array()));

        $resolver->setRequired('id');

        $resolver->setAllowedTypes(array(
            'id' => array('string', 'integer'),
            'widget' => 'array'
        ));
    }

    /**
     * Get column
     */
    public function getColumn()
    {
        return $this->column;
    }


}