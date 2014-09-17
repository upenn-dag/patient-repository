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
 * Option provider.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class OptionProvider extends ImmutableOptionProvider
{
    /**
     * Add option.
     *
     * @param OptionInterface $option
     */
    public function addOption(OptionInterface $option)
    {
        $this->options[$option->getName()] = $option;
    }

    /**
     * Remove option.
     *
     * @param string $optionName
     * @throws OptionNotFoundException When option can not be found.
     */
    public function removeOption($optionName)
    {
        if (!isset($this->options[$optionName])) {
            throw new OptionNotFoundException($optionName);
        }

        unset($this->options[$optionName]);
    }
}
