<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\PatientBundle\Import;

use DateTime;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Accard\Bundle\ResourceBundle\Import\ImporterInterface;

/**
 * Abstract patient importer.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
abstract class PatientImporter implements ImporterInterface
{
	/**
	 * {@inheritdoc}
	 */
    public function configureResolver(OptionsResolverInterface $resolver)
    {
        $genderNormalizer = function(Options $options, $value) {
            static $genderValues;

            if (null === $genderValues) {
                $resource = $options['option_resource']->getRepository();
                $genderValues = $resource->findOneByName('gender')->getValues();
            }

            $value = substr(trim(strtolower($value)), 0, 1);

            if (empty($value)) {
                $value = 'u';
            }

            foreach ($genderValues as $genderValue) {
                if (substr(strtolower($genderValue->getValue()), 0, 1) === $value) {
                    return $genderValue;
                }
            }

            return $genderValues->last();
        };

        $dateNormalizer = function (Options $options, $value) {
            return empty($value) ? null : new DateTime($value);
        };

        $nameNormalizer = function (Options $options, $value) {
            $value = preg_replace("#[[:punct:]]#", "", $value);

            return ucwords(strtolower(trim($value)));
        };


        $resolver->setRequired(array('mrn', 'first_name', 'last_name', 'date_of_birth'));
        $resolver->setOptional(array('date_of_death', 'gender', 'race'));

        $resolver->setDefaults(array(
            'gender' => 'unknown',
        ));

        $resolver->setAllowedTypes(array(
            'first_name' => 'string',
            'last_name' => 'string',
            'date_of_birth' => array('DateTime'),
            'date_of_death' => array('DateTime', 'null'),
            'gender' => array('Accard\Component\Option\Model\OptionValueInterface'),
            'race' => array('string', 'null'),
        ));

        $resolver->setNormalizers(array(
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
    public function getSubject()
    {
        return 'patient';
    }
}
