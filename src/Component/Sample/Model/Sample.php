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

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Accard\Component\Field\Model\FieldValueInterface as BaseFieldValueInterface;
use Accard\Component\Prototype\Model\PrototypeInterface as BasePrototypeInterface;

/**
 * Accard sample model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Sample implements SampleInterface
{
    /**
     * Sample id.
     *
     * @var integer
     */
    protected $id;

    /**
     * Prototype.
     *
     * @var PrototypeInterface
     */
    protected $prototype;

    /**
     * Source.
     *
     * @var SourceInterface
     */
    protected $source;

    /**
     * Amount.
     *
     * @var integer
     */
    protected $amount = 0;

    /**
     * Derivatives.
     *
     * @param Collection|SourceInterface[]
     */
    protected $derivatives;

    /**
     * Fields.
     *
     * @var Collection|BaseFieldValueInterface[]
     */
    protected $fields;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->derivatives = new ArrayCollection();
        $this->fields = new ArrayCollection();
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
    public function getPrototype()
    {
        return $this->prototype;
    }

    /**
     * {@inheritdoc}
     */
    public function setPrototype(BasePrototypeInterface $prototype = null)
    {
        $this->prototype = $prototype;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * {@inheritdoc}
     */
    public function setSource(SourceInterface $source = null)
    {
        $this->source = $source;

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
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDerivatives()
    {
        return $this->derivatives;
    }

    /**
     * {@inheritdoc}
     */
    public function hasDerivative(SourceInterface $derivative)
    {
        return $this->derivatives->contains($derivative);
    }

    /**
     * {@inheritdoc}
     */
    public function hasDerivatives()
    {
        return 0 < count($this->derivatives);
    }

    /**
     * {@inheritdoc}
     */
    public function addDerivative(SourceInterface $derivative)
    {
        if (!$this->hasDerivative($derivative)) {
            $this->derivatives->add($derivative);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeDerivative(SourceInterface $derivative)
    {
        if ($this->hasDerivative($derivative)) {
            $this->derivatives->removeElement($derivative);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * {@inheritdoc}
     */
    public function setFields(Collection $fields)
    {
        foreach ($fields as $field) {
            $this->addField($field);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addField(BaseFieldValueInterface $field)
    {
        if (!$this->hasField($field)) {
            $field->setSample($this);
            $this->fields->add($field);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeField(BaseFieldValueInterface $field)
    {
        if ($this->hasField($field)) {
            $this->fields->removeElement($field);
            $field->setSample(null);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasField(BaseFieldValueInterface $field)
    {
        return $this->fields->contains($field);
    }

    /**
     * {@inheritdoc}
     */
    public function hasFieldByName($fieldName)
    {
        foreach ($this->fields as $field) {
            if ($field->getName() === $fieldName) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldByName($fieldName)
    {
        foreach ($this->fields as $field) {
            if ($field->getName() === $fieldName) {
                return $field;
            }
        }
    }
}
