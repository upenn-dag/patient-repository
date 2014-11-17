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

use Accard\Bundle\SettingsBundle\Schema\ContainerAwareSchema;
use Accard\Bundle\SettingsBundle\Schema\SettingsBuilderInterface;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Patient settings schema.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PatientSettingsSchema extends ContainerAwareSchema
{
    /**
     * {@inheritdoc}
     */
    public function buildSettings(SettingsBuilderInterface $builder)
    {
        $defaults = array_merge(array(
            'enabled' => true,
            'import_enabled' => true,
            'collect_phases' => true,
        ), $this->defaults);

        $allowedValues = array(
            'enabled' => array(true, false, '1', '0'),
            'import_enabled' => array(true, false, '1', '0'),
            'collect_phases' => array(true, false, '1', '0'),
        );

        if ($this->getPDSDefault()) {
            $defaults['pds_enabled'] = $this->getPDSDefault();
            $allowedValues['pds_enabled'] = array(true, false, '1', '0');
        }

        $builder->setDefaults($defaults)->setAllowedValues($allowedValues);
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('enabled', 'checkbox', array(
                'label' => 'accard.form.settings.patient.enabled',
                'required' => false,
                'disabled' => true,
            ))
            ->add('import_enabled', 'checkbox', array(
                'label' => 'accard.form.settings.patient.import_enabled',
                'required' => false,
            ))
            ->add('collect_phases', 'checkbox', array(
                'label' => 'accard.form.settings.patient.collect_phases',
                'required' => false,
            ))
        ;

        if ($this->getPDSDefault()) {
            $builder->add('pds_enabled', 'checkbox', array(
                'label' => 'accard.form.settings.patient.pds_enabled',
                'required' => false,
            ));
        }
    }

    /**
     * Check if PDS is enabled.
     *
     * @return boolean
     */
    private function getPDSDefault()
    {
        return $this->container && $this->container->hasParameter('accard.pds.present');
    }
}
