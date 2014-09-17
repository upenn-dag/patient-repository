<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Attribute\Builder;

use Accard\Component\Resource\Builder\AbstractBuilder;
use Accard\Component\Resource\Repository\RepositoryInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Attribute builder.
 *
 * Used to ease the programatic creation of attributes.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class AttributeBuilder extends AbstractBuilder implements AttributeBuilderInterface
{
    /**
     * Attribute repository.
     * 
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * Constructor.
     * 
     * @param ObjectManager $manager
     * @param RepositoryInterface $attributeRepository
     */
    public function __construct(ObjectManager $manager,
                                RepositoryInterface $attributeRepository)
    {
        $this->manager = $manager;
        $this->repository = $attributeRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $this->resource = $this->repository->createNew();

        return $this;
    }
    
}
