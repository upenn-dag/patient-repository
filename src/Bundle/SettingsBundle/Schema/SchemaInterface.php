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
 * Setting schema interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface SchemaInterface
{
    /**
     * Build settings.
     *
     * @param SettingsBuilderInterface $builder
     * @return SchemaInterface
     */
    public function buildSettings(SettingsBuilderInterface $builder);

    /**
     * Build form.
     *
     * @param FormBuilderInterface $builder
     * @return SchemaInterface
     */
    public function buildForm(FormBuilderInterface $builder);
}
