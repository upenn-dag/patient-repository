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
use Symfony\Component\Validator\Constraints\Locale;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

/**
 * General settings schema.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class GeneralSettingsSchema implements SchemaInterface
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
                'title' => 'Accard Framework',
                'logotype' => 'Accard Framework',
                'locale' => 'en',
            ), $this->defaults))
            ->setAllowedTypes(array(
                'title' => array('string'),
                'logotype' => array('string'),
                'locale' => array('string'),
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('title', 'text', array(
                'label' => 'accard.form.settings.general.title',
                'constraints' => array(
                    new NotBlank()
                )
            ))
            ->add('logotype', 'text', array(
                'label' => 'accard.form.settings.general.logotype',
                'constraints' => array(
                    new NotBlank(),
                    new Length(array('min' => 2, 'max' => 120)),
                )
            ))
            ->add('locale', 'locale', array(
                'label' => 'accard.form.settings.general.locale',
                'constraints' => array(
                    new NotBlank(),
                    new Locale(),
                )
            ))
        ;
    }
}
