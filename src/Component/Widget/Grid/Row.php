<?php
namespace Accard\Component\Widget\Grid;

/**
 * Basic grid class
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Doctrine\Common\Collections\ArrayCollection;
use Accard\Component\Widget\Grid\Column;

class Row extends ArrayCollection
{
    /**
     * Row identifier.
     * 
     * @var string|integer
     */
    private $id;


    public function __construct($id, array $elements = array())
    {
        $this->id = $id;
        $this->elements = $elements;
    }

    /**
     * Get row identifier.
     * 
     * @return string|integer
     */
    public function getId()
    {
        return $this->id;
    }


    /* ArrayCollection overload */

    /**
     * {@inheritdoc}
     */
    public function set($key, $value)
    {
        $this->assertColumn($value);

        return parent::set($key, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function add($value)
    {
        $this->assertColumn($value);

        return parent::set($value->getId(), $value);
    }

    /**
     * Ensure value is a Column object.
     * 
     * @throws InvalidArgumentException If value is not a Column object
     */
    private function assertColumn($value)
    {
        if (!$value instanceof Column) {
            throw new \InvalidArgumentException(sprintf('Rows only accept columns, got %s.', get_class($value)));
        }
    }
}