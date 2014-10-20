<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\Settings;

use Accard\Bundle\SettingsBundle\Schema\SchemaInterface;
use Accard\Bundle\SettingsBundle\Schema\SettingsBuilderInterface;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Sample settings schema.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class SampleSettingsSchema implements SchemaInterface
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
        $builder
            ->setDefaults(array_merge(array(
                'enabled' => true,
                'show_collections' => true,
                'show_derivations' => false,
            ), $this->defaults))
            ->setAllowedValues(array(
                'enabled' => array(true, false, '1', '0'),
                'show_collections' => array(true, false, '1', '0'),
                'show_derivations' => array(true, false, '1', '0'),
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('enabled', 'checkbox', array(
                'label' => 'accard.form.settings.sample.enabled',
                'required' => false,
            ))
            ->add('show_collections', 'checkbox', array(
                'label' => 'accard.form.settings.sample.show_collections',
                'required' => false,
            ))
            ->add('show_derivations', 'checkbox', array(
                'label' => 'accard.form.settings.sample.show_derivations',
                'required' => false,
            ))
        ;
    }
}
