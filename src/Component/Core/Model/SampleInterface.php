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

use Accard\Component\Sample\Model\SampleInterface as BaseSampleInterface;
use Accard\Component\Resource\Model\BlameableInterface;
use Accard\Component\Resource\Model\VersionableInterface;
use Accard\Component\Resource\Model\TimestampableInterface;

/**
 * Accard sample interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface SampleInterface extends BaseSampleInterface,
                                  TimestampableInterface,
                                  BlameableInterface,
                                  VersionableInterface
{
    /**
     * Get activity.
     *
     * @return CollectionInterface
     */
    public function getCollection();

    /**
     * Set activity.
     *
     * @param CollectionInterface $activity
     * @return SampleInterface
     */
    public function setCollection(CollectionInterface $activity);
}
