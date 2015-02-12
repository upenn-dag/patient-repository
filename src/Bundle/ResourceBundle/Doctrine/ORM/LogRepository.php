<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ResourceBundle\Doctrine\ORM;

use Accard\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Accard\Component\Resource\Model\UserInterface;

/**
 * Log repository.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class LogRepository extends EntityRepository
{
    /**
     * Get user log query builder.
     *
     * @param UserInterface $user
     * @return QueryBuilder
     */
    public function getUserLogBuilder(UserInterface $user)
    {
        return $this->getQueryBuilder()
            ->filterByColumn('log.user', $user)
            ->orderBy('log.logDate', 'DESC');
    }

	/**
	 * {@inheritdoc}
	 */
	public function getAlias()
	{
		return 'log';
	}
}
