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
        // HOW TO SET UP A FILTER...
        // $resolver = new \Symfony\Component\OptionsResolver\OptionsResolver();
        // $betweenFilter = new \Accard\Bundle\OutcomesBundle\Outcomes\Filter\BetweenFilter();
        // $betweenFilter->configureOptions($resolver);
        // $options = $betweenFilter->resolveOptions($resolver, array(
        //     "type" => "date",
        //     "start" => "now",
        // ));
        // dump($betweenFilter);

        // FILTER REGISTRY
        // $registry = $this->get("accard.outcomes.filter_registry");
        // dump($registry);


        // GRAB THE MANAGER...
        $manager = $this->get("accard.outcomes.manager");
        //dump($manager);


        // GET OR CREATE A CONFIGURATION OBJECT
        $config = new \Accard\Bundle\OutcomesBundle\Outcomes\Configuration($state);
        $config->setTarget("activity");
        $config->setTargetPrototype("radiation");
        $dateFilter = $config->createFilterConfig("between", array("type" => "datetime", "start" => "01/01/2000", "end" => "now"));
        $cycleFilter = $config->createFilterConfig("between", array("type" => "number", "start" => 2, "end" => 5));
        $config->setFilter("activityDate", $dateFilter);
        $config->setFilter("cycles", $cycleFilter);


        // TURN THAT CONFIGURATION INTO AN ACTIVE CONFIG OBJECT
        // $config = $manager->createActiveConfig($config);
        // dump($config->getTarget());
        // dump($config->getTargetPrototype());
        // dump($config->getFilteredFields());


        // GET BASE DATASET FROM WHAT IS IN THAT CONFIG
        // Initialize the expression language.
        // This may not be the best place to put this...
        \Accard\Bundle\ResourceBundle\ExpressionLanguage\AccardLanguage::setExpressionLanguage($this->get('accard.expression_language'));
        $baseDataset = $manager->createBaseDataset($config, 5);

        // $serializer = $this->get("serializer");

        // $json = '{"target":"activity","target_prototype":"radiation","filters":{"activityDate":{"name":"between","options":{"type":"datetime","start":"01\/01\/2000","end":"now"}},"cycles":{"name":"between","options":{"type":"number","start":2,"end":5}}}}';
        // $serializer->deserialize($json, "Accard\\Bundle\\OutcomesBundle\\Outcomes\\Configuration", "json");

        // $response = new Response($serializer->serialize($baseDataset, "xml"));
        // $response->headers->set("Content-Type", "application/xml");
        // return $response;

        // $response = new JsonResponse();
        // $json = $serializer->serialize($baseDataset, "json");
        // $response->setContent($json);
        // return $response;

        die('');

        return new Response("<html><body></body></html>");
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
