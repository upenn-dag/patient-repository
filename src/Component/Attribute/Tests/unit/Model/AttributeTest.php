<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Attribute\Model;

use DateTime;
use Mockery;
use Codeception\TestCase\Test;
use Accard\Component\Attribute\Model\Attribute;
use Accard\Component\Field\Test\FieldSubjectTest;

/**
 * Attribute model tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class AttributeTest extends Test
{
    use FieldSubjectTest;

    protected function _before()
    {
        $this->attribute = new Attribute();

        // Required by field subject test trait above.
        $this->fieldSubject = $this->attribute;
    }

    public function testAttributeInterfaceIsFollowed()
    {
        $this->assertInstanceOf(
            'Accard\Component\Attribute\Model\AttributeInterface',
            $this->attribute
        );
    }

    public function testAttributeIsAccardResource()
    {
        $this->assertInstanceOf(
            'Accard\Component\Resource\Model\ResourceInterface',
            $this->attribute
        );
    }

    public function testAttributeIdIsNullOnCreation()
    {
        $this->assertAttributeSame(null, 'id', $this->attribute);
        $this->assertNull($this->attribute->getId());
    }
}
