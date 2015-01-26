<?php
namespace Accard\Component\Widget\Grid;

/**
 * Row Builder
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Symfony\Component\OptionsResolver\OptionsResolver;

class RowBuilder
{
    /**
     * Row
     */
    private $row;


    /**
     * Create a new row.
     * 
     * @param string|integer $id
     * @return self
     */
    public function create($id)
    {
        $this->row = new Row($id);

        return $this;
    }

    /**
     * Add column to row
     */
    public function addColumn(Column $column)
    {
        $this->row->add($column);
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
     * Configure options using the Symfony OptionResolver component.
     * 
     * @param OptionsResolver $resolver
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'id' => null,
            'columns' => array(),
        ));

        $resolver->setAllowedTypes(array(
            'id' => array('string', 'integer'),
        ));

        $resolver->setRequired('id');
    }

    /**
     * Get Row object
     */
    public function getRow()
    {
        return $this->row;
    }
}