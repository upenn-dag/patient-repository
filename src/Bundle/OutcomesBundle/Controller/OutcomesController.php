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
use Symfony\Component\HttpFoundation\JsonResponse;
use Accard\Bundle\ResourceBundle\ExpressionLanguage\AccardLanguage;
use Accard\Bundle\OutcomesBundle\Exception\OutcomesException;

/**
 * Accard outcomes controller.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class OutcomesController extends Controller
{
    public function testAction(Request $request)
    {
        \Accard\Bundle\ResourceBundle\ExpressionLanguage\AccardLanguage::setExpressionLanguage($this->get('accard.expression_language'));
        $manager = $this->get("accard.outcomes.manager");
        $serializer = $this->get("serializer");

        $json = '{"target":"patient","target_prototype":null,"filters":{"dateOfBirth":{"name":"date_between","options":{"start":"01\/01\/2000","end":""}}}}';
        $config = $serializer->deserialize($json, "Accard\\Bundle\\OutcomesBundle\\Outcomes\\Configuration", "json");

        dump($config);

        $dataset = $manager->createBaseDataset($config, 10);
        // $serializer->serialize($dataset, "xml");

        // $response = new Response();
        // $response->setContent($serializer->serialize($dataset, "xml"));
        // $response->headers->set("Content-Type", "application/xml");
        // return $response;

        $config->setTranslations(array(
            "first-name" => "patient.getFirstName()",
            "last-name" => "patient.getLastName()",
        ));

        $translator = $manager->createDatasetTranslator();
        $translated = $translator->translate($dataset);

        // $response = new Response("<html><body></body></html>");
        // $response = new Response();
        // $response->setContent($serializer->serialize($translated, "xml"));
        // $response->headers->set("Content-Type", "application/xml");
        $response = new Response();
        $response->setContent($serializer->serialize($translated, "json"));
        $response->headers->set("Content-Type", "application/json");

        return $response;
    }

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
     * List of filters.
     *
     * @param Request $request
     * @return Response
     */
    public function filtersAction(Request $request)
    {
        AccardLanguage::setExpressionLanguage($this->get('accard.expression_language'));

        $registry = $this->get("accard.outcomes.filter_registry");
        $format = $request->get("_format");
        $serializer = $this->get("serializer");

        $content = $serializer->serialize($registry, $format);

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
        AccardLanguage::setExpressionLanguage($this->get('accard.expression_language'));

        $format = $request->get("_format");
        $serializer = $this->get("serializer");
        $config = $serializer->deserialize($request->getContent(), "Accard\Bundle\OutcomesBundle\Outcomes\Configuration", $format);

        $manager = $this->get("accard.outcomes.manager");
        $baseDataset = $manager->createBaseDataset($config, (int) $request->get("limit", 10));
        $content = $serializer->serialize($baseDataset, $format);

        return new Response($content, 200, array("Content-Type" => "application/".$format));
    }
}
