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
 * Immutable option provider.
 *
 * Creates an option provider that may not be altered. This is useful for
 * distributing a set of options programatically, at runtime, without storage.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ImmutableOptionProvider implements OptionProviderInterface
{
    /**
     * Options cache.
     *
     * @var OptionInterface[]
     */
    protected $options;

    /**
     * Constructor.
     *
     * @param OptionInterface[] $options
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function getOption($optionName)
    {
        if (!isset($this->options[$optionName])) {
            throw new OptionNotFoundException($optionName);
        }

        return $this->options[$optionName];
    }
}
