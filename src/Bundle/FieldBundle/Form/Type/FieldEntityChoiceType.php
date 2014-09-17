<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\FieldBundle\Form\Type;

/**
 * Field choice form type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FieldEntityChoiceType extends FieldChoiceType
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'entity';
    }
}
