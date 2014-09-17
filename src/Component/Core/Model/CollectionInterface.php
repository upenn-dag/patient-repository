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

use Doctrine\Common\Collections\Collection as DoctrineCollection;
use Accard\Component\Activity\Model\CollectionInterface as BaseCollectionInterface;

/**
 * Accard collection interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface CollectionInterface extends BaseCollectionInterface, ActivityInterface
{
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
