<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Option\Provider;

use Accard\Component\Option\Model\OptionInterface;
use Accard\Component\Option\Exception\OptionNotFoundException;

/**
 * Option provider interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface OptionProviderInterface
{
    /**
     * Get option.
     *
     * @param string $optionName
     * @return OptionInterface|null
     * @throws OptionNotFoundException When option can not be located.
     */
    public function getOption($optionName);
}
