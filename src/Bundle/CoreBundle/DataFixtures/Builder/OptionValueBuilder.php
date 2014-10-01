<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\DataFixtures\Builder;

use Accard\Bundle\CoreBundle\DataFixtures\FixtureManagerInterface;
use Accard\Component\Option\Model\OptionValue;

/**
 * Option Value Builder fixture.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class OptionValueBuilder
{
    /**
     * OptionValue
     * 
     * @var OptionValue
     */
    private $optionValue;

    /**
     * FixtureManager
     * 
     * @var FixtureManager
     */
    private $fixtureManager;

    /**
     * Context
     * 
     * @var OptionBuilder
     */
    private $context;


    public function __construct(FixtureManagerInterface $fixtureManager,
                                OptionBuilder $optionBuilder)
    {
        $this->fixtureManager = $fixtureManager;
        $this->context = $optionBuilder;
        $this->optionValue = new OptionValue;
    }

    /**
     * Get option value.
     * 
     * @return OptionValue
     */
    public function getOptionValue()
    {
        return $this->optionValue;
    }

    /**
     * Set option value.
     * 
     * @param OptionValue $value
     */
    public function setValue($value)
    {
        $this->optionValue->setValue($value);

        return $this;
    }

    /**
     * End.
     * 
     * @return OptionBuilder | OptionValueBuilder
     */
    public function end()
    {
        return $this->context ?: $this;
    }
}