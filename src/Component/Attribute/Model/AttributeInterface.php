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

use Doctrine\Common\Collections\Collection;
use Accard\Component\Prototype\Model\PrototypeSubjectInterface;
use Accard\Component\Field\Model\FieldSubjectInterface;
use Accard\Component\Resource\Model\ResourceInterface;

/**
 * Basic attribute interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface AttributeInterface extends PrototypeSubjectInterface,
                                     FieldSubjectInterface,
                                     ResourceInterface
{
    /**
     * Get attribute id.
     *
     * @return integer
     */
    public function getId();
}
