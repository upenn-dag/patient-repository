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
use Accard\Component\Regimen\Model\RegimenInterface;
use Accard\Bundle\RegimenBundle\Doctrine\ORM\RegimenRepository;
use Symfony\Component\Form\FormInterface;
use Accard\Component\Prototype\Exception\PrototypeNotFoundException;
use Accard\Bundle\RegimenBundle\Model\RegimenActivities;

/**
 * Create regimen activities step.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class CreateRegimenActivitiesStep extends ControllerStep
{
    /**
     * {@inheritdoc}
     */
    public function display(FlowContextInterface $context)
    {
        $regimen = $this->initializeModel($context);
        die(var_dump($regimen));
        $form = $this->createRegimenForm($regimen);

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
        $regimen = $this->initializeModel($context);
        $form = $this->createRegimenForm($regimen);
        $form->handleRequest($context->getRequest());

        if ($form->isValid()) {
            $data = $context->getRequest()->request->all();
            $context->setStepData($this, $data['accard_regimen']);

            return parent::complete($context);
        }

        return $this->renderStep($context, $form);
    }

    /**
     * Create regimen form.
     *
     * @param RegimenInterface|null $regimenModel
     * @return FormInterface
     */
    public function createRegimenForm(RegimenInterface $regimenModel = null)
    {
        if (!$regimenModel) {
            $regimenModel = new $this->regimenModelClass();
        }

        return $this->createForm('accard_regimen', $regimenModel, array(
            'csrf_protection' => false,
            'use_patient' => false,
            'use_diagnosis' => false,
            'use_activities' => false,
            'validation_groups' => array('minimal'),
        ));
    }

    /**
     * Render step.
     *
     */
    private function renderStep(FlowContextInterface $context, FormInterface $form)
    {
        return $this->render('AccardWebBundle:Frontend\Flow:create_regimen.html.twig', array(
            'context' => $context,
            'form' => $form->createView(),
        ));
    }

    /**
     * Initialize a new model.
     *
     * Fills that model with detected prototype data.
     *
     * @throws PreconditionFailedException If no protoype is detected.
     * @param FlowContextInterface $context
     * @return RegimenInterface
     */
    private function initializeModel(FlowContextInterface $context)
    {
        $previousStep = $context->getPreviousStep();
        $initialParams = $context->getInitialParameters();
        $regimenProvider = $this->get('accard.provider.regimen_prototype');
        if ($previousStep instanceof SelectRegimenStep) {
            $previousData = $context->getStepData($previousStep);
            $regimenPrototype = $regimenProvider->getPrototype($previousData['regimen']);
        } elseif (isset($initialParams['regimen'])) {
            $regimenPrototype = $regimenProvider->getPrototypeByName($initialParams['regimen']);
        }

        // If no regimen can be located, we must die.
        if (!isset($regimenPrototype)) {
            throw new PreconditionFailedException('Regimen prototype could not be determined. Therefore, we may not create a regimen.');
        }

        $regimen = new RegimenActivities($regimenPrototype);

        return $regimen;
    }
}
