<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Component\Core;

use Mockery;
use ReflectionObject;
use Codeception\TestCase\Test;

abstract class TestCase extends Test
{
    /**
     * @var ResourceInterface
     */
    protected $resource;

    /**
     * Abstract resource setup.
     *
     * @return null
     */
    abstract public function _setupResource();

    /**
     * {@inheritdoc}
     */
    public function _before()
    {
        $this->_setupResource();
    }

    /**
     * Base timestampable assertion.
     *
     * @param boolean $enforceTrait
     */
    public function assertResourceTimestampable($enforceTrait = false)
    {
        $class = $this->createResource();

        $this->assertAttributeInstanceOf('DateTime', 'createdAt', $this->resource, sprintf('%s constructor does not set createdAt time.', $class));
        $this->assertInstanceOf('DAG\Component\Resource\Model\TimestampableInterface', $this->resource);

        if ($enforceTrait) {
            $traits = class_uses($class);
            $this->assertContains('DAG\Component\Resource\Model\TimestampableTrait', $traits, sprintf('%s does not implement TimestampableTrait.', $class));
        }
    }

    /**
     * Base blameable assertion.
     *
     * @param boolean $enforceTrait
     */
    public function assertResourceBlameable($enforceTrait = false)
    {
        $class = $this->createResource();

        $this->assertAttributeSame(null, 'createdBy', $this->resource, sprintf('%s::$createBy is not null on creation.', $class));
        $this->assertInstanceOf('DAG\Component\Resource\Model\BlameableInterface', $this->resource);

        if ($enforceTrait) {
            $traits = class_uses($class);
            $this->assertContains('DAG\Component\Resource\Model\BlameableTrait', $traits, sprintf('%s does not implementBlameableTrait.', $class));
        }
    }

    /**
     * Base versionable assertion.
     *
     * @param boolean $enforceTrait
     */
    public function assertResourceVersionable($enforceTrait = false)
    {
        $class = $this->createResource();

        $this->assertAttributeSame(0, 'currentVersion', $this->resource, sprintf('%s::$currentVersion is not null on creation.', $class));
        $this->assertInstanceOf('DAG\Component\Resource\Model\VersionableInterface', $this->resource);

        if ($enforceTrait) {
            $traits = class_uses($class);
            $this->assertContains('DAG\Component\Resource\Model\VersionableTrait', $traits, sprintf('%s does not implement VersionableTrait.', $class));
        }
    }

    /**
     * Multiple resource collection assertion.
     *
     * This is used by cross referenced one to many relationships on Accard
     * models. It automates the test required, to save test suite developement
     * time.
     *
     * @param string $resource
     * @param string $pluralResource
     */
    protected function assertMultipleResourceCollect($resource, $pluralResource)
    {
        $class = $this->createResource();

        $reflObject = new ReflectionObject($this->resource);
        $namespace = $reflObject->getNamespaceName();

        $resource = strtolower($resource);
        $resourceUpper = ucfirst($resource);
        $pluralResource = strtolower($pluralResource);
        $pluralResourceUpper = ucfirst($pluralResource);
        $getter = sprintf('get%s', $pluralResourceUpper);
        $hasser = sprintf('has%s', $resourceUpper);
        $adder = sprintf('add%s', $resourceUpper);
        $remover = sprintf('remove%s', $resourceUpper);

        $this->checkProperty($pluralResource);
        $this->checkGetter($getter);
        $this->checkHasser($hasser);
        $this->checkAdder($adder);
        $this->checkRemover($remover);

        $reflHasser = $reflObject->getMethod($hasser);
        $reflHasserArgument = $reflHasser->getParameters()[0];

        $injectors = array(
            Mockery::mock($reflHasserArgument->getClass()->name)->shouldIgnoreMissing(),
            Mockery::mock($reflHasserArgument->getClass()->name)->shouldIgnoreMissing()
        );

        // Default hasser assertions.
        $this->assertFalse($this->resource->{$hasser}($injectors[0]));

        // Creation assertions.
        $this->assertAttributeInstanceOf('Doctrine\Common\Collections\Collection', $pluralResource, $this->resource, sprintf('%s::$%s collection is not initialized on creation.', $class, $pluralResource));
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $this->resource->{$getter}(), sprintf('%s::%s does not return a Doctrine collection.', $class, $getter));

        // Add and fluency assertions.
        $this->assertSame($this->resource, $this->resource->{$adder}($injectors[0]), sprintf('%s::%s is not fluent.', $class, $adder));
        $this->assertCount(1, $this->resource->{$getter}(), sprintf('%s::%s did not add %s when requested.', $class, $adder, $resource));

