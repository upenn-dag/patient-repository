<?php

namespace Accard\Bundle\TemplateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Accard\Bundle\TemplateBundle\Entity\Template;
use Accard\Bundle\TemplateBundle\Doctrine\ORM\TemplateRepository;
use Accard\Bundle\TemplateBundle\Form\Type\TemplateType;
use Symfony\Component\HttpFoundation\Request;
use Accard\Bridge\Twig\Loader\TwigDatabaseLoader;

class TemplateController extends Controller
{
    /**
     * Template Repository.
     */
    private $repository;

    /**
     * Constructor.
     */
    function __construct(TemplateRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Template index
     */
    public function indexAction()
    {
        $templates = $this->repository->findAll();

        return $this->render('AccardWebBundle:Backend/Template:index.html.twig', array(
            'templates' => $templates,
        ));
    }

    /**
     * Design a template
     */
    public function designAction(Request $request, $name)
    {
        $template = $this->repository->findOneOrCreate(array('name' => $name));
        $form = $this->createTemplateForm($template);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($template);
                $em->flush();

                return $this->redirect($this->generateUrl('accard_backend_template_index'));
            }
        }

        return $this->render('AccardWebBundle:Backend/Template:design.html.twig', array(
            'name'  => $name,
            'form'  => $form->createView(),
        ));
    }

    /**
     * Create form.
     * 
     */
    private function createTemplateForm($template = null)
    {
        $bundles = array();

        foreach($this->container->getParameter('kernel.bundles') as $bundle => $class) {
            if (TwigDatabaseLoader::MAGIC_PREFIX === substr($bundle, 0, strlen(TwigDatabaseLoader::MAGIC_PREFIX))) {
                $bundles[$bundle] = $bundle;
            }
        }

        return $this->createForm(new TemplateType(), $template, array(
            'bundle_choices' => $bundles,
            'default_bundle' => 'AccardWebBundle',
        ));
    }

    /**
     * Create a template
     */
    public function createAction()
    {
        $form = $this->createTemplateForm();

        return $this->render('AccardWebBundle:Backend/Template:create.html.twig', array(
            'form' => $form,
        ));
    }
}
