<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\SampleBundle\Import;

use DateTime;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Accard\Bundle\ResourceBundle\Import\ImporterInterface;

/**
 * Abstract sample importer.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
abstract class SampleImporter implements ImporterInterface
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

            if(is_null($value)) {
                return null;
            }
            
            return $resource->getByMRN($value);
        };


        $dateNormalizer = function (Options $options, $value) {
            return empty($value) ? null : new DateTime($value);
        };


        $resolver->setRequired(array('patient', 'activity_date'));

        $resolver->setAllowedTypes(array(
            'patient' => array('Accard\Component\Patient\Model\PatientInterface', 'null', 'string'),
            'activity_date' => array('DateTime', 'string'),
        ));

        $resolver->setNormalizers(array(
            'patient' => $patientNormalizer,
            'activity_date' => $dateNormalizer,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject()
    {
        return 'sample';
    }
}
