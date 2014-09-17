<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\SettingsBundle\Form\Factory;

use Symfony\Component\Form\FormInterface;

/**
 * Settings form factory interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface SettingsFormFactoryInterface
{
    /**
     * Create a form for given schema.
     *
     * @param string $namespace
     * @return FormInterface
     */
    public function create($namespace);
}
