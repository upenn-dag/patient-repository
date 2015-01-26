<?php
/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CanvasBundle\Entity;

use DateTime;
use JsonSerializable;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Accard canvas model.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class Canvas implements JsonSerializable
{
    protected $id;

    protected $grid;

    protected $route;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param mixed $route
     */
    public function setRoute($route)
    {
        $this->route = $route;
    }

    /**
     * @return mixed
     */
    public function getGrid()
    {
        return $this->grid;
    }

    /**
     * @param mixed $grid
     */
    public function setGrid(array $grid)
    {
        $this->grid = $grid;
    }

    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'route' => $this->route,
            'grid' => $this->grid,
        );
    }

}