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

use DAG\Bundle\SettingsBundle\Schema\SettingsBuilderInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;

/**
 * Behavior settings schema.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class BehaviorSettingsSchema extends AbstractSettingsSchema
{
    /**
     * {@inheritdoc}
     */
    public function buildSettings(SettingsBuilderInterface $builder)
    {
        $integerNormalizer = function (Options $options, $value) {
            if (null !== $value && is_numeric($value)) {
                return intval($value);
            }

            return 0;
        };

        $builder
            ->setDefaults(array_merge(array(
                'enabled' => true,
            ), $this->defaults))
            ->setAllowedValues(array(
                'enabled' => array(true, false, '1', '0'),
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
        ;
    }
}
