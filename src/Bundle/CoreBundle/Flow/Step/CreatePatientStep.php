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

/**
 * Create patient step.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class CreatePatientStep extends ControllerStep
{
    /**
     * Patient repository.
     *
     * @var PatientRepository
     */
    private $patientRepository;

    /**
     * Patient model class.
     *
     * @var string
     */
    private $patientModelClass;

    /**
     * Constructor.
     *
     * @param PatientRepository $patientRepository
     * @param string $patientModelClass
     */
    public function __construct(PatientRepository $patientRepository, $patientModelClass)
    {
        $this->patientRepository = $patientRepository;
        $this->patientModelClass = $patientModelClass;
    }

    /**
     * {@inheritdoc}
     */
    public function display(FlowContextInterface $context)
    {
        $patient = new $this->patientModelClass();
        $form = $this->createPatientForm($patient);

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
        $patient = new $this->patientModelClass();
        $form = $this->createPatientForm($patient);
        $form->handleRequest($context->getRequest());

        if ($form->isValid()) {
            $data = $context->getRequest()->request->all();
            $context->setStepData($this, $data['accard_patient']);

            return parent::complete($context);
        }

        return $this->renderStep($context, $form);
    }

    /**
     * Create patient form.
     *
     * @param PatientInterface|null $patientModel
     * @return FormInterface
     */
    public function createPatientForm(PatientInterface $patientModel = null)
    {
        if (!$patientModel) {
            $patientModel = new $this->patientModelClass();
        }

        return $this->createForm('accard_patient', new $patientModel, array(
            'csrf_protection' => false,
        ));
    }

    /**
     * Render step.
     *
     */
    private function renderStep(FlowContextInterface $context, FormInterface $form)
    {
        return $this->render('AccardWebBundle:Frontend\Flow:create_patient.html.twig', array(
            'context' => $context,
            'form' => $form->createView(),
        ));
    }
}
