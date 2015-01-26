<?php
namespace Accard\Component\Widget\Grid;

/**
 * Basic grid class
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Doctrine\Common\Collections\ArrayCollection;
use Accard\Component\Widget\Grid\Row;

class Grid extends ArrayCollection
{
    /* ArrayCollection overload */

    /**
     * {@inheritdoc}
     */
    public function set($key, $value)
    {
        $this->assertRow($value);

        return parent::set($key, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function add($value)
    {
        $this->assertRow($value);

        return parent::set($value->getId(), $value);
    }

    /**
     * Ensure value is a Row object.
     * 
     * @throws InvalidArgumentException If value is not a Row object
     */
    private function assertRow($value)
    {
        if (!$value instanceof Row) {
            throw new \InvalidArgumentException(sprintf('Grids only accept rows, got %s.', get_class($value)));
        }
    }
}