<?php
namespace Accard\Component\Widget\Grid;

/**
 * Basic column class
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Doctrine\Common\Collections\ArrayCollection;
use Accard\Component\Widget\Widget;

class Column extends ArrayCollection
{
    /**
     * Widget
     */
    public $widget;

    /**
     * Row
     * 
     * @var Row
     */
    public $row;

    /**
     * Column identifier.
     * 
     * @var string|integer
     */
    private $id;


    public function __construct(Row $row, $id, array $elements = array())
    {
        $this->row = $row;
        $this->id = $id;
        $this->elements = $elements;
    }

    /**
     * Get id.
     * 
     * @return string|integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get row.
     * 
     * @return Row
     */
    public function getRow()
    {
        return $this->row;
    }

    /**
     * Has widget?
     */
    public function hasWidget(Widget $widget)
    {
        if(is_null($this->widget)) {
            return false;
        }

        return true;
    }

    /**
     * Get Widget
     */
    public function getWidget()
    {
        return $this->widgets;
    }

    /**
     * Set Widget
     */
    public function setWidget($widget)
    {
        $this->widget = $widget;
    }
}