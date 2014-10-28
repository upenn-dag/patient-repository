<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Diagnosis\Provider;

use Doctrine\Common\Collections\Collection;
use Accard\Component\Resource\Provider\ProviderInterface;
use Accard\Component\Diagnosis\Exception\CodeGroupNotFoundException;
use Accard\Component\Diagnosis\Model\CodeGroupInterface;

/**
 * CodeGroup provider interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface CodeGroupProviderInterface extends ProviderInterface
{
    /**
     * Get model class FQCN.
     *
     * @return string
     */
    public function getModelClass();

    /**
     * Get all code groups.
     *
     * @return Collection|CodeGroupInterface[]
     */
    public function getAllGroups();

    /**
     * Get code group by id.
     *
     * @throws CodeGroupNotFoundException If code can not be located.
     * @param integer $groupId
     * @return CodeGroupInterface
     */
    public function getGroup($groupId);

    /**
     * Get code group by name.
     *
     * @throws CodeGroupNotFoundException If code can not be located.
     * @param string $groupName
     * @return CodeGroupInterface
     */
    public function getGroupByName($groupName);
}
