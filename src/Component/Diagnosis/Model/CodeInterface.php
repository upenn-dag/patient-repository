<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Diagnosis\Model;

use Doctrine\Common\Collections\Collection;

/**
 * Code interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface CodeInterface
{
    /**
     * Get internal code id.
     *
     * @var integer
     */
    public function getId();

    /**
     * Set code.
     *
     * @param mixed $code
     * @return CodeInterface
     */
    public function setCode($code);

    /**
     * Get code.
     *
     * @return mixed
     */
    public function getCode();

    /**
     * Set description.
     *
     * @param string $description
     * @return CodeInterface
     */
    public function setDescription($description);

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription();

    /**
     * Get groups.
     *
     * @return Collection|CodeGroupInterfacep[]
     */
    public function getGroups();

    /**
     * Test for groups presence.
     *
     * @param CodeGroupInterface $group
     * @return CodeInterface
     */
    public function hasGroup(CodeGroupInterface $group);

    /**
     * Add group.
     *
     * @param CodeGroupInterface $group
     * @return CodeInterface
     */
    public function addGroup(CodeGroupInterface $group);

    /**
     * Remove group.
     *
     * @param CodeGroupInterface $group
     * @return CodeInterface
     */
    public function removeGroup(CodeGroupInterface $group);
}
