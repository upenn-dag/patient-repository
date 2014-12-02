<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Regimen\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Accard\Component\Drug\Model\DrugablePrototypeTrait;
use Accard\Component\Prototype\Model\Prototype as BasePrototype;
use Accard\Component\Activity\Model\PrototypeInterface as ActivityPrototypeInterface;

/**
 * Regimen prototype model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Prototype extends BasePrototype implements PrototypeInterface
{
    use DrugablePrototypeTrait;

    /**
     * Allowed activity prototypes.
     *
     * @var Collection|ActivityPrototypeInterface
     */
    protected $activityPrototypes;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->activityPrototypes = new ArrayCollection();

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    public function getActivityPrototypes()
    {
        return $this->activityPrototypes;
    }

    /**
     * {@inheritdoc}
     */
    public function hasActivityPrototype(ActivityPrototypeInterface $activityPrototype)
    {
        return $this->activityPrototypes->contains($activityPrototype);
    }

    /**
     * {@inheritdoc}
     */
    public function addActivityPrototype(ActivityPrototypeInterface $activityPrototype)
    {
        if (!$this->hasActivityPrototype($activityPrototype)) {
            $this->activityPrototypes->add($activityPrototype);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeActivityPrototype(ActivityPrototypeInterface $activityPrototype)
    {
        if ($this->hasActivityPrototype($activityPrototype)) {
            $this->activityPrototypes->removeElement($activityPrototype);
        }

        return $this;
    }
}
