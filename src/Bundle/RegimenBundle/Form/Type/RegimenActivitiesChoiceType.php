<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\RegimenBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Accard\Component\Regimen\Model\RegimenInterface;

/**
 * Regimen activities choice form type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class RegimenActivitiesChoiceType extends AbstractType
{
    /**
     * Regimen.
     *
     * @var RegimenInterface
     */
    private $regimen;

    /**
     * Constructor.
     *
     * @param RegimenInterface $regimen
     */
    public function __construct(RegimenInterface $regimen)
    {
        $this->regimen = $regimen;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $regimen = $this->regimen;
        $queryBuilder = function (EntityRepository $er) use ($regimen) {
            $qb = $er->getQueryBuilder();

            if ($regimen->getDiagnosis()) {
                $where = $qb->expr()->eq('activity.diagnosis', ':diagnosis');
                $qb->setParameter('diagnosis', $regimen->getDiagnosis());
            } else {
                $where = $qb->expr()->eq('activity.patient', ':patient');
                $qb->setParameter('patient', $regimen->getPatient());
            }

            $qb->where(
                $qb->expr()->orX(
                    $qb->expr()->isNull('activity.regimen'),
                    $qb->expr()->andX(
                        $qb->expr()->eq('activity.regimen', ':regimen'),
                        $where
                    )
                )
            );

            $qb->setParameter('regimen', $regimen);

            return $qb;
        };

        $builder
            ->add('activities', 'accard_activity_choice', array(
                'multiple' => true,
                'expanded' => true,
                'query_builder' => $queryBuilder,
                'by_reference' => false,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class' => 'Accard\Bundle\RegimenBundle\Model\RegimenActivitiesChoice',
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'accard_regimen_activities_choice';
    }
}
