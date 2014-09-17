<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Activity\Model;

use Doctrine\Common\Collections\Collection as DoctrineCollection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Test activity model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Test extends Activity implements TestInterface
{
    /**
     * Conclusions.
     *
     * @var Collection|ConclusionActivity[]
     */
    protected $conclusions;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->conclusions = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getConclusions()
    {
        return $this->conclusions;
    }

    /**
     * {@inheritdoc}
     */
    public function hasConclusion(ConclusionInterface $conclusion)
    {
        return $this->conclusions->contains($conclusion);
    }

    /**
     * {@inheritdoc}
     */
    public function addConclusion(ConclusionInterface $conclusion)
    {
        if (!$this->hasConclusion($conclusion)) {
            $conclusion->setTest($this);
            $this->conclusions->add($conclusion);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeConclusion(ConclusionInterface $conclusion)
    {
        if ($this->hasConclusion($conclusion)) {
            $this->conclusions->removeElement($conclusion);
            $conclusion->setTest(null);
        }

        return $this;
    }
}
