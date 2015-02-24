<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Accard\Component\Option\Model\OptionInterface;

/**
 * Base frontend controller.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FrontendController extends Controller
{
    /**
     * Frontend homepage action.
     *
     * @var Response
     */
    public function mainAction(Request $request)
    {
        // $accard = $this->get('accard.state');
        // $theState = $accard->getState();
        // //die(var_dump($theState));
        // die(json_encode($theState, JSON_PRETTY_PRINT));
        // die(serialize($theState));

        return $this->render('AccardWebBundle:Frontend:main.html.twig');
    }

    /**
     * Render filter form.
     *
     * @param string $type
     * @param string $template
     * @return Response
     */
    public function filterAction($type, $template)
    {
        $request = $this->get('request_stack')->getMasterRequest();
        $criteria = $request->query->get('criteria', array());
        $form = $this
            ->get('form.factory')
            ->createNamed('criteria', $type, $criteria, array('csrf_protection' => false));

        return $this->render($template, array('form' => $form->createView(), 'filter_criteria' => $criteria));
    }

    /**
     * Create a prototype choice form.
     *
     * @param Request $request
     * @param string $type
     * @return Response
     */
    public function prototypeChoiceFormAction(Request $request, $type)
    {
        $form = $this->createPrototypeChoiceForm($type);

        return $this->render('AccardWebBundle:Common/Form:prototypeChoiceForm.html.twig', array(
            'form' => $form->createView(),
            'type' => $type,
        ));
    }

    /**
     * Create a prototype list form.
     * Lists all activity prototypes in create buttons
     * @param Request $request
     * @param string $type
     * @return Response
     */
    public function prototypeListFormAction(Request $request, $type,$activities)
    {


        $form = $this->createPrototypeListForm($type);

        return $this->render('AccardWebBundle:Common/Form:prototypeListForm.html.twig', array(
            'form' => $form->createView(),
            'type' => $type,
            'activities' => $activities,
        ));
    }


    /**
     * Redirect to proper place from prototype selection.
     *
     * @param Request $request
     * @param string $type
     * @return RedirectResponse
     */
    public function prototypeRedirectAction(Request $request, $type)
    {
        $form = $this->createPrototypeChoiceForm($type);
        $form->handleRequest($request);
        $prototype = $form->get('prototype')->getData();

        if ($form->get('create')->isClicked()) {
            $route = sprintf('accard_frontend_%s_create', $type);
            $url = $this->generateUrl($route, array('prototype' => $prototype->getName()));
        } elseif ($form->get('index')->isClicked()) {
            $route = sprintf('accard_frontend_%s_index_by_prototype', $type);
            $url = $this->generateUrl($route, array('prototype' => $prototype->getName()));
        }

        if (isset($url)) {
            return $this->redirect($url);
        }

        throw $this->createNotFoundException();
    }

    /**
     * Redirect to proper place activity prototype selection.
     *
     * @param Request $request
     * @param string $type
     * @return RedirectResponse
     */
    public function prototypeListAction($type)
    {


            $route = 'accard_frontend_activity_create';
            $url = $this->generateUrl($route, array('prototype' => $type));
    
        if (isset($url)) {
           
            return $this->redirect($url);
        }

        throw $this->createNotFoundException();
    }

    /**
     * Create prototype list form.
     *
     * @param string $type
     */
    private function createPrototypeListForm($type)
    {
        $prototypeListType = sprintf('accard_%s_prototype_choice', $type);
        $builder = $this->get('form.factory')->createNamedBuilder(null, 'form', array(), array(
            'csrf_protection' => false,
            'method' => 'GET',
        ));

        $builder->add('prototypes', $prototypeListType, array(
            'required' => true,
            'placeholder' => 'accard.prototype_choice.action.choose',
        ));

       $builder->add('create', 'submit', array(
            'label' => 'accard.prototype_choice.action.create',
        ));
        return $builder->getForm();
    }

    /**
     * Create prototype choice form.
     *
     * @param string $type
     */
    private function createPrototypeChoiceForm($type)
    {
        $prototypeChoiceType = sprintf('accard_%s_prototype_choice', $type);
        $builder = $this->get('form.factory')->createNamedBuilder(null, 'form', array(), array(
            'csrf_protection' => false,
            'method' => 'GET',
        ));

        $builder->add('prototype', $prototypeChoiceType, array(
            'required' => true,
            'placeholder' => 'accard.prototype_choice.action.choose',
        ));

        $builder->add('create', 'submit', array(
            'label' => 'accard.prototype_choice.action.create',
        ));

        $builder->add('index', 'submit', array(
            'label' => 'accard.prototype_choice.action.index',
        ));

        return $builder->getForm();
    }

    /**
     * Present option 'quick add' form.
     *
     * @param Request $request
     * @param integer $option
     */
    public function quickAddOptionAction(Request $request, $option)
    {
        $optionProvider = $this->get('accard.provider.option');

        if (!$optionProvider->hasOption($option)) {
            throw $this->createNotFoundException();
        }

        $option = $optionProvider->getOption($option);
        $form = $this->createQuickAddForm($option);

        if ($request->isMethod('POST')) {
            $response = new JsonResponse(array());
            $form->handleRequest($request);
            $optionValue = $form->getData()['newValue'];

            if ($form->isValid()) {
                $em = $this->get('accard.manager.option');
                $option->addValue($optionValue);
                $em->persist($option);
                $em->persist($optionValue);
                $em->flush();
            } else {
                $response->setStatusCode(400);
            }

            return $response;
        }

        return $this->render('AccardWebBundle:Frontend\Option:create.html.twig', array(
            'form' => $form->createView(),
            'option' => $option,
        ));
    }

    /**
     * Create a form for the quick add.
     *
     * @param OptionInterface $option
     */
    private function createQuickAddForm(OptionInterface $option)
    {
        $builder = $this->createFormBuilder(array(), array(
            'action' => $this->generateUrl('accard_frontend_option_quickadd', array('option' => $option->getId())),
            'method' => 'POST',
        ));

        $builder->add('newValue', 'accard_option_value', array(
            'required' => true,
        ));

        return $builder->getForm();
    }
}
