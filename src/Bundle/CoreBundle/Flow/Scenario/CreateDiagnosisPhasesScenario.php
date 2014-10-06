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
 * Create phases for diagnosis scenario.
 * 
 * Scenario for creating a series of diagnosis phases for a given patient
 * and diagnosis.
 *
 * @author Vasu Renganathan <vasur@mail.med.upenn.edu>
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class CreateDiagnosisPhasesScenario extends FlowScenario
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
            ->add('create_diagnosis_phases')
            ->setSaveCallback(array($this, 'saveBasicPhase'))
        ;
    }

    public function saveBasicPhase(FlowContextInterface $context)
    {
        $flow = $context->getFlow();
        $phaseStep = $flow->getStep('create_diagnosis_phases');
        $phasesForm = $phaseStep->createDiagnosisPhasesForm();
        $phaseData = $context->getStepData($phaseStep);

        $patient = $phaseData->patient;
        $diagnosis = $phaseData->diagnosis;

        foreach($data->phases as $phase){

            $diagnosis->addPhase($phase);
        }

        $phasesForm->submit($phaseData);
        $phase = $phasesForm->getData();

        $this->objectManager->persist($phase);
        $this->objectManager->persist($diagnosis);
        $this->objectManager->flush();


    }
}
