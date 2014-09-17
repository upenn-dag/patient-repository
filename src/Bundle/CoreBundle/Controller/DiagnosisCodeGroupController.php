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

use Accard\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Pagerfanta\Pagerfanta;

/**
 * Diagnosis code group controller.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class DiagnosisCodeGroupController extends ResourceController
{
    /**
     * Add code to group action.
     * 
     * @param Request $request
     */
    public function addCodeAction(Request $request)
    {
        $groupId = $request->get('group');
        $codeId = $request->get('code');
        $group = $this->getGroup($groupId);
        $code = $this->getCode($codeId);

        $badResponse = new JsonResponse(array(
            'result' => false,
            'message' => 'Unable to save result.',
        ));

        if (!$group || !$code) {
            return $badResponse;
        }

        $manager = $this->get('accard.manager.diagnosis_code');
        $group->addCode($code);
        $manager->persist($group);
        $manager->flush();

        return new JsonResponse(array(
            'result' => true,
            'message' => 'Saved code to group.',
            'group' => $groupId,
            'code' => $codeId,
        ));
    }

    /**
     * Remove code from group action.
     * 
     * @param Request $request
     */
    public function removeCodeAction(Request $request)
    {
        $groupId = $request->get('group');
        $codeId = $request->get('code');
        $group = $this->getGroup($groupId);
        $code = $this->getCode($codeId);

        $badResponse = new JsonResponse(array(
            'result' => false,
            'message' => 'Unable to remove result.',
        ));

        if (!$group || !$code) {
            return $badResponse;
        }

        $manager = $this->get('accard.manager.diagnosis_code');
        $group->removeCode($code);
        $manager->persist($group);
        $manager->flush();

        return new JsonResponse(array(
            'result' => true,
            'message' => 'Removed code from group.',
            'group' => $groupId,
            'code' => $codeId,
        ));
    }

    /**
     * Find a code.
     * 
     * @param integer $codeId
     * @return Code
     */
    private function getCode($codeId)
    {
        return $this->get('accard.repository.diagnosis_code')->find($codeId);
    }

    /**
     * Find a code group.
     * 
     * @param integer $groupId
     * @return CodeGroup
     */
    private function getGroup($groupId)
    {
        return $this->get('accard.repository.diagnosis_code_group')->find($groupId);
    }
}
