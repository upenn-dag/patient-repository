<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Core\Model;

use Mockery;
use AccardTest\Component\Core\TestCase;
use Accard\Component\Core\Model\Attribute;

/**
 * Attribute model tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class AttributeTest extends TestCase
{
    public function _setupResource()
    {
        $this->resource = new Attribute();
    }

    public function testAttributeIsTimestampable()
    {
        $this->assertResourceTimestampable(true);
    }

    public function testAttributeIsBlamable()
    {
        $this->assertResourceBlameable(true);
    }

    public function testAttributeIsVersionable()
    {
        $this->assertResourceVersionable(true);
    }

    public function testAttributePatientCollection()
    {
        $this->assertResourceCollect('patient');
    }
}
