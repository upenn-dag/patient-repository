<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Regiment\Builder;

use Accard\Component\Resource\Builder\AbstractBuilder;
use Accard\Component\Resource\Repository\RepositoryInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Regiment builder.
 *
 * Used to ease the programatic creation of regimens.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class RegimentBuilder extends AbstractBuilder implements RegimentBuilderInterface
{
    /**
     * Regiment repository.
     *
     * @var RepositoryInterface
     */
    protected $regimenRepository;

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
     * @param RepositoryInterface $regimenRepository
     */
    public function __construct(ObjectManager $manager,
                                RepositoryInterface $regimenRepository,
                                RepositoryInterface $fieldRepository,
                                RepositoryInterface $fieldValueRepository)
    {
        $this->manager = $manager;
        $this->regimenRepository = $regimenRepository;
        $this->fieldRepository = $fieldRepository;
        $this->fieldValueRepository = $fieldValueRepository;
    }

    public function getFieldRepository()
    {
        return $this->fieldRepository;
    }

    public function getFieldValueRepository()
    {
        return $this->fieldValueRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $this->resource = $this->regimenRepository->createNew();

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
        $fieldValue->setValue($value);

        $this->resource->addField($fieldValue);

        return $this;
    }
}
