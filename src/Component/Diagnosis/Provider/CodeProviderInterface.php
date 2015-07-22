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
use DAG\Component\Resource\Provider\ProviderInterface;
use Accard\Component\Diagnosis\Exception\CodeNotFoundException;
use Accard\Component\Diagnosis\Model\CodeInterface;

/**
 * Code provider interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface CodeProviderInterface extends ProviderInterface
{
    /**
     * Get model class FQCN.
     *
     * @return string
     */
    public function getModelClass();

    /**
     * Get all codes.
     *
     * @return Collection|CodeInterface[]
     */
    public function getAllCodes();

    /**
     * Get code.
     *
     * @throws CodeNotFoundException If code can not be located.
     * @param integer $codeId
     * @return CodeInterface
     */
    public function getCode($codeId);

    /**
     * Get code by code.
     *
     * @throws CodeNotFoundException If code can not be located.
     * @param string $codeString
     * @return CodeInterface
     */
    public function getCodeByCode($codeString);
}
