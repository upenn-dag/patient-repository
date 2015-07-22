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
use Doctrine\Common\Collections\Collection as DoctrineCollection;
use DAG\Component\Resource\Model\ResourceInterface;

/**
 * Sample source model interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface SourceInterface extends ResourceInterface
{
    /**
     * Get sample source id.
     *
     * @return integer
     */
    public function getId();

    /**
     * Get parent sample.
     *
     * @return SampleInterface
     */
    public function getSample();

    /**
     * Set parent sample.
     *
     * @param SampleInterface|null $sample
     * @return SourceInterface
     */
    public function setSample(SampleInterface $sample = null);

    /**
     * Test if source is a derivation.
     *
     * @return boolean
     */
    public function isDerivation();

    /**
     * Get sample source date.
     *
     * @return DateTime
     */
    public function getSourceDate();

    /**
     * Set sample source date.
     *
     * @param DateTime $sourceDate
     * @return CollectionInterface
     */
    public function setSourceDate(DateTime $sourceDate);

    /**
     * Get amount of parent sample used.
     *
     * @return integer
     */
    public function getAmount();

    /**
     * Set amount of parent sample used.
     *
     * @param integer|null $amount
     * @return SourceInterface
     */
    public function setAmount($amount = null);

    /**
     * Get samples.
     *
     * @return DoctrineCollection|SampleInterface[]
     */
    public function getSamples();

    /**
     * Test for presence of sample.
     *
     * @param SampleInterface $sample
     * @return boolean
     */
    public function hasSample(SampleInterface $sample);

    /**
     * Add sample.
     *
     * @param SampleInterface $sample
     * @return CollectionInterface
     */
    public function addSample(SampleInterface $sample);

    /**
     * Remove sample.
     *
     * @param SampleInterface $sample
     * @return CollectionInterface
     */
    public function removeSample(SampleInterface $sample);
}