        // After add hasser assertions.
        $this->assertTrue($this->resource->{$hasser}($injectors[0]), sprintf('%s::%s unable to locate %s added previously.', $class, $hasser, $resource));

        // Remove and fluency assertions.
        $this->assertSame($this->resource, $this->resource->{$remover}($injectors[1]), sprintf('%s::%s is not fluent.', $class, $remover));
        $this->assertCount(1, $this->resource->{$getter}(), sprintf('%s::%s removed a previously set %s, but not the one requested.', $class, $remover, $resource));
        $this->resource->{$remover}($injectors[0]);
        $this->assertCount(0, $this->resource->{$getter}(), sprintf('%s::%s did not remove previously set %s.', $class, $remover, $resource));
    }

    /**
     * Resource collection assertion.
     *
     * Used by cross-referenced many to one relationships on Accard models.
     * Automates all test required by that association elminating a fair amount
     * of test development time.
     *
     * @param string $resource
     */
    protected function assertResourceCollect($resource)
    {
        $class = $this->createResource();

        $reflObject = new ReflectionObject($this->resource);
        $namespace = $reflObject->getNamespaceName();

        $resource = strtolower($resource);
        $resourceUpper = ucfirst($resource);
        $getter = sprintf('get%s', $resourceUpper);
        $setter = sprintf('set%s', $resourceUpper);
        $hasser = sprintf('has%s', $resourceUpper);

        $this->checkProperty($resource);
        $this->checkGetter($getter);
        $this->checkSetter($setter);
        $this->checkHasser($hasser);

        $reflSetter = $reflObject->getMethod($setter);
        $reflSetterArgument = $reflSetter->getParameters()[0];

        // Default hasser assertions.
        $this->assertFalse($this->resource->{$hasser}(), sprintf('%s::%s innacurately reports finding a %s.', $class, $hasser, $resource));

        // Creation assertions.
        $this->assertAttributeSame(null, $resource, $this->resource, sprintf('%s::$%s is not null on creation', $class, $resource));
        $this->assertSame(null, $this->resource->{$getter}(), sprintf('%s::$%s does not return null on creation.', $class, $getter));

        // Settable and fluency assertions.
        $injector = Mockery::mock($reflSetterArgument->getClass()->name);
        $this->assertSame($this->resource, $this->resource->{$setter}($injector), sprintf('%s::%s is not fluent.', $class, $setter));
        $this->assertSame($injector, $this->resource->{$getter}(), sprintf('%s::%s did not set %s.', $class, $setter, $resource));

        // After set hasser assertions.
        $this->assertTrue($this->resource->{$hasser}(), sprintf('%s::%s is unable to find a previously set %s.', $class, $hasser, $resource));

        // Nullable assertions (if applicable).
        if ($reflSetterArgument->allowsNull()) {
            $this->resource->{$setter}(null);
            $this->assertSame(null, $this->resource->{$getter}(), sprintf('%s::%s is not nullable', $class, $setter));
        }
    }

    private function checkGetter($getter)
    {
        if (!method_exists($this->resource, $getter)) {
            $this->fail(sprintf('Getter %s::%s does not exist.', get_class($this->resource), $getter));
        }
    }

    private function checkProperty($property)
    {
        if (!property_exists($this->resource, $property)) {
            $this->fail(sprintf('Property %s::$%s does not exist.', get_class($this->resource), $property));
        }
    }

    private function checkSetter($setter)
    {
        if (!method_exists($this->resource, $setter)) {
            $this->fail(sprintf('Setter %s::%s does not exist.', get_class($this->resource), $setter));
        }
    }

    private function checkHasser($hasser)
    {
        if (!method_exists($this->resource, $hasser)) {
            $this->fail(sprintf('Hasser %s::%s does not exist.', get_class($this->resource), $hasser));
        }
    }

    private function checkAdder($adder)
    {
        if (!method_exists($this->resource, $adder)) {
            $this->fail(sprintf('Adder %s::%s does not exist.', get_class($this->resource), $adder));
        }
    }

    private function checkRemover($remover)
    {
        if (!method_exists($this->resource, $remover)) {
            $this->fail(sprintf('Remover %s::%s does not exist.', get_class($this->resource), $remover));
        }
    }

    private function createResource()
    {
        if (!$this->resource) {
            $this->fail('Class::$resource must exist as a property for this test case.');
        }

        return get_class($this->resource);
    }

}
