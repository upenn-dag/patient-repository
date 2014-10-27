<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\FieldBundle\EventListener;

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
     * Field subjects.
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
            if ($class['field_value']['model'] !== $metadata->getName()) {
                continue;
            }

            // We must rename the join table to make sure they are unique.
            $mapTable = sprintf($metadata->associationMappings['optionValues']['joinTable']['name'], $subject);

            if (30 < strlen($mapTable)) {
                $mapTable = str_replace(
                    array('prototype', 'instance', 'field_value', 'field', 'attribute', 'behavior', 'option'),
                    array('proto', 'inst', 'fldval', 'fld', 'attr', 'bhvr', 'opt'),
                    $mapTable
                );
            }
            $mapTable = substr($mapTable, 0, 30);
            $metadata->associationMappings['optionValues']['joinTable']['name'] = $mapTable;

            $subjectMapping = array(
                'fieldName'     => 'subject',
                'targetEntity'  => $class['subject'],
                'inversedBy'    => 'fields',
                'joinColumns'   => array(array(
                    'name'                 => $subject.'Id',
                    'referencedColumnName' => 'id',
                    'nullable'             => false,
                ))
            );

            $metadata->mapManyToOne($subjectMapping);

            $fieldMapping = array(
                'fieldName'     => 'field',
                'targetEntity'  => $class['field']['model'],
                //'inversedBy'    => 'fields',
                'joinColumns'   => array(array(
                    'name'                 => 'fieldId',
                    'referencedColumnName' => 'id',
                    'nullable'             => false,
                ))
            );

            $metadata->mapManyToOne($fieldMapping);
        }
    }
}
