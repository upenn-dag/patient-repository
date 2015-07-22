<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ActivityBundle\Import;

use DateTime;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use DAG\Bundle\ResourceBundle\Import\ImporterInterface;

/**
 * Abstract activity importer.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
abstract class ActivityImporter implements ImporterInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureResolver(OptionsResolverInterface $resolver)
    {
        $patientNormalizer = function(Options $options, $value) {
            static $resource;

            if (!$resource) {
                $resource = $options['patient_resource']->getRepository();
            }

            return $resource->getByMRN($value);
        };

        $codes = $this->getCodes();
        $diagnosisNormalizer = function(Options $options, $value) use ($codes) {
            static $resource;

            if (!$resource) {
                $resource = $options['diagnosis_resource']->getRepository();
            }

            if ($patient = $options['patient']) {
                foreach ($patient->getDiagnoses() as $diagnosis) {
                    if (in_array($diagnosis->getCode()->getCode(), $codes)) {
                        return $diagnosis;
                    }
                }
            }
        };

        $dateNormalizer = function (Options $options, $value) {
            return empty($value) ? null : new DateTime($value);
        };


        $resolver->setRequired(array('patient', 'activity_date'));
        $resolver->setOptional(array('diagnosis'));

        $resolver->setAllowedTypes(array(
            'patient' => array('string'),
            'diagnosis' => array('Accard\Component\Diagnosis\Model\DiagnosisInterface', 'null'),
            'activity_date' => array('string', 'null'),
        ));

        $resolver->setNormalizers(array(
            'patient' => $patientNormalizer,
            'diagnosis' => $diagnosisNormalizer,
            'activity_date' => $dateNormalizer,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject()
    {
        return 'activity';
    }
}
