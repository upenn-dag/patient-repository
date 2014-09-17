<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\Import;

use Accard\Bundle\ImportBundle\Model\RecordInterface;
use Accard\Bundle\ImportBundle\Import\RecordConverter;

/**
 * Patient record converter interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PatientRecordConverter extends RecordConverter
{
    /**
     * {@inheritdoc}
     */
    public function convert(RecordInterface $record)
    {
        $data = $record->getData();
        $patient = $this->repository->createNew();

        $patient
            ->setMRN($data['mrn'])
            ->setFirstName($data['first_name'])
            ->setLastName($data['last_name'])
            ->setDateOfBirth($data['date_of_birth'])
        ;

        $data['date_of_death'] && $patient->setDateOfDeath($data['date_of_death']);
        $data['gender'] && $patient->setGender($data['gender']);

        return $patient;
    }
}
