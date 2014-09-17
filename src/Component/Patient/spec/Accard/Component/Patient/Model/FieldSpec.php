<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace spec\Accard\Component\Patient\Model;

use PhpSpec\ObjectBehavior;

/**
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FieldSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Accard\Component\Patient\Model\Field');
    }

    function it_extends_Accard_attribute_model()
    {
        $this->shouldImplement('Accard\Component\Field\Model\Field');
    }

    function it_implements_Accard_product_attribute_interface()
    {
        $this->shouldImplement('Accard\Component\Patient\Model\FieldInterface');
    }
}