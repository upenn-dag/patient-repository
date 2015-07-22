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
use Symfony\Component\Validator\Constraints\Locale;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Theme settings schema.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ThemeSettingsSchema extends AbstractSettingsSchema
{
    /**
     * {@inheritdoc}
     */
    public function buildSettings(SettingsBuilderInterface $builder)
    {
        $builder
            ->setDefaults(array_merge(array(
                'theme' => 'default',
            ), $this->defaults))
            ->setAllowedTypes(array(
                'theme' => array('string'),
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('theme', 'text', array(
                'label' => 'accard.form.settings.theme.theme',
                'constraints' => array(
                    new NotBlank()
                )
            ))
        ;
    }
}
