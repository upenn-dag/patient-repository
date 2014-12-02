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
use Accard\Component\Prototype\Exception\PrototypeNotFoundException;
use Symfony\Component\Form\FormInterface;

/**
 * Select regimen step.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class SelectRegimenStep extends ControllerStep
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

            // Add prototype to initial parameters.
            $initialParams = $context->getInitialParameters();
            $initialParams = array_merge($initialParams, array('regimen' => $data['form']['regimen']));
            $context->setInitialParameters($initialParams);

            return parent::complete($context);
        }

        return $this->renderStep($context, $form);
    }

    /**
     * {@inheritdoc}
     */
    public function skip(FlowContextInterface $context)
    {
        // This step will be skipped if a regimen prototype was specified, and
        // that prototype can be found.
        $initialParams = $context->getInitialParameters();
        if (isset($initialParams['regimen'])) {
            try {
                $regimenProvider = $this->get('accard.provider.regimen_prototype');
                $regimenPrototype = $regimenProvider->getPrototypeByName($initialParams['regimen']);
                $context->setStepData($this, array('regimen' => $regimenPrototype->getId()));

                return true;
            } catch (PrototypeNotFoundException $e) {}
        }

        return false;
    }

    /**
     * Create regimen selection form.
     *
     * @param array $data
     * @return FormInterface
     */
    public function createSelectionForm(array $data = null)
    {
        $builder = $this->createFormBuilder($data, array('csrf_protection' => false));
        $builder->add('regimen', 'accard_regimen_prototype_choice');

        return $builder->getForm();
    }

    /**
     * Render step.
     *
     */
    private function renderStep(FlowContextInterface $context, FormInterface $form)
    {
        return $this->render('AccardWebBundle:Frontend\Flow:select_regimen.html.twig', array(
            'context' => $context,
            'form' => $form->createView(),
        ));
    }
}
