<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\Flow\Step;

use Accard\Bundle\FlowBundle\Flow\Context\FlowContextInterface;
use Accard\Bundle\FlowBundle\Flow\Step\ControllerStep;
use Accard\Bundle\FlowBundle\Exception\PreconditionFailedException;
use Accard\Component\Patient\Model\PatientInterface;
use Accard\Component\Diagnosis\Model\DiagnosisInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Finalize patient step
 *
 * @author Dylan Pierce <dylan@booksmart.it>
 */
class FinalizePatientStep extends ControllerStep
{
    /**
     * {@inheritdoc}
     */
    public function display(FlowContextInterface $context)
    {

        $flow = $context->getFlow();

        $patientStep = $flow->getStep('create_patient');
        $diagnosisStep = $flow->getStep('create_diagnosis');
        $preExistingConditionsStep = $flow->getStep('create_pre_existing_conditions');

        $patientForm = $patientStep->createPatientForm();
        $diagnosisForm = $diagnosisStep->createDiagnosisForm();
        $preExistingConditionsForm = $preExistingConditionsStep->createDiagnosisCollectionForm();

        $patientForm->submit($context->getStepData($patientStep), false);
        $diagnosisForm->submit($context->getStepData($diagnosisStep), false);
        $preExistingConditionsForm->submit($context->getStepData($preExistingConditionsStep), false);

        return $this->renderStep($context, $patientForm, $patientForm->getData(), $diagnosisForm->getData(), $preExistingConditionsForm->getData());
    }

    /**
     * {@inheritdoc}
     */
    public function complete(FlowContextInterface $context)
    {

        return parent::complete($context);
    }

    /**
     * Render step.
     *
     */
    private function renderStep(FlowContextInterface $context, $patientForm, $patient, $diagnosis, $preExistingConditions)
    {

        return $this->render('AccardWebBundle:Frontend\Flow:finalize_patient.html.twig', array(
            'context' => $context,
            'patient' => $patient,
            'diagnosis' => $diagnosis,
            'create_pre_existing_conditions' => $preExistingConditions,
            'form'  => $patientForm->createView()
        ));
    }
}
