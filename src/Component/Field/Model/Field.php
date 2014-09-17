<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Field\Model;

use BadMethodCallException;
use Accard\Component\Option\Model\OptionInterface;

/**
 * Accard field model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Field implements FieldInterface
{
    /**
     * Field id.
     *
     * @var integer
     */
    protected $id;

    /**
     * Internal name.
     *
     * @var string
     */
    protected $name;

    /**
     * Field type.
     *
     * @param string
     */
    protected $type = FieldTypes::TEXT;

    /**
     * Field presentation.
     *
     * @var string
     */
    protected $presentation;

    /**
     * Field choice option.
     *
     * Only used when type is set to choice field.
     *
     * @var OptionInterface
     */
    protected $option;

    /**
     * Field configuration.
     *
     * @var array
     */
    protected $configuration = array();


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
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPresentation()
    {
        return $this->presentation;
    }

    /**
     * {@inheritdoc}
     */
    public function setPresentation($presentation)
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOption()
    {
        return $this->option;
    }

    /**
     * {@inheritdoc}
     */
    public function setOption(OptionInterface $option)
    {
        $this->option = $option;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function setConfiguration(array $configuration)
    {
        $this->configuration = $configuration;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->name;
    }
}
