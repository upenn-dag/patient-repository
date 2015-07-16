<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Option\Model;

use DateTime;
use Mockery;
use Codeception\TestCase\Test;
use Accard\Component\Resource\Model\Log;

/**
 * Log tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class LogTest extends Test
{
    protected function _before()
    {
        $this->user = Mockery::mock('Accard\Component\Resource\Model\UserInterface');
        $this->log = new Log();
    }

    public function testLogClassInterfaceIsFollowed()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Model\LogInterface',
            $this->log
        );
    }

    public function testLogIdIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'id', $this->log);
        $this->assertNull($this->log->getId());
    }

    public function testLogUserIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'user', $this->log);
        $this->assertNull($this->log->getUser());
    }

    public function testLogUserIsMutable()
    {
        $this->log->setUser($this->user);
        $this->assertAttributeSame($this->user, 'user', $this->log);
    }

    public function testLogUserIsFluent()
    {
        $this->assertSame($this->log, $this->log->setUser($this->user));
    }

    public function testLogDateIsNowOnCreation()
    {
        $this->assertAttributeInstanceOf('DateTime', 'logDate', $this->log);
        $this->assertInstanceOf('DateTime', $this->log->getLogDate());
    }

    public function testLogDateIsMutable()
    {
        $expected = new DateTime();
        $this->log->setLogDate($expected);
        $this->assertSame($expected, $this->log->getLogDate());
    }

    public function testLogDateIsFluent()
    {
        $this->assertSame($this->log, $this->log->setLogDate(new DateTime()));
    }

    public function testLogActionIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'action', $this->log);
        $this->assertNull($this->log->getAction());
    }

    public function testLogActionIsMutable()
    {
        $expected = 'ACTION';
        $this->log->setAction($expected);
        $this->assertSame($expected, $this->log->getAction());
    }

    public function testLogActionIsFluent()
    {
        $this->assertSame($this->log, $this->log->setAction('ACTION'));
    }

    public function testLogResourceIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'resource', $this->log);
        $this->assertNull($this->log->getResource());
    }

    public function testLogResourceIsMutable()
    {
        $expected = 'RESOURCE';
        $this->log->setResource($expected);
        $this->assertSame($expected, $this->log->getResource());
    }

    public function testLogResourceIsFluent()
    {
        $this->assertSame($this->log, $this->log->setResource('RESOURCE'));
    }

    public function testLogResourceIdIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'resourceId', $this->log);
        $this->assertNull($this->log->getResourceId());
    }

    public function testLogResourceIdIsMutable()
    {
        $expected = 1;
        $this->log->setResource($expected);
        $this->assertSame($expected, $this->log->getResource());
    }

    public function testLogResourceIdIsFluent()
    {
        $this->assertSame($this->log, $this->log->setResourceId(1));
    }

    public function testLogResourceIdIsNullable()
    {
        $this->log->setResource(null);
        $this->assertNull($this->log->getResourceId());
    }

    public function testLogRouteIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'route', $this->log);
        $this->assertNull($this->log->getRoute());
    }

    public function testLogRouteIsMutable()
    {
        $expected = 'ROUTE';
        $this->log->setRoute($expected);
        $this->assertSame($expected, $this->log->getRoute());
    }

    public function testLogRouteIsFluent()
    {
        $this->assertSame($this->log, $this->log->setRoute('ROUTE'));
    }

    public function testLogRouteIsNullable()
    {
        $this->log->setRoute(null);
        $this->assertNull($this->log->getRoute());
    }

    public function testLogAttributesAreNullOnCreation()
    {
        $this->assertAttributeSame(null, 'attributes', $this->log);
        $this->assertNull($this->log->getAttributes());
    }

    public function testLogAttributesAreMutable()
    {
        $expected = array('attribute' => 'attribute');
        $this->log->setAttributes($expected);
        $this->assertSame($expected, $this->log->getAttributes());
    }

    public function testLogAttributesIsFluent()
    {
        $this->assertSame($this->log, $this->log->setAttributes(array()));
    }

    public function testLogAttributesAreNullable()
    {
        $this->log->setAttributes(null);
        $this->assertNull($this->log->getAttributes());
    }

    public function testLogQueryAreNullOnCreation()
    {
        $this->assertAttributeSame(null, 'query', $this->log);
        $this->assertNull($this->log->getQuery());
    }

    public function testLogQueryAreMutable()
    {
        $expected = array('query' => 'query');
        $this->log->setQuery($expected);
        $this->assertSame($expected, $this->log->getQuery());
    }

    public function testLogQueryIsFluent()
    {
        $this->assertSame($this->log, $this->log->setQuery(array()));
    }

    public function testLogQueryAreNullable()
    {
        $this->log->setQuery(null);
        $this->assertNull($this->log->getQuery());
    }

    public function testLogRequestAreNullOnCreation()
    {
        $this->assertAttributeSame(null, 'request', $this->log);
        $this->assertNull($this->log->getRequest());
    }

    public function testLogRequestAreMutable()
    {
        $expected = array('request' => 'request');
        $this->log->setRequest($expected);
        $this->assertSame($expected, $this->log->getRequest());
    }

    public function testLogRequestIsFluent()
    {
        $this->assertSame($this->log, $this->log->setRequest(array()));
    }

    public function testLogRequestAreNullable()
    {
        $this->log->setRequest(null);
        $this->assertNull($this->log->getRequest());
    }
}
