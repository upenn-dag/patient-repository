<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\OutcomesBundle\Outcomes;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Accard\Bundle\OutcomesBundle\Exception\BaseDatasetFactoryException;

/**
 * Base dataset factory builder.
 *
 * @todo Remove container dependency, perhaps create a resolver to find the correct repositories.
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class BaseDatasetFactoryBuilder
{
    /**
     * Service container.
     *
     * @var ContainerInterface
     */
    private $container;

    /**
     * Constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Create a base dataset factory for a given target.
     *
     * @throws BaseDatasetFactoryException If repository can not be found for your target.
     * @param string $targetName
     * @return BaseDatasetFactory
     */
    public function create($targetName)
    {
        $targetRepository = sprintf("accard.repository.%s", $targetName);
        $prototypeRepository = sprintf("accard.repository.%s_prototype", $targetName);

        if (!$this->container->has($targetRepository)) {
            throw new BaseDatasetFactoryException(
                sprintf('There is no repository available for target "%s".', $targetName)
            );
        }

        $targetRepository = $this->container->get($targetRepository);

        if ($this->container->has($prototypeRepository)) {
            $prototypeRepository = $this->container->get($prototypeRepository);
        } else {
            $prototypeRepository = null;
        }

        return new BaseDatasetFactory($targetRepository, $prototypeRepository);
    }
}
