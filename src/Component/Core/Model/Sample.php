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

use Accard\Component\Sample\Model\Sample as BaseSample;
use DateTime;

/**
 * Accard sample model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Sample extends BaseSample implements SampleInterface
{
    // Traits
    use \Accard\Component\Resource\Model\BlameableTrait;
    use \Accard\Component\Resource\Model\TimestampableTrait;
    use \Accard\Component\Resource\Model\VersionableTrait;

    /**
     * Collection.
     *
     * @var CollectionInterface|null
     */
    protected $collection;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    /**
     * {@inheritdoc}
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * {@inheritdoc}
     */
    public function setCollection(CollectionInterface $collection = null)
    {
        $this->collection = $collection;

        return $this;
    }
}
