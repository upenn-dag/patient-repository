<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\Controller;

use DAG\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Pagerfanta\Pagerfanta;

/**
 * Drug group controller.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class DrugGroupController extends ResourceController
{
    /**
     * Code group action.
     *
     * @param Request $request
     */
    public function drugGroupAction(Request $request)
    {
        $view = $this->view()
            ->setTemplate($this->config->getTemplate('groupIndex.html'))
            ->setData(array(
                'drug_groups' => $this->getDrugGroups(),
                'drugs' => $this->getDrugs(),
            ))
        ;

        return $this->handleView($view);
    }

    /**
     * Add drug to group action.
     *
     * @param Request $request
     */
    public function addDrugAction(Request $request)
    {
        $groupId = $request->get('group');
        $drugId = $request->get('drug');
        $group = $this->getGroup($groupId);
        $drug = $this->getDrug($drugId);

        $badResponse = new JsonResponse(array(
            'result' => false,
            'message' => 'Unable to save result.',
        ));

        if (!$group || !$drug) {
            return $badResponse;
        }

        $manager = $this->get('accard.manager.drug');
        $group->addDrug($drug);
        $manager->persist($group);
        $manager->flush();

        return new JsonResponse(array(
            'result' => true,
            'message' => 'Saved drug to group.',
            'group' => $groupId,
            'drug' => $drugId,
        ));
    }

    /**
     * Remove drug from group action.
     *
     * @param Request $request
     */
    public function removeDrugAction(Request $request)
    {
        $groupId = $request->get('group');
        $drugId = $request->get('drug');
        $group = $this->getGroup($groupId);
        $drug = $this->getDrug($drugId);

        $badResponse = new JsonResponse(array(
            'result' => false,
            'message' => 'Unable to remove result.',
        ));

        if (!$group || !$drug) {
            return $badResponse;
        }

        $manager = $this->get('accard.manager.drug');
        $group->removeDrug($drug);
        $manager->persist($group);
        $manager->flush();

        return new JsonResponse(array(
            'result' => true,
            'message' => 'Removed drug from group.',
            'group' => $groupId,
            'drug' => $drugId,
        ));
    }

    /**
     * Find a drug.
     *
     * @param integer $drugId
     * @return Drug
     */
    private function getDrug($drugId)
    {
        return $this->get('accard.repository.drug')->find($drugId);
    }

    /**
     * Find a drug group.
     *
     * @param integer $groupId
     * @return DrugGroup
     */
    private function getGroup($groupId)
    {
        return $this->get('accard.repository.drug_group')->find($groupId);
    }

    /**
     * Get all drug groups.
     *
     * @return array
     */
    private function getDrugGroups()
    {
        return $this->get('accard.repository.drug_group')->findAll();
    }

    /**
     * Get all drugs.
     *
     * @return array
     */
    private function getDrugs()
    {
        return $this->get('accard.repository.drug')->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function getForm($resource = null)
    {
        if ($this->config->isApiRequest()) {
            return $this
                ->container
                ->get('form.factory')
                ->createNamed('', $this->config->getFormType(), $resource)
            ;
        }

        return $this->createForm($this->config->getFormType(), $resource, array('select_drugs' => true));
    }
}
