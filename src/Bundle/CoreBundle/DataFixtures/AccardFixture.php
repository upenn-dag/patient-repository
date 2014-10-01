<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Base Accard fixture.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
abstract class AccardFixture extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * Symfony container.
     *
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Fixture manager.
     *
     * @var FixtureManagerInterface
     */
    protected $fixtureManager;


    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->fixtureManager = $container->get('accard.fixture.manager');
        $this->fixtureManager->setContainer($container);
    }

    /**
     * {@inheritDoc}
     */
    final public function load(ObjectManager $manager)
    {
        $this->setup($manager);
        $this->doLoad();
        $this->teardown();
    }

    /**
     * Perform fixture load.
     */
    abstract public function doLoad();

    /**
     * Setup fixture state.
     *
     * @param ObjectManager $manager
     */
    public function setup(ObjectManager $manager)
    {
        $this->fixtureManager->setObjectManager($manager);
    }

    /**
     * Teardown fixture state.
     */
    public function teardown()
    {
        $this->fixtureManager->setObjectManager(null);
    }

    /**
     * Get the Symfony service container.
     *
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 0;
    }
}
