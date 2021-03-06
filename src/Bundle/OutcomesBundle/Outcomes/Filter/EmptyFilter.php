<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\OutcomesBundle\Outcomes\Filter;

use DateTime;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Accard\Bundle\CoreBundle\State\ObjectFieldStateInterface;
use Doctrine\Common\Collections\Criteria;

/**
 * Empty filter.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class EmptyFilter extends AbstractFilter
{
    /**
     * {@inheritdoc}
     */
    public function filter(Criteria $criteria, ObjectFieldStateInterface $field, array $options)
    {
        $criteria->andWhere(
            $criteria->expr()->andX(
                $criteria->expr()->neq($field->name, ""),
                $criteria->expr()->isNull($field->name)
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "empty";
    }

    /**
     * {@inheritdoc}
     */
    public function respondsTo()
    {
        return array("integer", "number", "string", "date", "datetime");
    }
}
