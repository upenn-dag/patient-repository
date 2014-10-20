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
use Accard\Bundle\PhaseBundle\Doctrine\ORM\PhaseRepository;
use Symfony\Component\Form\FormInterface;
use Accard\Component\Phase\Model\PhaseInterface;
use Accard\Bundle\CoreBundle\Flow\Data\CreateDiagnosisPhasesData;
use Accard\Bundle\CoreBundle\Form\Type\CreateDiagnosisPhasesFormType;

/**
 * Create diagnosis phases step.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class CreateDiagnosisPhasesStep extends ControllerStep
{
    /**
     * Patient data class.
     * 
     * @var string
     */
    private $patientClass;

    /**
     * Diagnosis data class.
     * 
     * @var string
     */
    private $diagnosisClass;

    /**
     * Constructor.
     *
     * @param string $patientClass
     * @param string $diagnosisClass
     */
    public function __construct($patientClass, $diagnosisClass)
    {
        $this->patientClass = $patientClass;
        $this->diagnosisClass = $diagnosisClass;
    }

    /**
     * {@inheritdoc}
     */
    public function display(FlowContextInterface $context)
    {
        $model = new CreateDiagnosisPhasesData();
        $form = $this->createDiagnosisPhasesForm($model);

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
        
       return parent::complete($context);
    }

    /**
     * Create form.
     *
     * @param CreateDiagnosisPhasesData|null $model
     * @return FormInterface
     */
     public function createDiagnosisPhasesForm(CreateDiagnosisPhasesData $model = null)
    {
        if (!$model) {
            $model = new CreateDiagnosisPhasesData();
        }

        return $this->createForm(new CreateDiagnosisPhasesFormType(), new $model, array(
            'csrf_protection' => false,
            'patient_class' => $this->patientClass,
            'diagnosis_class' => $this->diagnosisClass,
        ));
    }

    /**
     * Render step.
     *
     */
    private function renderStep(FlowContextInterface $context, FormInterface $form)
    {
        return $this->render('AccardWebBundle:Frontend\Flow:create_diagnosis_phases.html.twig', array(
            'context' => $context,
            'form' => $form->createView(),
        ));
    }
}
