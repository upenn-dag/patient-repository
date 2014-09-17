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

use Doctrine\Common\Collections\Collection;
use Accard\Bundle\SettingsBundle\Transformer\ParameterTransformerInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Settings builder interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface SettingsBuilderInterface extends OptionsResolverInterface
{
    /**
     * Return all transformers.
     *
     * @return Collection|ParameterTransformerInterface[]
     */
    public function getTransformers();

    /**
     * Set transformer for a given parameter.
     *
     * @param string $parameterName
     * @param ParameterTransformerInterface $transformer
     * @return SettingsBuilderInterface
     */
    public function setTransformer($parameterName, ParameterTransformerInterface $transformer);
}
