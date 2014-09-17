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
 * Behavior settings schema.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class BehaviorSettingsSchema implements SchemaInterface
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
                'enable_alcohol' => true,
                'enable_smoking' => true,
                'enable_illicit_drugs' => true,
                'enable_occupation' => true,
                'enable_education' => true,
            ), $this->defaults))
            ->setAllowedValues(array(
                'enabled' => array(true, false, '1', '0'),
                'enable_alcohol' => array(true, false, '1', '0'),
                'enable_smoking' => array(true, false, '1', '0'),
                'enable_illicit_drugs' => array(true, false, '1', '0'),
                'enable_occupation' => array(true, false, '1', '0'),
                'enable_education' => array(true, false, '1', '0'),
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
                'label' => 'accard.form.settings.behavior.enabled',
                'required' => false,
            ))
            ->add('enable_alcohol', 'checkbox', array(
                'label' => 'accard.form.settings.behavior.enable_alcohol',
                'required' => false,
            ))
            ->add('enable_smoking', 'checkbox', array(
                'label' => 'accard.form.settings.behavior.enable_smoking',
                'required' => false,
            ))
            ->add('enable_illicit_drugs', 'checkbox', array(
                'label' => 'accard.form.settings.behavior.enable_illicit_drugs',
                'required' => false,
            ))
            ->add('enable_occupation', 'checkbox', array(
                'label' => 'accard.form.settings.behavior.enable_occupation',
                'required' => false,
            ))
            ->add('enable_education', 'checkbox', array(
                'label' => 'accard.form.settings.behavior.enable_education',
                'required' => false,
            ))
        ;
    }
}
