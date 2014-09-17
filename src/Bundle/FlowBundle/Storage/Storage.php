<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\FlowBundle\Storage;

/**
 * Base storage class.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
abstract class Storage implements StorageInterface
{
    /**
     * Storage domain.
     *
     * @var string
     */
    protected $domain;

    /**
     * {@inheritdoc}
     */
    public function initialize($domain)
    {
        $this->domain = $domain;
    }
}
