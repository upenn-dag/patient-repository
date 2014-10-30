<?php
/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\DiagnosisBundle\Doctrine\ORM;

use Accard\Component\Diagnosis\Repository\CodeRepositoryInterface;
use Accard\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 * Basic diagnosis code repository.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class CodeRepository extends EntityRepository implements CodeRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'diagnosis_code';
    }

    /**
     * Get diagnosis code count.
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->getQueryBuilder()->select('COUNT(diagnosis_code.id)')->getQuery()->getSingleScalarResult();
    }

}
