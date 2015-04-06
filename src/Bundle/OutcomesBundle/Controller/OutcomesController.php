<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\OutcomesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Accard\Bundle\ResourceBundle\Controller\ExpressionAwareController;
use Accard\Bundle\OutcomesBundle\Exception\OutcomesException;
use JMS\Serializer\SerializationContext;

/**
 * Accard outcomes controller.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class OutcomesController extends Controller implements ExpressionAwareController
{
    /**
     * Outcomes main.
     *
     * @param Request $request
     * @return Response
     */
    public function mainAction(Request $request)
    {
        return $this->render('AccardOutcomesBundle::main.html.twig');
    }

    /**
     * Generate file, inform browser of the file that was created.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function generateAction(Request $request)
    {
        $format = $request->get("as", "csv");
        $serializer = $this->get("serializer");
        $config = $serializer->deserialize($request->getContent(), "Accard\Bundle\OutcomesBundle\Outcomes\Configuration", "json");

        $manager = $this->get("accard.outcomes.manager");
        $baseDataset = $manager->createBaseDataset($config, (int) $request->get("limit", 10));
        $translated = $manager->translate($baseDataset);

        $filename = sprintf("%s-%d.%s", $config->getTarget(), time(), $format);
        $file = $manager->exportToFile($translated, $format, $filename, array());

        $response = new JsonResponse(array(
            "file" => $filename,
        ));

        return $response;
    }

    /**
     * Download dataset.
     *
     * @param Request $request
     * @return Response
     */
    public function downloadAction(Request $request)
    {
        $manager = $this->get("accard.outcomes.manager");
        $givenFilename = $request->get("file");
        $filename = $manager->generateExportFilePath($givenFilename);

        if (!$givenFilename || !file_exists($filename) || !is_readable($filename)) {
            throw $this->createNotFoundException(
                "Requested file is invalid, you may only download a file one time before it is deleted."
            );
        }

        $response = new BinaryFileResponse($filename);
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $givenFilename
        );
        $response->deleteFileAfterSend(true);

        return $response;
    }

    /**
     * List of filters.
     *
     * @param Request $request
     * @return Response
     */
    public function filtersAction(Request $request)
    {
        $registry = $this->get("accard.outcomes.filter_registry");
        $format = $request->get("_format");
        $serializer = $this->get("serializer");

        $content = $serializer->serialize($registry, $format, $this->createSerializerContext());

        return new Response($content, 200, array("Content-Type" => "application/".$format));
    }

    /**
     * Outcomes filtered data set.
     *
     * @param Request $request
     * @return Response
     */
    public function filteredDatasetAction(Request $request)
    {
        $format = $request->get("_format");
        $serializer = $this->get("serializer");
        $config = $serializer->deserialize($request->getContent(), "Accard\Bundle\OutcomesBundle\Outcomes\Configuration", $format);

        $manager = $this->get("accard.outcomes.manager");
        $baseDataset = $manager->createBaseDataset($config, (int) $request->get("limit", 10));
        $content = $serializer->serialize($baseDataset, $format, $this->createSerializerContext());

        return new Response($content, 200, array("Content-Type" => "application/".$format));
    }

    /**
     * Outcomes translated data set.
     *
     * @param Request $request
     * @return Response
     */
    public function translatedDatasetAction(Request $request)
    {
        $format = $request->get("_format");
        $serializer = $this->get("serializer");
        $config = $serializer->deserialize($request->getContent(), "Accard\Bundle\OutcomesBundle\Outcomes\Configuration", $format);

        $manager = $this->get("accard.outcomes.manager");
        $translator = $manager->createDatasetTranslator();
        $baseDataset = $manager->createBaseDataset($config, (int) $request->get("limit", 10));
        $translated = $translator->translate($baseDataset);
        $content = $serializer->serialize($translated, $format, $this->createSerializerContext());

        return new Response($content, 200, array("Content-Type" => "application/".$format));
    }

    /**
     * Custom serializer context.
     *
     * This is required in order to set options for the serializer. We require
     * all nulls to actually be rendered instead of left off the databset.
     *
     * @return SerializationContext
     */
    private function createSerializerContext()
    {
        $context = new SerializationContext();
        $context->setSerializeNull(true);

        return $context;
    }
}
