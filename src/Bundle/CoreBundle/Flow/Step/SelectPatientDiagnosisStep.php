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
use Accard\Bundle\PatientBundle\Doctrine\ORM\PatientRepository;
use Symfony\Component\Form\FormInterface;
use Accard\Bundle\CoreBundle\Form\EventListener\PatientDiagnosesListener;
use Accard\Component\Patient\Exception\PatientNotFoundException;

/**
 * Select patient and diagnosis step.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class SelectPatientDiagnosisStep extends ControllerStep
{
    /**
     * {@inheritdoc}
     */
    public function display(FlowContextInterface $context)
    {
        $request = $context->getRequest();
        $form = $this->createSelectionForm();

        if ($context->hasStepData()) {
            $form->submit($context->getStepData(), false);
        }

        return $this->renderStep($context, $form);
    }

    /**
     * {@inheritdoc}
     */
    public function complete(FlowContextInterface $context)
    {
        $form = $this->createSelectionForm();
        $form->handleRequest($context->getRequest());

        if ($form->isValid()) {
            $data = $context->getRequest()->request->all();
            $context->setStepData($this, $data['form']);

            return parent::complete($context);
        }

        return $this->renderStep($context, $form);
    }

    /**
     * {@inheritdoc}
     */
    public function skip(FlowContextInterface $context)
    {
        $patientFound = $diagnosisFound = false;
        $stepData = array();
        $initialParams = $context->getInitialParameters();

        // If the diagnosis id was included, you have the diagnosis AND patient.
        if (isset($initialParams['diagnosis']) && is_numeric($initialParams['diagnosis'])) {
            try {
                $diagnosis = $this->get('accard.provider.diagnosis')->getDiagnosis($initialParams['diagnosis']);
                $stepData['diagnosis'] = $diagnosis->getId();
                $stepData['patient'] = $diagnosis->getPatient()->getId();
                $patientFound = $diagnosisFound = true;
            } catch (DiagnosisNotFoundException $e) {}
        }

        // If there was no diagnosis but patient was set, we can set the patient.
        if (!$diagnosisFound && isset($initialParams['patient']) && is_numeric($initialParams['patient'])) {
            try {
                $patient = $this->get('accard.provider.patient')->getPatient($initialParams['patient']);
                $stepData['patient'] = $patient->getId();
                $patientFound = true;
            } catch (PatientNotFoundException $e) {}
        }

        if (!empty($stepData) && !$context->hasStepData($this)) {
            $context->setStepData($this, $stepData);
        }

        return $patientFound && $diagnosisFound;
    }

    /**
     * Create patient and diagnosis selection form.
     *
     * @param array $data
     * @return FormInterface
     */
    public function createSelectionForm(array $data = null)
    {
        $builder = $this->createFormBuilder($data, array('csrf_protection' => false));
        $diagnosisRepository = $this->get('accard.repository.diagnosis');

        $builder->add('patient', 'accard_patient_choice');
        $builder->add('diagnosis', 'accard_diagnosis_choice', array('required' => false));
        //$builder->addEventSubscriber(new PatientDiagnosesListener($diagnosisRepository));

        return $builder->getForm();
    }

    /**
     * Render step.
     *
     */
    private function renderStep(FlowContextInterface $context, FormInterface $form)
    {
        return $this->render('AccardWebBundle:Frontend\Flow:select_patient_diagnosis.html.twig', array(
            'context' => $context,
            'form' => $form->createView(),
        ));
    }
}
