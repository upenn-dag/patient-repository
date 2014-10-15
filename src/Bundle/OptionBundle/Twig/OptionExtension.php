<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\OptionBundle\Twig;

use Twig_Extension;
use Twig_SimpleFunction;
use Accard\Bundle\OptionBundle\Templating\Helper\OptionHelper;
use Accard\Component\Option\Model\OptionInterface;

/**
 * Accard option Twig extension.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class OptionExtension extends Twig_Extension
{
    /**
     * Option templating helper.
     *
     * @var OptionHelper
     */
    private $helper;


    /**
     * Constructor.
     *
     * @param OptionHelper $helper
     */
    public function __construct(OptionHelper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('accard_option', array($this, 'getOption')),
        );
    }

    /**
     * Get all option within a namespace.
     *
     * @param string $optionName
     * @return OptionInterface
     */
    public function getOption($optionName)
    {
        return $this->helper->getOptionByName($optionName);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'accard_option';
    }
}
