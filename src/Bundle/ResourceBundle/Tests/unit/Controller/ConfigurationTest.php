<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Bundle\ResourceBundle\Controller;

use Mockery;
use Symfony\Component\HttpFoundation\Request;
use Accard\Bundle\ResourceBundle\Controller\Configuration;

/**
 * Controller configration tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ConfigurationTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->paramHandler = Mockery::mock('Accard\Bundle\ResourceBundle\Controller\ParametersParser')
            ->shouldReceive('parse')->zeroOrMoreTimes()->andReturn(array())
            ->getMock();

        $this->request = new Request();
        $this->config = new Configuration($this->paramHandler, 'prefix', 'resource', 'namespace');
    }

    public function testConfigurationCreationSetsRequiredProperties()
    {
        $this->assertAttributeSame('prefix', 'bundlePrefix', $this->config);
        $this->assertAttributeSame('resource', 'resourceName', $this->config);
        $this->assertAttributeSame('namespace', 'templateNamespace', $this->config);
    }

    public function testConfigurationDefaultTemplateEngineIsTwig()
    {
        $this->assertAttributeSame('twig', 'templatingEngine', $this->config);
    }

    public function testConfigurationRequestIsMutable()
    {
        $this->config->setRequest($this->request);
        $this->assertAttributeSame($this->request, 'request', $this->config);
        $this->assertSame($this->request, $this->config->getRequest());
    }

    public function testConfigurationParsesParametersFromRequest()
    {
        $params = array('key' => 'value');
        $this->request->attributes->replace(array('_accard' => $params));
        $this->config->setRequest($this->request);
        $this->assertAttributeSame($params, 'parameters', $this->config);
        $this->assertSame($params, $this->config->getParameters());
    }

    public function testConfigurationParametersCanBeReplaced()
    {
        $params = array('key' => 'value');
        $this->config->setParameters($params);
        $this->assertAttributeSame($params, 'parameters', $this->config);
    }

    public function testConfigurationYieldsExpectedBundlePrefix()
    {
        $this->assertSame('prefix', $this->config->getBundlePrefix());
    }

    public function testConfigurationYieldsExpectedResourceName()
    {
        $this->assertSame('resource', $this->config->getResourceName());
    }

    public function testConfigurationYieldsExpectedPluralResourceName()
    {
        $this->assertSame('resources', $this->config->getPluralResourceName());
    }

    public function testConfigurationYieldsExpectedTemplateNamespace()
    {
        $this->assertSame('namespace', $this->config->getTemplateNamespace());
    }

    public function testConfigurationYieldsExpectedTemplatingEngine()
    {
        $this->assertSame('twig', $this->config->getTemplatingEngine());
    }

    public function testConfigurationCanDetectApiRequest()
    {
        $config = new Configuration($this->paramHandler, '', '', '');

        // No request, no API request
        $this->assertFalse($this->config->isApiRequest());

        $this->config->setRequest($this->request);

        // Request format HTML? No API request
        $this->request->setRequestFormat('html');
        $this->assertFalse($this->config->isApiRequest());

        // Request format JSON? API request
        $this->request->setRequestFormat('json');
        $this->assertTrue($this->config->isApiRequest());
    }

    public function testConfigurationYieldsExpectedServiceName()
    {
        $this->assertSame('prefix.service.resource', $this->config->getServiceName('service'));
    }

    public function testConfigurationYieldsExpectedEventName()
    {
        $this->assertSame('prefix.resource.event', $this->config->getEventName('event'));
    }

    public function testConfigurationYieldsExpectedTemplateName()
    {
        $this->assertSame('namespace:template.twig', $this->config->getTemplateName('template'));
    }

    public function testConfigurationYieldsExpectedTemplate()
    {
        // Test when no template is present
        $this->assertSame('namespace:template.twig', $this->config->getTemplate('template'));

        // Test when given one
        $this->config->setParameters(array(
            'template' => 'TEMPLATE'
        ));
        $this->assertSame('TEMPLATE', $this->config->getTemplate('template'));
    }

    public function testConfigurationYieldsExpectedFormTypeWhenEmpty()
    {
        $this->assertSame('prefix_resource', $this->config->getFormType('FORM'));
    }

    public function testConfigurationYieldsExpectedFormTypeWhenString()
    {
        $this->config->setParameters(array(
            'form' => 'FORM'
        ));
        $this->assertSame('FORM', $this->config->getFormType('form'));
    }

    public function testConfigurationYieldsExpectedRouteName()
    {
        $this->assertSame('prefix_resource_route', $this->config->getRouteName('route'));
    }

    public function testConfigurationYieldsExpectedRedirectRouteWhenEmpty()
    {
        $this->assertSame('prefix_resource_route', $this->config->getRedirectRoute('route'));
    }

    public function testConfigurationYieldsExpectedRedirectRouteWhenArray()
    {
        $this->config->setParameters(array(
            'redirect' => array('route' => 'ROUTE')
        ));
        $this->assertSame('ROUTE', $this->config->getRedirectRoute('route'));
    }

    public function testConfigurationYieldsExpectedRedirectRouteIsString()
    {
        $this->config->setParameters(array(
            'redirect' => 'ROUTE'
        ));
        $this->assertSame('ROUTE', $this->config->getRedirectRoute('route'));
    }

    public function testConfigurationYieldsExpectedRedirectParametersWhenEmpty()
    {
        $this->assertSame(array(), $this->config->getRedirectParameters());
    }

    public function testConfigurationYieldsExpectedRedirectParametersWhenArray()
    {
        $expected = array('array');
        $this->paramHandler = Mockery::mock('Accard\Bundle\ResourceBundle\Controller\ParametersParser')
            ->shouldReceive('process')->once()->andReturn($expected)
            ->getMock();

        $config = new Configuration($this->paramHandler, 'prefix', 'resource', 'namespace');
        $config->setParameters(array(
            'redirect' => array('parameters' => $expected)
        ));
        
        $this->assertSame($expected, $config->getRedirectParameters('resource'));
    }

    public function testConfigurationIsTenByDefault()
    {
        $this->assertSame(10, $this->config->getLimit());
    }

    public function testConfigurationYieldsExpectedLimitWhenSet()
    {
        $this->config->setParameters(array(
            'limit' => 20
        ));
        $this->assertSame(20, $this->config->getLimit());
    }

    public function testConfigurationYieldsNullWhenSetToFalse()
    {
        $this->config->setParameters(array(
            'limit' => false
        ));
        $this->assertNull($this->config->getLimit());
    }

    public function testConfigurationPaginationIsTrueByDefault()
    {
        $this->assertTrue($this->config->isPaginated());
    }

    public function testConfigurationYieldsExpectedResultWhenSet()
    {
        $this->config->setParameters(array(
            'paginate' => false
        ));
        $this->assertFalse($this->config->isPaginated());
    }

    public function testConfigurationMaxPerPageIsTenByDefault()
    {
        $this->config->setRequest($this->request);
        $this->assertSame(10, $this->config->getPaginationMaxPerPage());
    }

    public function testConfigurationMaxPerPageCanBeTakenFromRequest()
    {
        $this->request->query->set('limit', 20);
        $this->config->setRequest($this->request);
        $this->assertSame(20, $this->config->getPaginationMaxPerPage());
    }

    public function testConfigurationYieldsPaginationDefaultWhenNotPresentElsewhere()
    {
        $this->config->setRequest($this->request);
        $this->config->setParameters(array(
            'paginate' => 20
        ));
        $this->assertSame(20, $this->config->getPaginationMaxPerPage());
    }

    public function testConfigurationFilterableIsFalseByDefault()
    {
        $this->assertFalse($this->config->isFilterable());
    }

    public function testConfigurationYieldsExpectedFilterableValueWhenSet()
    {
        $this->config->setParameters(array(
            'filterable' => true
        ));
        $this->assertTrue($this->config->isFilterable());
    }

    public function testConfigurationSortableIsFalseByDefault()
    {
        $this->assertFalse($this->config->isSortable());
    }

    public function testConfigurationYieldsExpectedSortableValueWhenSet()
    {
        $this->config->setParameters(array(
            'sortable' => true
        ));
        $this->assertTrue($this->config->isSortable());
    }
}
