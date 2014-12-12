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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * Canvas design view
     *
     * @return mixed
     */
    public function designAction()
    {
        return $this->render('AccardWebBundle:Backend/Canvas:design.html.twig');
    }

    /**
     * API Endpoint for Grid on Canvas Angular App
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function gridAction()
    {
        $response = new JsonResponse();
        $response->setData(array(
            array( 'id' => 1, 'columns' => array( array('id' => 'A', 'widget' => new StdClass), array('id' => 'B', 'widget' => new StdClass) )),
            array( 'id' => 2, 'columns' => array( array('id' => 'A', 'widget' => new StdClass), array('id' => 'B', 'widget' => new StdClass) ))
        ));

        return $response;
    }

    /**
     * API Enpoint for Widgets on Canvas Angular App
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function widgetAction()
    {
        $response = new JsonResponse();

        $builder = $this->createWidgetBuilder();
        $builder->add('text1', 'text', array('text' => 'Block one. This goes here!'));
        $builder->add('text2', 'text', array('text' => '<p>Block two</p>.', 'raw' => true));
        $builder->add('translated', 'text', array('text' => 'accard.activity.entity_name', 'translate' => true));
        $builder->add('myHeading', 'heading', array('heading' => 'Create Patient'));
        $widget = $builder->getWidget();

        $widget = $this->serializeWidget($widget);

        $response->setData($widget);
        return $response;
    }

    public function configAction(Request $request)
    {
        $data = $request->getContent();
        $canvas = $this->canvasRepository->getOrCreate($data->url);
        $canvas->setGrid($data->grid);
        $this->canvasRepository->save($canvas);

        return new JsonResponse(array('success' => 'true'));
    }

    /**
     * Creates a widget instance.
     *
     * @param string $type
     * @param mixed|null $data
     * @param array $options
     * @return WidgetInterface
     */
    private function createWidget($type, $data = null, array $options = array())
    {
        return $this->container->get('accard.widget.factory')->create($type, $data, $options);
    }

    /**
     * Creates a widget builder instance.
     *
     * @param mixed|null $data
     * @param array $options
     * @return WidgetBuilderInterface
     */
    private function createWidgetBuilder($data = null, array $options = array())
    {
        return $this->container->get('accard.widget.factory')->createBuilder('widget', $data, $options);
    }

    /*
     * Serialized a single widget instance
     *
     * @return JSON
     */
    private function serializeWidget($widget)
    {
        $serializedWidget = array();

        foreach($widget->createView()->children as $widgetViewChild) {
            array_push( $serializedWidget, array(
                'name' => $widgetViewChild->vars['name'],
                'type' => $widgetViewChild->vars['type']
            ));
        }

        return $serializedWidget;
    }
}
