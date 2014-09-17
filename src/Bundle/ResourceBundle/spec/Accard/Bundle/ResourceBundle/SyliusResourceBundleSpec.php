<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace spec\Accard\Bundle\ResourceBundle;

use PhpSpec\ObjectBehavior;

/**
 * Accard resource bundle spec.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class AccardResourceBundleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Accard\Bundle\ResourceBundle\AccardResourceBundle');
    }

    function it_is_a_bundle()
    {
        $this->shouldHaveType('Symfony\Component\HttpKernel\Bundle\Bundle');
    }
}
