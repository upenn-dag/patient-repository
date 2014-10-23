<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Activity\Provider;

use Accard\Component\Activity\Model\ActivityInterface;
use Accard\Component\Activity\Model\PrototypeInterface;
use Accard\Component\Activity\Repository\ActivityRepositoryInterface;
use Accard\Component\Prototype\Provider\PrototypeProviderInterface;
use Accard\Component\Activity\Exception\ActivityNotFoundException;

/**
 * Activity provider.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ActivityProvider implements ActivityProviderInterface
{
    /**
     * Activity repository.
     * 
     * @var ActivityRepositoryInterface
     */
    protected $activityRepository;

    /**
     * Activity prototype provider.
     * 
     * @var PrototypeProviderInterface
     */
    protected $prototypeProvider;


    /**
     * Constructor.
     * 
     * @param ActivityRepositoryInterface $activityRepository
     * @param PrototypeProviderInterface $prototypeProvider
     */
    public function __construct(ActivityRepositoryInterface $activityRepository,
                                PrototypeProviderInterface $prototypeProvider)
    {
        $this->activityRepository = $activityRepository;
        $this->prototypeProvider = $prototypeProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function getActivityModelClass()
    {
        return $this->activityRepository->getClassName();
    }

    /**
     * {@inheritdoc}
     */
    public function getPrototypeModelClass()
    {
        return $this->prototypeProvider->getPrototypeModelClass();
    }

    /**
     * {@inheritdoc}
     */
    public function hasActivity($activityId)
    {
        return (boolean) $this->activityRepository->find($activityId);
    }

    /**
     * {@inheritdoc}
     */
    public function getActivity($activityId)
    {
        if (!$this->hasActivity($activityId)) {
            throw new ActivityNotFoundException($activityId);
        }

        return $activity;
    }

    /**
     * {@inheritdoc}
     */
    public function hasPrototype($prototypeId)
    {
        return $this->prototypeProvider->hasPrototype($prototypeId);
    }

    /**
     * {@inheritdoc}
     */
    public function getPrototype($prototypeId)
    {
        return $this->prototypeProvider->getPrototype($prototypeId);
    }

    /**
     * {@inheritdoc}
     */
    public function hasPrototypeByName($prototypeName)
    {
        return $this->prototypeProvider->hasPrototypeByName($prototypeName);
    }

    /**
     * {@inheritdoc}
     */
    public function getPrototypeByName($prototypeName)
    {
        return $this->prototypeProvider->getPrototypeByName($prototypeName);
    }
}
