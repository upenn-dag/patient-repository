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
 * Basic patient scenario.
 * 
 * Scenario for creating a patient with one diagnosis.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class BasicPatientScenario extends FlowScenario
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
            ->add('create_patient')
            ->add('create_diagnosis')
            ->add('create_pre_existing_conditions')
            ->add('finalize_patient')
            ->setSaveCallback(array($this, 'saveBasicPatient'))
        ;
    }

    public function saveBasicPatient(FlowContextInterface $context)
    {
        $flow = $context->getFlow();

        $patientStep = $flow->getStep('create_patient');
        $patientForm = $patientStep->createPatientForm();
        $patientData = $context->getStepData($patientStep);
        $diagnosisStep = $flow->getStep('create_diagnosis');
        $diagnosisForm = $diagnosisStep->createDiagnosisForm();
        $diagnosisData = $context->getStepData($diagnosisStep);

        $preExistingConditionsStep = $flow->getStep('create_pre_existing_conditions');
        $diagnosisCollectionsData = $context->getStepData($preExistingConditionsStep);

        $diagnosisForm->submit($diagnosisData);
        $patientForm->submit($patientData);

        $patient = $patientForm->getData();
        $diagnosis = $diagnosisForm->getData();

        $patient->addDiagnosis($diagnosis);

        if(array_key_exists('diagnoses', $diagnosisCollectionsData)) {
            foreach($diagnosisCollectionsData['diagnoses'] as $preExistingConditionData) {

                $preExistingConditionsForm = $diagnosisStep->createDiagnosisForm();
                $preExistingConditionsForm->submit($preExistingConditionData);
                $preExistingCondition = $preExistingConditionsForm->getData();
                $patient->addDiagnosis($preExistingCondition);
            }
        }

        $this->objectManager->persist($patient);
        $this->objectManager->flush();
    }
}
