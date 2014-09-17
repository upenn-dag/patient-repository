<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Attribute\Model;

/**
 * Basic attribute interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface AttributeInterface
{
    /**
     * Get attribute id.
     *
     * @return integer
     */
    public function getId();
}
