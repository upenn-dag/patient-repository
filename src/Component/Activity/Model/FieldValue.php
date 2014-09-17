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

use Accard\Component\Field\Model\FieldValue as BaseFieldValue;

/**
 * Accard prototype field value model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FieldValue extends BaseFieldValue implements FieldValueInterface
{
    /**
     * Activity prototype.
     *
     * @var PrototypeInterface|null
     */
    protected $prototype;


    /**
     * {@inheritdoc}
     */
    public function getPrototype()
    {
        return $this->prototype;
    }

    /**
     * {@inheritdoc}
     */
    public function setPrototype(PrototypeInterface $prototype = null)
    {
        $this->prototype = $prototype;

        return $this;
    }
}
