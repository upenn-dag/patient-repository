<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\PrototypeBundle\Doctrine\ORM;

use Accard\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Accard\Component\Prototype\Repository\PrototypeRepositoryInterface;

/**
 * Prototype repository.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PrototypeRepository extends EntityRepository implements PrototypeRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        return $this->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function getPrototype($prototypeId)
    {
        return $this->find($prototypeId);
    }

    /**
     * {@inheritdoc}
     */
    public function getPrototypeByName($prototypeName)
    {
        return $this->findOneBy(array('name' => $prototypeName));
    }

    /**
     * {@inheritdoc}
     */
    protected function getAlias()
    {
        return 'prototype';
    }
}
