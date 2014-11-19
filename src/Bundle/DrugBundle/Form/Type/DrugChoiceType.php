<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\DrugBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\Options;

/**
 * Drug choice form type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DrugChoiceType extends AbstractType
{
    /**
     * Data class.
     *
     * @var string
     */
    protected $entityClass;


    /**
     * Constructor.
     *
     * @param string $entityClass
     */
    public function __construct($entityClass)
    {
        $this->entityClass = $entityClass;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $qbNormalizer = function(Options $options, $qb)
        {
            // If the group is set, don't use a query builder
            if ($options['group']) {
                $group = $options['group'];
                return function(EntityRepository $er) use ($group) {
                    return $er->getQueryBuilder()
                        ->innerJoin('drug.groups', 'g', 'WITH', 'g.id = :groupId')
                        ->setParameter('groupId', $group->getId());

                    return $qb;
                };
            }

            if ($options['generic_only']) {
                return function(EntityRepository $er) {
                    return $er->getQueryBuilder()->filterByStatement('drug.generic IS NULL');
                };
            }

            if ($options['brand_only']) {
                return function(EntityRepository $er) {
                    return $er->getQueryBuilder()->filterByStatement('drug.generic IS NOT NULL');
                };
            }
        };

        $resolver
            ->setDefaults(array(
                'class' => $this->entityClass,
                'property' => 'presentation',
                'generic_only' => false,
                'brand_only' => false,
                'group' => null,
            ))
            ->setAllowedTypes(array(
                'group' => array('null', 'Accard\Component\Drug\Model\DrugGroupInterface')
            ))
            ->setNormalizers(array(
                'query_builder' => $qbNormalizer,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'entity';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'accard_drug_choice';
    }
}
