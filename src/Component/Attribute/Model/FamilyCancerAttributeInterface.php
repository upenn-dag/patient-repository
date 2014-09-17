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
 * Basic family cancer attribute interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
interface FamilyCancerAttributeInterface extends AttributeInterface
{
    /**
     * Get family member.
     * 
     * @return string
     */
    public function getFamilyMember();

    /**
    * Set family member.
    * 
    * @param string $familyMember
    * @return FamilyCancerAttributeInterface
    */
    public function setFamilyMember($familyMember);


    /**
     * Get side of family.
     * 
     * @return boolean
     */
    public function getSide();

    /**
    * Set side of family.
    * 
    * @param string $side
    * @return FamilyCancerAttributeInterface
    */
    public function setSide($side);
}
