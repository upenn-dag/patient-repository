<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ResourceBundle\Import;

use ReflectionObject;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Record resolver.
 *
 * Responsible for retrieving a record for a given importer.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class RecordResolver
{
    private $resourceResolver;
    private $accessor;

    public function __construct(ResourceResolvingFactory $resourceResolver)
    {
        $this->resourceResolver = $resourceResolver;
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    public function getRecordForImport($subjectName, $id)
    {
        $target = $this->resourceResolver->resolveTarget($subjectName);

        return $target->getRepository()->find($id);
    }

    public function createRecordForImport($subjectName, $id)
    {
        $record = $this->getRecordForImport($subjectName, $id);

        if (!$record) {
            return;
        }

        $subject = $this->resourceResolver->resolveSubject($subjectName);
        $newRecord = $subject->getRepository()->createNew();
        $recordRefl = new ReflectionObject($record);
        $newRecordRefl = new ReflectionObject($newRecord);

        foreach ($recordRefl->getProperties() as $recordProperty) {
            $recordProperty->setAccessible(true);
            $name = $recordProperty->getName();
            $value = $recordProperty->getValue($record);

            if (null !== $value && $newRecordRefl->hasProperty($name) && $name !== 'id') {
                $this->accessor->setValue($newRecord, $name, $value);
            }
        }

        $newRecord->setImportTarget($record);

        return $newRecord;
    }
}
