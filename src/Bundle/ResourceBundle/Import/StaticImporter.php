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

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Accard\Bundle\PatientBundle\Import\PatientImporter;

/**
 * Static patient importer (for testing only).
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class StaticImporter extends PatientImporter
{
    /**
     * {@inheritdoc}
     */
    public function run(OptionsResolverInterface $resolver, array $criteria)
    {
        return array(
            $resolver->resolve(array(
                'mrn' => '000000001',
                'first_name' => 'Frank',
                'last_name' => 'Bardon',
                'date_of_birth' => '08/06/1984',
                'gender' => 'Male',
                'import_description' => 'Imported'
            )),
            $resolver->resolve(array(
                'mrn' => '000000002',
                'first_name' => 'Morraine',
                'last_name' => 'Sedai',
                'date_of_birth' => '04/06/1963',
                'gender' => 'Female',
                'import_description' => 'Imported'
            ))
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getCriteria(array $history)
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultCriteria()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'static';
    }
}
