<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Diagnosis\Builder;

use DAG\Component\Resource\Builder\AbstractBuilder;
use DAG\Component\Resource\Repository\RepositoryInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Diagnosis builder.
 *
 * Used to ease the programatic creation of diagnoses.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class DiagnosisBuilder extends AbstractBuilder implements DiagnosisBuilderInterface
{
    /**
     * Diagnosis repository.
     *
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * Field repository.
     *
     * @var RepositoryInterface
     */
    protected $fieldRepository;

    /**
     * Field value repository.
     *
     * @var RepositoryInterface
     */
    protected $fieldValueRepository;

    /**
     * Constructor.
     *
     * @param ObjectManager $manager
     * @param RepositoryInterface $diagnosisRepository
     */
    public function __construct(
        ObjectManager $manager,
        RepositoryInterface $diagnosisRepository,
        RepositoryInterface $fieldRepository,
        RepositoryInterface $fieldValueRepository
    ) {
        $this->manager = $manager;
        $this->repository = $diagnosisRepository;
        $this->fieldRepository = $fieldRepository;
        $this->fieldValueRepository = $fieldValueRepository;
        ;
    }

    /**
     * Get diagnosis repository.
     *
     * @return RepositoryInterface
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Get diagnosis field repository.
     *
     * @return RepositoryInterface
     */
    public function getFieldRepository()
    {
        return $this->fieldRepository;
    }

    /**
     * Get diagnosis field value repository.
     *
     * @return RepositoryInterface
     */
    public function getFieldValueRepository()
    {
        return $this->fieldValueRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $this->resource = $this->repository->createNew();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addField($name, $value, $presentation = null)
    {
        $field = $this->fieldRepository->findOneBy(array('name' => $name));

        if (null === $field) {
            $field = $this->fieldRepository->createNew();
            $field->setName($name);
            $field->setPresentation($presentation ?: $name);

            $this->manager->persist($field);
            $this->manager->flush($field);
        }

        $fieldValue = $this->fieldValueRepository->createNew();
        $fieldValue->setField($field);

        //$fieldValue->setValue($value);

        $this->resource->addField($fieldValue);

        return $this;
    }
}
