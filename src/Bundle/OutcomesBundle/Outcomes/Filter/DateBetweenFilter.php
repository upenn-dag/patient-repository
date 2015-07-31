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
 * Abstract filter.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DateBetweenFilter extends AbstractFilter
{
    /**
     * {@inheritdoc}
     */
    public function filter(Criteria $criteria, ObjectFieldStateInterface $field, array $options)
    {
        $criteria->andWhere(
            $criteria->expr()->andX(
                $criteria->expr()->gt($field->name, $options["start"]),
                $criteria->expr()->lt($field->name, $options["end"])
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $dateNormalizer = function (Options $options, $value) {
            if (is_string($value)) {
                return new DateTime($value);
            } elseif (is_numeric($value)) {
                return DateTime::createFromFormat("U", $value);
            }

            return $value;
        };

        $resolver
            ->setDefault("end", function (Options $options) {
                return new Datetime();
            })
            ->setRequired(array("start", "end"))
            ->setAllowedTypes("start", array("int", "string", "DateTime"))
            ->setAllowedTypes("end", array("int", "string", "DateTime"))
            ->setNormalizer("start", $dateNormalizer)
            ->setNormalizer("end", $dateNormalizer)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        return array(
            "start" => array(
                "type" => "date",
                "label" => "Start Date",
                "required" => true,
                "default" => null,
            ),
            "end" => array(
                "type" => "date",
                "label" => "End date",
                "required" => false,
                "default" => "now",
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "date_between";
    }

    /**
     * {@inheritdoc}
     */
    public function respondsTo()
    {
        return array("date", "datetime");
    }
}
