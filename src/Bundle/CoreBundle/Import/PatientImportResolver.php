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

use DateTime;
use Accard\Bundle\ImportBundle\Import\ImporterResolver;
use Accard\Bundle\ImportBundle\Model\RecordInterface;
use Symfony\Component\OptionsResolver\Options;

/**
 * Patient import resolver.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PatientImportResolver extends ImporterResolver
{
    /**
     * {@inheritdoc}
     */
    public function build()
    {
        $genderNormalizer = function(Options $options, $value) {
            $value = trim(strtolower($value));
            switch ($value) {
                case 'm': case 'male': case 'ml':
                    return 'male';
                    break;
                case 'f': case 'female': case 'fml':
                    return 'female';
                    break;
                case 'u': case 'unk': case 'unknown':
                    return 'unknown';
                    break;
            }
        };

        $stringNormalizer = function (Options $options, $value) {
            return trim($value);
        };

        $dateNormalizer = function (Options $options, $value) {
            return new DateTime($value);
        };

        $nameNormalizer = function (Options $options, $value) {
            $value = preg_replace("#[[:punct:]]#", "", $value);

            return ucwords(strtolower($value));
        };


        $this->setRequired(array('first_name', 'last_name', 'mrn', 'date_of_birth', 'gender'));
        $this->setOptional(array('date_of_death', 'medications', 'diagnoses', 'tests', 'race'));

        $this->setAllowedTypes(array(
            'first_name' => 'string',
            'last_name' => 'string',
            'date_of_birth' => array('DateTime'),
            'race' => 'string',
            'medications' => 'array',
            'tests' => 'array',
        ));

        $this->setAllowedValues(array(
            'gender' => array('male', 'female', 'unknown')
        ));

        $this->setNormalizers(array(
            'first_name' => $nameNormalizer,
            'last_name' => $nameNormalizer,
            'gender' => $genderNormalizer,
            'date_of_birth' => $dateNormalizer,
            'date_of_death' => $dateNormalizer,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function createUniqueValue(RecordInterface $record)
    {
        return 'patient-' . $record->getDatum('mrn');
    }
}
