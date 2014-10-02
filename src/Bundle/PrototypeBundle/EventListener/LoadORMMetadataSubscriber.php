<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\PrototypeBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;

/**
 * Doctrine listener used to manipulate mappings.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class LoadORMMetadataSubscriber implements EventSubscriber
{
    /**
     * Prototype subjects.
     *
     * @var array
     */
    protected $subjects;


    /**
     * Constructor.
     *
     * @param array $subjects
     */
    public function __construct(array $subjects)
    {
        $this->subjects = $subjects;
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            Events::loadClassMetadata,
        );
    }

    /**
     * @param LoadClassMetadataEventArgs $eventArgs
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $args)
    {
        $metadata = $args->getClassMetadata();

        foreach ($this->subjects as $subject => $class) {
            if ($class['subject'] !== $metadata->getName()) {
                continue;
            }

            $subjectMapping = array(
                'fieldName'     => 'prototype',
                'targetEntity'  => $class['prototype']['model'],
                'inversedBy'    => 'subjects',
                'joinColumns'   => array(array(
                    'name'                 => 'prototypeId',
                    'referencedColumnName' => 'id',
                    'nullable'             => false,
                    'onDelete'             => 'CASCADE'
                ))
            );

            $metadata->mapManyToOne($subjectMapping);
        }

        foreach ($this->subjects as $subject => $class) {
            if ($class['prototype']['model'] !== $metadata->getName()) {
                continue;
            }

            $prototypeMapping = array(
                'fieldName'     => 'subjects',
                'targetEntity'  => $class['subject'],
                'mappedBy'      => 'prototype',
            );

            $metadata->mapOneToMany($prototypeMapping);

            $fieldMapping = array(
                'fieldName' => 'fields',
                'targetEntity' => $class['field']['model'],
                'cascade' => array("persist"),
                'joinTable' => array(
                    'name' => sprintf('accard_%s_prototype_map', $subject),
                    'joinColumns' => array(array(
                        'name' => 'prototypeId',
                        'referencedColumnName' => 'id',
                        'nullable' => false,
                    )),
                    'inverseJoinColumns' => array(array(
                        'name' => 'subjectId',
                        'referencedColumnName' => 'id',
                        'nullable' => false,
                    ))
                ),
            );

            $metadata->mapManyToMany($fieldMapping);
        }

    }
}
