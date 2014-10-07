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

use Accard\Component\Prototype\Exception\PrototypeNotFoundException;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Accard fixture manager.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class FixtureManager implements FixtureManagerInterface, ContainerAwareInterface
{
    /**
     * Symfony container.
     *
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Object manager.
     *
     * @var ObjectManager
     */
    public $objectManager;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function setObjectManager(ObjectManager $manager = null)
    {
        $this->objectManager = $manager;
    }

    /**
     * Create prototype builder.
     *
     * @param string $subject
     * @param string $name
     * @param string $presentation
     *
     * @return PrototypeBuilder $prototypeBuilder
     */
    public function createPrototype($subject, $name = null, $presentation = null)
    {
        $prototypeBuilder = new Builder\PrototypeBuilder($subject, $this);

        $name && $prototypeBuilder->setName($name);
        $presentation && $prototypeBuilder->setPresentation($presentation);

        return $prototypeBuilder;
    }

    /**
     * Test for presence of prototype in storage.
     *
     * @param string $subject
     * @param string $name
     *
     * @return boolean
     */
    public function hasPrototype($subject, $name)
    {
        $provider = $this->container->get(sprintf('accard.provider.%s_prototype', $subject));

        return $provider->hasPrototypeByName($name);
    }

    /**
     * Get prototype from storage.
     *
     * @throws PrototypeNotFoundException If prototype does not exist.
     * @param string $subject
     * @param string $name
     *
     * @return PrototypeBuilder
     */
    public function getPrototype($subject, $name)
    {
        $provider = $this->container->get(sprintf('accard.provider.%s_prototype', $subject));
        $prototype = $provider->getPrototypeByName($name);

        return new Builder\PrototypeBuilder($subject, $this, $prototype);
    }

    /**
     * Get prototype from storage or create it.
     *
     * @param string $subject
     * @param string $name
     * @param string|null $presentation
     * @return PrototypeBuilder
     */
    public function getOrCreatePrototype($subject, $name, $presentation = null)
    {
        if ($this->hasPrototype($subject, $name)) {
            return $this->getPrototype($subject, $name);
        }

        return $this->createPrototype($subject, $name, $presentation);
    }

    /**
     * Create field builder.
     *
     * @param string $subject
     * @param string $name
     * @param string $presentation
     *
     * @return FieldBuilder $fieldBuilder
     */
    public function createField($subject, $name, $presentation, $type)
    {
        $fieldBuilder = new Builder\FieldBuilder($subject, $this);
        $fieldBuilder->setName($name);
        $fieldBuilder->setPresentation($presentation);
        $fieldBuilder->setType($type);

        return $fieldBuilder;
    }

    /**
     * Test for presence of field in storage.
     *
     * @param string $subject
     * @param string $name
     *
     * @return boolean
     */
    public function hasField($subject, $name)
    {
        $provider = $this->container->get(sprintf('accard.repository.%s_field', $subject));

        return (boolean) $provider->findOneByName($name);
    }

    /**
     * Get field from storage.
     *
     * @throws FieldNotFoundException If field does not exist.
     * @param string $subject
     * @param string $name
     *
     * @return FieldBuilder
     */
    public function getField($subject, $name)
    {
        $provider = $this->container->get(sprintf('accard.provider.%s_field', $subject));
        $field = $provider->getFieldByName($name);

        return new Builder\FieldBuilder($subject, $this, $field);
    }

    /**
     * Get field from storage or create it.
     *
     * @param string $subject
     * @param string $name
     * @param string|null $presentation
     * @return FieldBuilder
     */
    public function getOrCreateField($subject, $name, $presentation = null)
    {
        if ($this->hasField($subject, $name)) {
            return $this->getField($subject, $name);
        }

        return $this->createField($subject, $name, $presentation);
    }

    /**
     * Create option builder.
     *
     * @param string $name
     * @param string $presentation
     *
     * @return OptionBuilder $optionBuilder
     */
    public function createOption($name, $presentation)
    {
        $optionBuilder = new Builder\OptionBuilder($this);
        $optionBuilder->setName($name);
        $optionBuilder->setPresentation($presentation);

        return $optionBuilder;
    }

    /**
     * Test for presence of option in storage.
     *
     * @param string $subject
     * @param string $name
     *
     * @return boolean
     */
    public function hasOption($name)
    {
        $provider = $this->container->get(sprintf('accard.provider.option'));

        return $provider->hasOptionByName($name);
    }

    /**
     * Get option from storage.
     *
     * @throws OptionNotFoundException If option does not exist.
     * @param string $subject
     * @param string $name
     *
     * @return OptionBuilder
     */
    public function getOption($name)
    {
        $provider = $this->container->get(sprintf('accard.provider.option'));
        $option = $provider->getOptionByName($name);

        return new Builder\OptionBuilder($this, $option);
    }

    /**
     * Test for presence of option value in storage.
     *
     * @param string $subject
     * @param string $name
     *
     * @return boolean
     */
    public function hasOptionValue($name)
    {
        $provider = $this->container->get(sprintf('accard.provider.optionvalue'));

        return $provider->hasOptionValueByName($name);
    }

    /**
     * Get option value from storage.
     *
     * @throws OptionNotFoundException If option does not exist.
     * @param string $subject
     * @param string $name
     *
     * @return OptionBuilder
     */
    public function getOptionValue($name)
    {
        $provider = $this->container->get(sprintf('accard.provider.optionvalue'));
        $option = $provider->getOptionValueByName($name);

        return $option;
    }

    /**
     * {@inheritDoc}
     */
    public function resolveClassFromParameter($parameter)
    {
        return $this->container->getParameter($parameter);
    }
}
