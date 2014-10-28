<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Field\Provider;

use Accard\Component\Field\Repository\FieldRepositoryInterface;
use Accard\Component\Field\Exception\FieldNotFoundException;

/**
 * Field provider.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FieldProvider implements FieldProviderInterface
{
    /**
     * Repository.
     *
     * @var FieldRepositoryInterface
     */
    protected $repository;

    /**
     * Constructor.
     *
     * @param FieldRepositoryInterface $repository
     */
    public function __construct(FieldRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function getFields()
    {
        return $this->repository->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldModelClass()
    {
        return $this->repository->getClassName();
    }

    /**
     * {@inheritdoc}
     */
    public function hasField($fieldId)
    {
        try {
            $this->getField($fieldId);

            return true;
        } catch (FieldNotFoundException $e) {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getField($fieldId)
    {
        if (!$field = $this->repository->find($fieldId)) {
            throw new FieldNotFoundException($fieldId);
        }

        return $field;
    }

    /**
     * {@inheritdoc}
     */
    public function hasFieldByName($fieldName)
    {
        try {
            $this->getFieldByName($fieldName);

            return true;
        } catch (FieldNotFoundException $e) {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldByName($fieldName)
    {
        if (!$field = $this->repository->findOneByName($fieldName)) {
            throw new FieldNotFoundException($fieldName);
        }

        return $field;
    }
}
