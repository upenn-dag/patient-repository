<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Sample\Model;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Sample source model interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Source implements SourceInterface
{
    /**
     * Sample source id.
     *
     * @var integer
     */
    protected $id;

    /**
     * Parent sample.
     *
     * @var SampleInterface
     */
    protected $sample;

    /**
     * Sample source date.
     *
     * @var DateTime
     */
    protected $sourceDate;

    /**
     * Amount of parent sample used.
     *
     * @var integer
     */
    protected $amount;

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
        $this->samples = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setSample(SampleInterface $sample = null)
    {
        $this->sample = $sample;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSample()
    {
        return $this->sample;
    }

    /**
     * {@inheritdoc}
     */
    public function isDerivative()
    {
        return null !== $this->sample;
    }

    /**
     * {@inheritdoc}
     */
    public function getSourceDate()
    {
        return $this->sourceDate;
    }

    /**
     * {@inheritdoc}
     */
    public function setSourceDate(DateTime $sourceDate)
    {
        $this->sourceDate = $sourceDate;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * {@inheritdoc}
     */
    public function setAmount($amount = null)
    {
        $this->amount = $amount;

        return $this;
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
            $sample->setSource($this);
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
            $sample->setSource(null);
            $this->samples->removeElement($sample);
        }

        return $this;
    }
}
