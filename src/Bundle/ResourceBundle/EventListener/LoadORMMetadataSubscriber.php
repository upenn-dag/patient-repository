<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ResourceBundle\EventListener;

use LogicException;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\ORM\Events;
use Doctrine\ORM\Configuration;

/**
 * Doctrine listener used to manipulate mappings.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class LoadORMMetadataSubscriber implements EventSubscriber
{
    /**
     * Resource classes.
     *
     * @var array
     */
    protected $classes;

    /**
     * Resource inheritance.
     *
     * @var array
     */
    protected $inheritance;

    /**
     * Constructor
     *
     * @param array $classes
     * @param array $inheritance
     */
    public function __construct($classes, $inheritance)
    {
        $this->classes = $classes;
        $this->inheritance = $inheritance;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return array(
            Events::loadClassMetadata,
        );
    }

    /**
     * Load class metadata event listener.
     *
     * @param LoadClassMetadataEventArgs $eventArgs
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        /** @var ClassMetadata $metadata */
        $metadata = $eventArgs->getClassMetadata();
        $configuration = $eventArgs->getEntityManager()->getConfiguration();
        $table = $this->normalizeTableName($metadata->table['name']);
        $metadata->table['name'] = $table;

        $this->setSuperclassStatus($metadata);
        $this->setCustomRepositoryClasses($metadata);

        if (!$metadata->isMappedSuperclass) {
            $this->setAssociationMappings($metadata, $configuration);
            if ($hasInheritance = $this->hasInheritanceMappings($metadata)) {
                $this->setInheritanceMappings($hasInheritance, $metadata, $configuration);
            }
        } else {
            $this->unsetAssociationMappings($metadata);
        }
    }

    /**
     * Normalize table name for all databases.
     *
     * Note: This has been implemented because Oracle does not allow more than
     *       30 characters for a table name, and our dynamic tables tend to go
     *       well beyond that. This allows us to have the same table names across
     *       all environments.
     *
     * @param string $tableName
     * @return string
     */
    private function normalizeTableName($tableName)
    {
        if (30 < strlen($tableName)) {
            $tableName = str_replace(
                array('prototype', 'instance', 'field_value', 'field', 'attribute', 'behavior'),
                array('proto', 'inst', 'fldval', 'fld', 'attr', 'bhvr'),
                $tableName
            );
        }

        return substr($tableName, 0, 30);
    }

    /**
     * Conditionally set mapping superclass status.
     *
     * @param ClassMetadataInfo $metadata
     */
    private function setSuperclassStatus(ClassMetadataInfo $metadata)
    {
        foreach ($this->classes as $class) {
            if ($class['model'] === $metadata->getName()) {
                $metadata->isMappedSuperclass = false;
            }
        }
    }

    /**
     * Test for inheritance mappings for given metadata.
     *
     * @param ClassMetadataInfo $metadata
     * @return boolean
     */
    private function hasInheritanceMappings(ClassMetadataInfo $metadata)
    {
        $entityName = $metadata->getName();
        $hasMappings = false;

        foreach ($this->classes as $model => $class) {
            if ($class['model'] === $entityName && isset($class['children'])) {
                $hasMappings = $model;
            }
        }

        return $hasMappings;
    }

    /**
     * Set inheritance mapping for a given metadata.
     *
     * @throws LogicException When inheritance can not be found, but should be there.
     * @param string $model
     * @param ClassMetadataInfo $metadata
     * @param Configuration $configuration
     */
    private function setInheritanceMappings($model, ClassMetadataInfo $metadata, $configuration)
    {
        if (!isset($this->inheritance[$model])) {
            throw new LogicException('Model has been found to support inheritance, but has no inheritance found.');
        }

        $inheritance = $this->inheritance[$model];

        $metadata->setInheritanceType(ClassMetadata::INHERITANCE_TYPE_JOINED);
        $metadata->setDiscriminatorColumn(array(
            'name' => 'discriminator',
            'type' => 'string',
            'length' => 120,
        ));
        $metadata->setDiscriminatorMap($inheritance);
    }

    /**
     * Set custom repository from configuration.
     *
     * @param ClassMetadataInfo $metadata
     */
    private function setCustomRepositoryClasses(ClassMetadataInfo $metadata)
    {
        foreach ($this->classes as $class) {
            if ($class['model'] === $metadata->getName()) {
                if (array_key_exists('repository', $class)) {
                    $metadata->setCustomRepositoryClass($class['repository']);
                }
            }
        }
    }

    /**
     * Set inherited association mappings.
     *
     * @param ClassMetadataInfo $metadata
     * @param Configuration $configuration
     */
    private function setAssociationMappings(ClassMetadataInfo $metadata, $configuration)
    {
        foreach (class_parents($metadata->getName()) as $parent) {
            $parentMetadata = new ClassMetadata(
                $parent,
                $configuration->getNamingStrategy()
            );
            if (in_array($parent, $configuration->getMetadataDriverImpl()->getAllClassNames())) {
                $configuration->getMetadataDriverImpl()->loadMetadataForClass($parent, $parentMetadata);
                if ($parentMetadata->isMappedSuperclass) {
                    foreach ($parentMetadata->getAssociationMappings() as $key => $value) {
                        if ($this->hasRelation($value['type'])) {
                            $metadata->associationMappings[$key] = $value;
                        }
                    }
                }
            }
        }
    }

    /**
     * Remove inherited association mappings.
     *
     * @param ClassMetadataInfo $metadata
     */
    private function unsetAssociationMappings(ClassMetadataInfo $metadata)
    {
        foreach ($metadata->getAssociationMappings() as $key => $value) {
            if ($this->hasRelation($value['type'])) {
                unset($metadata->associationMappings[$key]);
            }
        }
    }

    /**
     * Test for presence of a relation.
     *
     * @param integer $type
     * @return boolean
     */
    private function hasRelation($type)
    {
        return in_array(
            $type,
            array(
                ClassMetadataInfo::MANY_TO_MANY,
                ClassMetadataInfo::ONE_TO_MANY,
                ClassMetadataInfo::ONE_TO_ONE
            ),
            true
        );
    }
}
