<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Core\Model;

use Accard\Component\Activity\Model\Collection as BaseCollection;
use Doctrine\Common\Collections\Collection as DoctrineCollection;
use Doctrine\Common\Collections\ArrayCollection;
use DateTime;

/**
 * Accard collection model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Collection extends BaseCollection implements CollectionInterface
{
    // Traits
    use ActivityTrait;

    /**
     * Samples.
     *
     * @var Collection|SampleInterface[]
     */
    protected $samples;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->createdAt = new DateTime;
        $this->samples = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getSamples()
    {
        return $this->samples;
    }

    /**
     * {@inheritdoc}
     */
    public function hasSample(SampleInterface $sample)
    {
        return $this->samples->contains($sample);
    }

    /**
     * {@inheritdoc}
     */
    public function addSample(SampleInterface $sample)
    {
        if (!$this->hasSample($sample)) {
            $sample->setCollection($this);
            $this->samples->add($sample);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeSample(SampleInterface $sample)
    {
        if ($this->hasSample($sample)) {
            $this->samples->removeElement($sample);
            $sample->setCollection(null);
        }

        return $this;
    }
}
