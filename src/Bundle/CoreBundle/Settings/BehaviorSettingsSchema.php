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
use Symfony\Component\OptionsResolver\Options;
use Accard\Bundle\SettingsBundle\Form\ArrayToStringTransformer;

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
        $integerNormalizer = function(Options $options, $value) {
            if (null !== $value && is_numeric($value)) {
                return intval($value);
            }

            return 0;
        };

        $builder
            ->setDefaults(array_merge(array(
                'enabled' => true,
                'enable_alcohol' => true,
                'enable_smoking' => true,
                'enable_illicit_drug' => true,
                'enable_occupation' => true,
                'enable_education' => true,
                'alcohol_order' => '1',
                'smoking_order' => '2',
                'illicit_drug_order' => '3',
                'occupation_order' => '4',
                'education_order'   => '5',
            ), $this->defaults))
            ->setAllowedValues(array(
                'enabled' => array(true, false, '1', '0'),
                'enable_alcohol' => array(true, false, '1', '0'),
                'enable_smoking' => array(true, false, '1', '0'),
                'enable_illicit_drug' => array(true, false, '1', '0'),
                'enable_occupation' => array(true, false, '1', '0'),
                'enable_education' => array(true, false, '1', '0')
            ))
            ->setAllowedTypes(array(
                'alcohol_order' => 'integer',
                'smoking_order' => 'integer',
                'illicit_drug_order' => 'integer',
                'occupation_order' => 'integer',
                'education_order' => 'integer',
            ))
            ->setNormalizers(array(
                'alcohol_order' => $integerNormalizer,
                'smoking_order' => $integerNormalizer,
                'illicit_drug_order' => $integerNormalizer,
                'occupation_order' => $integerNormalizer,
                'education_order' => $integerNormalizer,
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
            ->add('enable_illicit_drug', 'checkbox', array(
                'label' => 'accard.form.settings.behavior.enable_illicit_drug',
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
            ->add('alcohol_order', 'number', array(
                'label' => 'accard.form.settings.behavior.alcohol_order',
                'label_attr'  => array(
                    'draggable' => 'true'
                )
            ))
            ->add('smoking_order', 'number', array(
                'label' => 'accard.form.settings.behavior.smoking_order',
                'label_attr'  => array(
                    'draggable' => 'true'
                )
            ))
            ->add('illicit_drug_order', 'number', array(
                'label' => 'accard.form.settings.behavior.illicit_drug_order',
                'label_attr'  => array(
                    'draggable' => 'true'
                )
            ))
            ->add('occupation_order', 'number', array(
                'label' => 'accard.form.settings.behavior.occupation_order',
                'label_attr'  => array(
                    'draggable' => 'true'
                )
            ))
            ->add('education_order', 'number', array(
                'label' => 'accard.form.settings.behavior.education_order',
                'label_attr'  => array(
                    'draggable' => 'true'
                )
            ))
        ;
    }
}
