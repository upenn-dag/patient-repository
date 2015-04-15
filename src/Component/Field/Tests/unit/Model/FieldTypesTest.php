<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Model;

use Accard\Component\Field\Model\FieldTypes;

/**
 * Field types class tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FieldTypesTest extends \Codeception\TestCase\Test
{
    public function testFieldTypeYieldsChoices()
    {
        $this->assertInternalType('array', FieldTypes::getChoices());
    }

    public function testFieldTypeTieldsChoiceKeys()
    {
        $this->assertInternalType('array', FieldTypes::getKeys());
    }
}
