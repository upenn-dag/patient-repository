<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\SettingsBundle\Schema;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * Abstract schema.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
abstract class Schema implements SchemaInterface
{
    /**
     * Default data.
     *
     * @var array
     */
    protected $defaults;


    /**
     * Constructor.
     *
     * @param array $defaults
     */
    public function __construct(array $defaults = array())
    {
        $this->defaults = $defaults;
    }

    /**
     * {@inheritdoc}
     */
    public function buildSettings(SettingsBuilderInterface $builder)
    {
        // Do nothing by default.
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder)
    {
        // Do nothing by default.
    }
}
