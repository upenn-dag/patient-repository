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
use Accard\Component\Diagnosis\Model\DiagnosisInterface;
use Accard\Bundle\DiagnosisBundle\Doctrine\ORM\DiagnosisRepository;
use Symfony\Component\Form\FormInterface;

/**
 * Create pre existing conditions step.
 *
 * @author Dylan Pierce
 */
class CreatePreExistingConditionsStep extends ControllerStep
{
    /**
     * Diagnosis repository.
     *
     * @var DiagnosisRepository
     */
    private $diagnosisRepository;

    /**
     * Diagnosis model class.
     *
     * @var string
     */
    private $diagnosisModelClass;

    /**
     * Patient model class.
     *
     * @var string
     */
    private $patientModelClass;

    /**
     * Diagnosis form type
     *
     * @var DiagnosisFormType
     */
    private $diagnosisFormType;

    /**
     * Constructor.
     *
     * @param DiagnosisRepository $diagnosisRepository
     * @param string $diagnosisModelClass
     */
    public function __construct(DiagnosisRepository $diagnosisRepository, 
                                $diagnosisModelClass, 
                                $patientModelClass,
                                $diagnosisFormType)
    {
        $this->diagnosisRepository = $diagnosisRepository;
        $this->diagnosisModelClass = $diagnosisModelClass;
        $this->patientModelClass = $patientModelClass;
        $this->diagnosisFormType = $diagnosisFormType;
    }

    /**
     * {@inheritdoc}
     */
    public function display(FlowContextInterface $context)
    {
        $diagnosis = new $this->diagnosisModelClass();
        $form = $this->createDiagnosisCollectionForm($diagnosis);

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
        $diagnosis = new $this->diagnosisModelClass();
        $form = $this->createDiagnosisCollectionForm($diagnosis);
        $form->handleRequest($context->getRequest());

        if ($form->isValid()) {
            $data = $context->getRequest()->request->all();
            $context->setStepData($data['accard_patient_diagnoses']);

            return parent::complete($context);
        }

        return $this->renderStep($context, $form);
    }

    /**
     * Create diagnosis collection form.
     *
     * @param DiagnosisInterface|null $diagnosisModel
     * @return FormInterface
     */
    public function createDiagnosisCollectionForm(DiagnosisInterface $diagnosisModel = null)
    {
        if (!$diagnosisModel) {
            $diagnosisModel = new $this->diagnosisModelClass();
        }

        return $this->createForm('accard_patient_diagnoses');
    }

    /**
     * Render step.
     *
     */
    private function renderStep(FlowContextInterface $context, FormInterface $form)
    {
        return $this->render('AccardWebBundle:Frontend\Flow:create_pre_existing_conditions.html.twig', array(
            'context' => $context,
            'form' => $form->createView(),
        ));
    }
}
