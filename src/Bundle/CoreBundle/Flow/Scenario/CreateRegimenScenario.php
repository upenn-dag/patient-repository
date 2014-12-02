<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\Flow\Scenario;

use Doctrine\Common\Persistence\ObjectManager;
use Accard\Bundle\FlowBundle\Flow\Scenario\FlowScenario;
use Accard\Bundle\FlowBundle\Flow\Builder\FlowBuilderInterface;
use Accard\Bundle\FlowBundle\Flow\Context\FlowContextInterface;

/**
 * Create regiemn scenario.
 *
 * Scenario for creating a patient regimen with it's inner activities.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class CreateRegimenScenario extends FlowScenario
{
    /**
     * Entity manager.
     *
     * @var ObjectManager
     */
    private $objectManager;


    /**
     * Constructor.
     *
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * {@inheritdoc}
     */
    public function build(FlowBuilderInterface $builder)
    {
        $builder
            ->add('select_patient_diagnosis')
            ->add('select_regimen')
            ->add('create_regimen')
            ->add('create_regimen_activities')
            ->add('dump')
            ->setSaveCallback(array($this, 'saveCreateRegimen'))
        ;
    }

    public function saveCreateRegimen(FlowContextInterface $context)
    {
        die(var_dump($context));
    }
}
