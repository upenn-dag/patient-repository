<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ResourceBundle\Import;

use Accard\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Accard\Component\Resource\Model\ImportTargetInterface;
use Accard\Bundle\ResourceBundle\Event\ImportAcceptEvent;
use Accard\Bundle\ResourceBundle\Event\ImportDeclineEvent;
use Accard\Bundle\ResourceBundle\Import\Events;

/**
 * Import controller.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ImportController extends ResourceController
{
    /**
     * Accept record action.
     *
     * @param Request $request
     * @param string $importerName
     * @param integer $id
     * @return Response
     */
    public function acceptAction(Request $request, $subject, $id)
    {
        $record = $this->getRecordResolver()->createRecordForImport($subject, $id);
        $manager = $this->getResourceFactory()->resolveSubject($subject)->getManager();

        if (!$record) {
            return $this->createNotFoundException('Import record not found.');
        }

        $signals = $this->getImportSignals();
        $signal = $request->get('signal', false);

        // Todo: Make this throw a custom exception, and add a catcher somewhere.
        if ($signal && !in_array($signal, array_keys($signals))) {
            throw $this->createNotFoundException('Unknown signal supplied to import accept.');
        }

        $target = $record->getImportTarget();
        $target->setStatus(ImportTargetInterface::ACCEPTED);

        $dispatcher = $this->getEventDispatcher();
        $event = new ImportAcceptEvent($record, $target, $request->get('signal', false));

        $manager->transactional(function($om) use ($dispatcher, $event, $record, $target) {
            $dispatcher->dispatch(Events::ACCEPT, $event);
            $om->persist($record);
            $om->persist($target);
            $om->flush();
        });

        if ($request->isXMLHttpRequest()) {
            return new JsonResponse(array(
                'result' => 'success'
            ));
        }

        return $this->redirectHandler->redirectToReferer();
    }

    /**
     * Decline record action.
     *
     * @param Request $request
     * @param string $subject
     * @param integer $id
     * @param Response
     */
    public function declineAction(Request $request, $subject, $id)
    {
        $record = $this->getRecordResolver()->getRecordForImport($subject, $id);
        $manager = $this->getResourceFactory()->resolveSubject($subject)->getManager();

        if (!$record) {
            return $this->createNotFoundException('Import record not found.');
        }

        $record->setStatus(ImportTargetInterface::DECLINED);
        $manager->persist($record);
        $manager->flush();

        if ($request->isXMLHttpRequest()) {
            return new JsonResponse(array(
                'result' => 'success'
            ));
        }

        return $this->redirectHandler->redirectToReferer();
    }

    private function getEventDispatcher()
    {
        return $this->get('event_dispatcher');
    }

    private function getImportSignals()
    {
        return $this->container->getParameter('accard.import.signals');
    }

    private function getRecordResolver()
    {
        return $this->get('accard.import.record_resolver');
    }

    private function getResourceFactory()
    {
        return $this->get('accard.import.resource_factory');
    }

    private function getImporter($importerName)
    {
        return $this->get('accard.import.registry')->getImporter($importerName);
    }

    private function getRegistry()
    {
        return $this->get('accard.import.registry');
    }
}
