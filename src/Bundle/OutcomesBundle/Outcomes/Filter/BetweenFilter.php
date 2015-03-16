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

/**
 * Abstract filter.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class BetweenFilter extends AbstractFilter
{
    /**
     * {@inheritdoc}
     */
    public function filter(ObjectFieldStateInterface $field, array $options)
    {
        dump($options);
    }

    /**
     * {@inheritdoc}
     */
    protected function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $dateNormalizer = function(Options $options, $value) {
            if ("date" === $options["type"]) {
                if (is_string($value)) {
                    return new DateTime($value);
                } elseif (is_numeric($value)) {
                    return DateTime::createFromFormat("U", $value);
                }
            }

            return $value;
        };

        $resolver
            ->setDefault("end", function(Options $options) {
                if ("date" === $options["type"]) {
                    return new Datetime();
                }
            })
            ->setRequired(array("type", "start", "end"))
            ->setAllowedValues("type", array("date", "integer"))
            ->setAllowedTypes("start", array("int", "string", "DateTime"))
            ->setAllowedTypes("end", array("int", "string", "DateTime"))
            ->setNormalizer("start", $dateNormalizer)
            ->setNormalizer("end", $dateNormalizer)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "between";
    }

    /**
     * {@inheritdoc}
     */
    public function respondsTo()
    {
        return array("date", "datetime", "integer", "number");
    }
}