<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ResourceBundle\ExpressionLanguage;

/**
 * Expression language extension interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface ExtensionInterface
{
    /**
     * Get functions.
     *
     * @return array
     */
    public function getFunctions();

    /**
     * Get values used in functions.
     *
     * @return array
     */
    public function getValues();
}
