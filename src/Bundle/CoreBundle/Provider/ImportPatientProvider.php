<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\Provider;

use Accard\Component\Core\Model\ImportPatientInterface;
use Accard\Bundle\CoreBundle\Doctrine\ORM\ImportPatientRepository;

/**
 * Import patient provider.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ImportPatientProvider
{
    /**
     * Import patient repository.
     *
     * @var ImportPatientRepository
     */
    private $repository;

    /**
     * Constructor.
     *
     * @param ImportPatientRepository $repositry
     */
    public function __construct(ImportPatientRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get patient by MRN.
     *
     * @param string $mrn
     * @return ImportPatientInterface|null
     */
    public function getPatientByMRN($mrn)
    {
        return $this->repository->findOneByMrn($mrn);
    }
}
