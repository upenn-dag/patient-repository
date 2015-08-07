<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle;

use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Accard app state object.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class AccardState extends ContainerAware
{
    private $registry;
    private $cachedState;
    private $completed = false;

    /**
     * Constructor.
     *
     * @param State\DecoratorRegistry $registry
     */
    public function __construct(State\DecoratorRegistry $registry)
    {
        $this->registry = $registry;
        $this->cachedState = new State\StateInstance();
    }

    /**
     * Get Accard state object.
     *
     * This will initialize and complete all state data prior to returning
     * the object instance.
     *
     * @return State\StateInstance
     */
    public function getState()
    {
        if (!$this->completed) {
            $objects = explode(',', 'patient,patient_phase,diagnosis,diagnosis_phase,activity,regimen,attribute,behavior,sample');

            // This will cache all output automatically.
            foreach ($objects as $object) {
                $this->createObjectState($object);
            }

            // Let's get all the options.
            $options = $this->get('dag.repository.option')->findAll();
            foreach ($options as $option) {
                $optState = $this->createOptionState();
                $optState
                    ->setId($option->getId())
                    ->setName($option->getName())
                    ->setPresentation($option->getPresentation())
                ;

                foreach ($option->getValues() as $optionValue) {
                    $optValueState = $this->createOptionValueState($optState);
                    $optValueState
                        ->setId($optionValue->getId())
                        ->setValue($optionValue->getValue())
                        ->setOrder($optionValue->getOrder())
                        ->setLocked($optionValue->isLocked())
                    ;
                    $optState->addValue($optValueState);
                }

                $this->cachedState->addOption($optState);
            }

            unset($options, $option, $optionValue);

            $this->completed = true;
        }

        return $this->cachedState;
    }

    /**
     * Create an object state.
     *
     * @param string $object
     */
    public function createObjectState($object)
    {
        if ($this->cachedState->hasObject($object)) {
            return $this->cachedState->getObject($object);
        }

        if (!$this->objectExists($object)) {
            throw new \InvalidArgumentException(sprintf('The object "%s" does not exist.', $object));
        }

        $metadata = $this->getObjectMetadata($object);
        $objectState = new State\ObjectState($object, $this);

        if ($this->registry->hasDecoratorFor($object)) {
            $decorator = $this->registry->getDecoratorFor($object);
            $objectState = new $decorator($objectState);
        }

        $objectState
            ->setFielded($this->isFielded($object))
            ->setPrototyped($this->isPrototyped($object))
            ->setClass($metadata->name)
        ;

        // Use metadata to build object.
        foreach ($metadata->fieldMappings as $fieldMapping) {
            $staticField = $this
                ->createObjectStaticFieldState($objectState)
                ->setName($fieldMapping['fieldName'])
                ->setPresentation($fieldMapping['fieldName'])
                ->setType($fieldMapping['type'])
                ->addExtra('primary', isset($fieldMapping['id']) ? $fieldMapping['id'] : false)
                ->addExtra('unique', isset($fieldMapping['unique']) ? $fieldMapping['unique'] : false)
                ->addExtra('nullable', isset($fieldMapping['nullable']) ? $fieldMapping['nullable'] : false)
                ->addExtra('length', isset($fieldMapping['length']) ? $fieldMapping['length'] : null);

            $objectState->addField($staticField);
        }

        $objectState->prepareObject($metadata);

        // Determine field linking...
        if ($objectState->isFielded()) {
            $fieldObject = $this->getFieldObjectKey($object);
            $fieldRepository = $this->getRepository($fieldObject);

            foreach ($fieldRepository->findAll() as $field) {
                $fieldState = $this
                    ->createObjectFieldState($objectState)
                    ->setName($field->getName())
                    ->setPresentation($field->getPresentation())
                    ->setType($field->getType())
                    ->setAllowMultiple($field->getAllowMultiple())
                    ->setAddable($field->isAddable())
                    ->setConfiguration($field->getConfiguration())
                    ->setOption($field->getOption() ? $field->getOption()->getId() : null);

                $objectState
                    ->prepareField($fieldState, $field)
                    ->addField($fieldState);
            }

            unset($fieldObject, $fieldRepository, $field);
        }

        // Determine prototype linking...
        if ($objectState->isPrototyped()) {
            $prototypeObject = $this->getPrototypeObjectKey($object);
            $prototypeRepository = $this->getRepository($prototypeObject);

            foreach ($prototypeRepository->findAll() as $prototype) {
                $prototypeState = $this
                    ->createObjectPrototypeState($prototype->getName(), $objectState)
                    ->setName($prototype->getName())
                    ->setPresentation($prototype->getPresentation())
                    ->setDescription($prototype->getDescription());

                foreach ($prototype->getFields() as $field) {
                    $prototypeState->addField($field->getName());
                }

                $objectState
                    ->preparePrototype($prototypeState, $prototype)
                    ->addPrototype($prototypeState);
            }
        }

        $this->cachedState->addObject($objectState);

        return $objectState;
    }

    /**
     * Create prototype object state.
     *
     * @param string $prototypeName
     * @param State\ObjectStateInterface $object
     * @return State\ObjectPrototypeState
     */
    public function createObjectPrototypeState($prototypeName, State\ObjectStateInterface $object)
    {
        return new State\ObjectPrototypeState($prototypeName, $object);
    }

    /**
     * Create field object state.
     *
     * @param State\ObjectStateInterface $object
     * @return State\ObjectFieldState
     */
    public function createObjectFieldState(State\ObjectStateInterface $object)
    {
        return new State\ObjectFieldState($object);
    }

    /**
     * Create state field object state.
     *
     * @param State\ObjectStateInterface $object
     * @return State\ObjectStaticFieldState
     */
    public function createObjectStaticFieldState(State\ObjectStateInterface $object)
    {
        return new State\ObjectStaticFieldState($object);
    }

    /**
     * Create option state.
     *
     * @return State\OptionState
     */
    public function createOptionState()
    {
        return new State\OptionState();
    }

    /**
     * Create option value state.
     *
     * @return State\OptionValueState
     */
    public function createOptionValueState(State\OptionStateInterface $option)
    {
        return new State\OptionValueState($option);
    }

    /**
     * Test if an object exists.
     *
     * @param string $object
     * @return boolean
     */
    public function objectExists($object)
    {
        return $this->hasParameter($this->getModelClassKey($object));
    }

    /**
     * Test if object is prototyped.
     *
     * @param string $object
     * @return boolean
     */
    public function isPrototyped($object)
    {
        $key = $this->getManagerKey($this->getPrototypeObjectKey($object));

        return $this->has($key);
    }

    /**
     * Test if object collects fields.
     *
     * @param string $object
     * @return boolean
     */
    public function isFielded($object)
    {
        $key = $this->getManagerKey($this->getFieldObjectKey($object));

        return $this->has($key);
    }

    /**
     * Get an objects' prototype key.
     *
     * @param string $object
     * @return string
     */
    public function getPrototypeObjectKey($object)
    {
        return sprintf('%s_prototype', $object);
    }

    /**
     * Get an objects' field key.
     *
     * @param string $object
     * @return string
     */
    public function getFieldObjectKey($object)
    {
        // Don't try and prototype if it already is...
        if ('_prototype' === substr($object, -10)) {
            return sprintf('%s_field', $object);
        }

        return sprintf('%s_field', $this->isPrototyped($object) ? $this->getPrototypeObjectKey($object) : $object);
    }

    /**
     * Get an objects' model class key.
     *
     * @param string $object
     * @return string
     */
    public function getModelClassKey($object)
    {
        return sprintf('accard.model.%s.class', $object);
    }

    /**
     * Get an objects model class FQCN.
     *
     * @param string $object
     * @return string
     */
    public function getModelClass($object)
    {
        return $this->getParameter($this->getModelClassKey($object));
    }

    /**
     * Create a new instance of a model class.
     *
     * @param string $object
     * @return mixed
     */
    public function createModel($object)
    {
        $class = $this->getModelClass($object);

        return new $class;
    }

    /**
     * Get an objects' object manager key.
     *
     * @param string $object
     * @return string
     */
    public function getManagerKey($object)
    {
        return sprintf('accard.manager.%s', $object);
    }

    /**
     * Get an objects' object manager.
     *
     * @param string $object
     * @return ObjectManager
     */
    public function getManager($object)
    {
        return $this->get($this->getManagerKey($object));
    }

    /**
     * Get an objects' repository key.
     *
     * @param string $object
     * @return string
     */
    public function getRepositoryKey($object)
    {
        return sprintf('accard.repository.%s', $object);
    }

    /**
     * Get an objects' repository.
     *
     * @param string $object
     * @return EntityRepository
     */
    public function getRepository($object)
    {
        return $this->get($this->getRepositoryKey($object));
    }


    // PRIVATE METHODS

    private function get($key)
    {
        return $this->container->get($key);
    }

    private function has($key)
    {
        return $this->container->has($key);
    }

    private function getParameter($key)
    {
        return $this->container->getParameter($key);
    }

    private function hasParameter($key)
    {
        return $this->container->hasParameter($key);
    }

    private function getObjectMetadata($object)
    {
        $manager = $this->getManager($object);

        return $manager->getMetadataFactory()->getMetadataFor($this->getModelClass($object));
    }
}
