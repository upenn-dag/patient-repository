<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ResourceBundle\EventListener;

use Doctrine\DBAL\Event\Listeners\OracleSessionInit as BaseOracleSessionInit;
use Doctrine\DBAL\Event\ConnectionEventArgs;
use Doctrine\DBAL\Platforms\OraclePlatform;

/**
 * Oracle automatic session initializer.
 *
 * Wraps the default Doctrine Oracle session initializer even to support auto-
 * initialization ONLY IF the database type is oci8 or pdo_oci.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class OracleSessionInit extends BaseOracleSessionInit
{
    /**
     * {@inheritdoc}
     */
    public function postConnect(ConnectionEventArgs $args)
    {
        if ($args->getDatabasePlatform() instanceof OraclePlatform) {
            parent::postConnect($args);
        }
    }
}
