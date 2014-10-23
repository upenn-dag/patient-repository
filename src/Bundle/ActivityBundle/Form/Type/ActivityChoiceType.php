<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ActivityBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Accard\Component\Activity\Repository\ActivityRepositoryInterface;
use Accard\Bundle\ResourceBundle\Form\DataTransformer\ObjectToIdentifierTransformer;
use Accard\Bundle\ResourceBundle\Form\DataTransformer\IdentifierToObjectTransformer;

/**
 * Activity choice form type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ActivityChoiceType extends AbstractType
{
    /**
     * Data class.
     *
     * @var string
     */
    protected $dataClass;

    /**
     * Activity repository.
     *
     * @var ActivityRepositoryInterface
     */
    protected $activityRepository;


    /**
     * Constructor.
     *
     * @param ActivityRepositoryInterface $activityRepository
     */
    public function __construct(ActivityRepositoryInterface $activityRepository)
    {
        $this->dataClass = $activityRepository->getClassName();
        $this->activityRepository = $activityRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'class' => $this->dataClass,
                'property' => 'canonical',
                'label' => 'accard.activity.entity_name',
                'query_builder' => function (EntityRepository $er) {
                    static $qb;
                    return $qb = $er->getQueryBuilder();
                },
                'empty_value' => 'accard.activity.form.select_activity'
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
        return 'accard_activity_choice';
    }
}
