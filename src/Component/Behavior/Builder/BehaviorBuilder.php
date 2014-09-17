<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Behavior\Builder;

use Accard\Component\Resource\Builder\AbstractBuilder;
use Accard\Component\Resource\Repository\RepositoryInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Behavior builder.
 *
 * Used to ease the programatic creation of behaviors.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class BehaviorBuilder extends AbstractBuilder implements BehaviorBuilderInterface
{
    /**
     * Behavior repository.
     * 
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * Constructor.
     * 
     * @param ObjectManager $manager
     * @param RepositoryInterface $behaviorRepository
     */
    public function __construct(ObjectManager $manager,
                                RepositoryInterface $behaviorRepository)
    {
        $this->manager = $manager;
        $this->repository = $behaviorRepository;
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
