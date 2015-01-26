<?php
/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CanvasBundle\Controller;

use Accard\Bundle\CanvasBundle\Doctrine\ORM\CanvasRepository;
use Accard\Bundle\PrototypeBundle\Doctrine\ORM\PrototypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use StdClass;

/**
 * Class CanvasController
 *
 * @author Dylan Pierce <piercedy@med.upenn.edu>
 * @package Accard\Bundle\CanvasBundle\Controller
 */

class CanvasController extends Controller
{
    /**
     * Canvas Repository.
     */
    private $canvasRepository;


    /**
     * Constructor.
     */
    function __construct(CanvasRepository $canvasRepository)
    {
        $this->canvasRepository = $canvasRepository;
    }

    /**
     * Canvas design view
     *
     * @return mixed
     */
    public function designAction()
    {
        $patient = $this->getDoctrine()->getManager()->getRepository('Accard\Component\Patient\Model\Patient')->find(1);
        $data = array(
            'patient' => $patient,
        );

        $factory = $this->get('accard.widget.factory');
        $builder = $factory->createBuilder('widget');

        $builder->add('patient', 'resource', array('data' => $patient));
        $builder->add('heading', 'heading', array());
        $builder->add('another', 'text', array());

        $widget = $builder->getWidget();
        $view = $widget->createView();

        return $this->render('AccardWebBundle:Backend/Canvas:design.html.twig', array(
            'widget' => $view,
        ));
    }

    /**
     * Render the widgets stored in canvas
     * 
     * @todo implement canvas separation
     * *note* The render action is not aware of the resources the page uses. It only grabs the canvas JSON and converts to a widget for rendering to the end user
     */
    public function renderAction()
    {
        $canvas = $this->canvasRepository->findOneOrCreate(array('route' => 'test/route'));

        $patient = $this->getDoctrine()->getManager()->getRepository('Accard\Component\Patient\Model\Patient')->find(1);
        $data = array(
            'patient' => $patient,
        );

        $factory = $this->get('accard.widget.factory');
        $builder = $factory->createBuilder('widget');

        $gridFactory = $this->get('accard.grid.factory');
        $gridBuilder = $gridFactory->createBuilder();

        //$gridBuilder->addConfig($canvas->getGrid());
        //$grid = $gridBuilder->getGrid();

        $builder->add('patient', 'resource', array('data' => $patient));

        $widget = $builder->getWidget();
        $view = $widget->createView();

        return $this->render('AccardWebBundle:Frontend:widgetTest.html.twig', array(
            'widget' => $view,
            //'grid' => $grid,
        ));
    }

    /**
     * API Endpoint for Grid on Canvas Angular App
     *
     * @todo Make dynamic...
     * 
     * @return JsonResponse
     * @throws \Exception
     */
    public function gridAction()
    {
        $canvas = $this->canvasRepository->findOneOrCreate(array('route' => 'test/route'));

        if ($canvas->getGrid()) {
            $grid = $canvas->getGrid();
        } else {
            // Default grid
            $grid = array(
                array( 'id' => 1, 'columns' => array( array('id' => 1, 'widget' => new StdClass), array('id' => 2, 'widget' => new StdClass) )),
                array( 'id' => 2, 'columns' => array( array('id' => 3, 'widget' => new StdClass), array('id' => 4, 'widget' => new StdClass) )),
                array( 'id' => 3, 'columns' => array( array('id' => 5, 'widget' => new StdClass), array('id' => 6, 'widget' => new StdClass) )),
            );
        }

        $response = new JsonResponse(array('grid' => $grid));
       // $response->setEncodingOptions(JSON_FORCE_OBJECT);

        return $response;
    }

    /**
     * API Endpoint for Widgets on Canvas Angular App
     *
     * *note* this means all widgets, including the resource because it has not yet been assigned on the first page load
     * @return JsonResponse
     * @throws \Exception
     */
    public function widgetAction()
    {
        $response = new JsonResponse();

        $patient = $this->getDoctrine()->getManager()->getRepository('Accard\Component\Patient\Model\Patient')->find(1);
        $data = array(
            'patient' => $patient,
        );

        $factory = $this->get('accard.widget.factory');
        $builder = $factory->createBuilder('widget');

        $builder->add('patient', 'resource', array('data' => $patient));

        $widget = $builder->getWidget();
        $view = $widget->createView();

        // TODO: Make recursion possible
        $flattenedList = array();
        foreach ($view->children as $child) {
            $flattenedList[] = $child;
        }

        $response->setData($flattenedList);

        return $response;
    }

    public function configAction(Request $request)
    {
        $canvas = $this->canvasRepository->findOneOrCreate(array('route' => 'test/route'));
        $canvas->setGrid($request->request->get('rows'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($canvas);
        $em->flush();

        return new JsonResponse(array('success' => 'true', 'route' => $canvas->getRoute(), 'canvas' => $canvas->getGrid()));
    }
}
