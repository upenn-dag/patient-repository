<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\WebBundle\Form\Typeahead;

use JsonSerializable;
use Symfony\Component\Form\FormView;

/**
 * Typeahead configuration
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class TypeaheadConfiguration
{
    /**
     * Form view.
     *
     * @var FormView
     */
    private $view;


    /**
     * Constructor.
     *
     * @param FormView $view
     */
    public function __construct(FormView $view)
    {
        $this->view = $view;
    }

    /**
     * Get view parameter.
     *
     * @param string $key
     * @return boolean
     */
    public function has($key)
    {
        return isset($this->view[$key]);
    }

    /**
     * Test for presence of view parameter.
     *
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        if ($this->hasParameter($key)) {
            return $this->view[$key];
        }
    }

    public function getPlaceholder()
    {
        return $this->get('placeholder');
    }

    public function getAllowClear()
    {
        return $this->get('required');
    }
}
