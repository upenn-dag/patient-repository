<?php

namespace spec\Accard\Bundle\ResourceBundle\Controller;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Accard\Bundle\ResourceBundle\Controller\ParametersParser;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

/**
 * Resource controller configuration product.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ConfigurationSpec extends ObjectBehavior
{
    function let(Request $request, ParametersParser $parser)
    {
        $this->beConstructedWith($parser, 'accard', 'product', 'AccardWebBundle:Product', 'twig');
        $request->attributes = new ParameterBag();
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Accard\Bundle\ResourceBundle\Controller\Configuration');
    }

    function it_returns_assigned_bundle_prefix()
    {
        $this->getBundlePrefix()->shouldReturn('accard');
    }

    function it_returns_assigned_resource_name()
    {
        $this->getResourceName()->shouldReturn('product');
    }

    function it_returns_plural_resource_name()
    {
        $this->getPluralResourceName()->shouldReturn('products');
    }

    function it_returns_assigned_template_namespace()
    {
        $this->getTemplateNamespace()->shouldReturn('AccardWebBundle:Product');
    }

    function it_returns_assigned_templating_engine()
    {
        $this->getTemplatingEngine()->shouldReturn('twig');
    }

    function it_generates_service_names()
    {
        $this->getServiceName('manager')->shouldReturn('accard.manager.product');
        $this->getServiceName('repository')->shouldReturn('accard.repository.product');
        $this->getServiceName('controller')->shouldReturn('accard.controller.product');
    }

    function it_generates_event_names()
    {
        $this->getEventName('create')->shouldReturn('accard.product.create');
        $this->getEventName('created')->shouldReturn('accard.product.created');
    }

    function it_generates_template_names()
    {
        $this->getTemplateName('index.html')->shouldReturn('AccardWebBundle:Product:index.html.twig');
        $this->getTemplateName('show.html')->shouldReturn('AccardWebBundle:Product:show.html.twig');
        $this->getTemplateName('create.html')->shouldReturn('AccardWebBundle:Product:create.html.twig');
        $this->getTemplateName('update.html')->shouldReturn('AccardWebBundle:Product:update.html.twig');

        $this->getTemplateName('custom.html')->shouldReturn('AccardWebBundle:Product:custom.html.twig');
    }

    function it_generates_route_names()
    {
        $this->getRouteName('index')->shouldReturn('accard_product_index');
        $this->getRouteName('show')->shouldReturn('accard_product_show');
        $this->getRouteName('custom')->shouldReturn('accard_product_custom');
    }

    function its_not_sortable_by_default($request)
    {
        $this->setRequest($request);
        $this->isSortable()->shouldReturn(false);
    }

    function its_not_filterable_by_default($request)
    {
        $this->setRequest($request);
        $this->isFilterable()->shouldReturn(false);
    }

    function it_has_limit_equal_to_10_by_default($request)
    {
        $this->setRequest($request);
        $this->getLimit()->shouldReturn(10);
    }

    function its_paginated_by_default($request)
    {
        $this->setRequest($request);
        $this->isPaginated()->shouldReturn(true);
    }

    function it_has_limit_equal_to_null_if_limit_is_set_to_false($request)
    {
        $request->attributes->set('_accard', array('limit' => false));
        $this->setRequest($request);

        $this->getLimit()->shouldReturn(null);
    }

    function its_pagination_max_per_page_is_equal_to_10_by_default($request)
    {
        $this->setRequest($request);
        $this->getPaginationMaxPerPage()->shouldReturn(10);
    }

    function its_api_request_when_format_is_not_html($request)
    {
        $this->setRequest($request);

        $request->getRequestFormat()->willReturn('html');
        $this->isApiRequest()->shouldReturn(false);

        $request->getRequestFormat()->willReturn('xml');
        $this->isApiRequest()->shouldReturn(true);

        $request->getRequestFormat()->willReturn('json');
        $this->isApiRequest()->shouldReturn(true);
    }

    function it_generates_view_template_by_default($request)
    {
        $this->setRequest($request);
        $this->getTemplate('create.html')->shouldReturn('AccardWebBundle:Product:create.html.twig');
    }

    function it_gets_view_template_from_request_attributes_if_available($request)
    {
        $request->attributes->set('_accard', array('template' => 'AccardWebBundle:Product:custom.html.twig'));
        $this->setRequest($request);

        $this->getTemplate('create.html')->shouldReturn('AccardWebBundle:Product:custom.html.twig');
    }

    function it_generates_form_type_by_default($request)
    {
        $this->setRequest($request);
        $this->getFormType()->shouldReturn('accard_product');
    }

    function it_gets_form_type_from_request_attributes_if_available($request)
    {
        $request->attributes->set('_accard', array('form' => 'accard_product_custom'));
        $this->setRequest($request);

        $this->getFormType()->shouldReturn('accard_product_custom');
    }

    function it_generates_redirect_route_by_default($request)
    {
        $this->setRequest($request);

        $this->getRedirectRoute('index')->shouldReturn('accard_product_index');
        $this->getRedirectRoute('show')->shouldReturn('accard_product_show');
        $this->getRedirectRoute('custom')->shouldReturn('accard_product_custom');
    }

    function it_gets_redirect_route_from_request_attributes_if_available($request)
    {
        $request->attributes->set('_accard', array('redirect' => 'accard_product_custom'));
        $this->setRequest($request);

        $this->getRedirectRoute('index')->shouldReturn('accard_product_custom');
    }

    function it_returns_empty_array_as_redirect_parameters_by_default($request)
    {
        $this->setRequest($request);
        $this->getRedirectParameters()->shouldReturn(array());
    }

    function it_gets_redirect_route_and_parameters_from_request_attributes($request)
    {
        $redirect = array(
            'route'      => 'accard_list',
            'parameters' => array('id' => 1)
        );

        $request->attributes->set('_accard', array('redirect' => $redirect));
        $this->setRequest($request);

        $this->getRedirectRoute('index')->shouldReturn('accard_list');
        $this->getRedirectParameters()->shouldReturn(array('id' => 1));
    }

    function it_gets_criteria_from_request_attributes($request)
    {
        $request->attributes->set('_accard', array('criteria' => array('enabled' => false)));
        $this->setRequest($request);

        $this->getCriteria()->shouldReturn(array('enabled' => false));
    }

    function it_gets_criteria_from_request_if_resources_are_filterable($request)
    {
        $request->get('criteria', Argument::any())->shouldBeCalled()->willReturn(array('locked' => false));
        $request->attributes->set('_accard', array(
            'filterable' => true,
            'criteria'   => array('enabled' => false)
        ));

        $this->setRequest($request);

        $this->getCriteria()->shouldReturn(array('enabled' => false, 'locked' => false));
    }

    function it_does_not_get_criteria_from_request_if_resources_are_not_filterable($request)
    {
        $request->get('criteria', Argument::any())->shouldNotBeCalled();
        $request->attributes->set('_accard', array(
            'filterable' => false,
            'criteria'   => array('enabled' => false)
        ));

        $this->setRequest($request);

        $this->getCriteria()->shouldReturn(array('enabled' => false));
    }

    function it_gets_sorting_from_request_if_resources_are_sortable($request)
    {
        $request->get('sorting', Argument::any())->willReturn(array('createdAt' => 'desc'));
        $request->attributes->set('_accard', array(
            'sortable' => true,
            'sorting'  => array('name' => 'asc')
        ));

        $this->setRequest($request);

        $this->getSorting()->shouldReturn(array('name' => 'asc', 'createdAt' => 'desc'));
    }

    function it_does_not_get_sorting_from_request_if_resources_are_not_sortable($request)
    {
        $request->get('sorting', Argument::any())->shouldNotBeCalled();
        $request->attributes->set('_accard', array(
            'sortable' => false,
            'sorting'  => array('name' => 'asc')
        ));

        $this->setRequest($request);

        $this->getSorting()->shouldReturn(array('name' => 'asc'));
    }

    function it_gets_sorting_from_request_attributes($request)
    {
        $request->attributes->set('_accard', array('sorting' => array('createdAt' => 'asc')));
        $this->setRequest($request);

        $this->getSorting()->shouldReturn(array('createdAt' => 'asc'));
    }

    function it_is_not_paginated_if_paginate_option_is_set_to_false($request)
    {
        $request->attributes->set('_accard', array('paginate' => false));
        $this->setRequest($request);

        $this->isPaginated()->shouldReturn(false);
    }

    function it_gets_pagination_max_per_page_from_request_attributes($request)
    {
        $request->attributes->set('_accard', array('paginate' => 25));
        $this->setRequest($request);

        $this->getPaginationMaxPerPage()->shouldReturn(25);
    }

    function it_gets_limit_from_request_attributes($request)
    {
        $request->attributes->set('_accard', array('limit' => 20));
        $this->setRequest($request);

        $this->getLimit()->shouldReturn(20);
    }

    function it_returns_given_method_by_default($request)
    {
        $this->setRequest($request);

        $this->getMethod('createPaginator')->shouldReturn('createPaginator');
        $this->getMethod('findBy')->shouldReturn('findBy');
    }

    function it_gets_method_from_request_attributes_if_available($request)
    {
        $request->attributes->set('_accard', array('method' => 'findLatest'));
        $this->setRequest($request);

        $this->getMethod('findBy')->shouldReturn('findLatest');
    }

    function it_returns_empty_array_as_method_arguments_by_default($request)
    {
        $this->setRequest($request);
        $this->getArguments()->shouldReturn(array());
    }

    function it_gets_method_and_arguments_from_request_attributes($request)
    {
        $request->attributes->set('_accard', array(
            'method'    => 'findLatest',
            'arguments' => array(9)
        ));

        $this->setRequest($request);

        $this->getMethod('findOneBy')->shouldReturn('findLatest');
        $this->getArguments()->shouldReturn(array(9));
    }
}
