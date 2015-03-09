<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\RIDICBundle\Import;

use PDO;
use DateTime;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Accard\Bundle\SampleBundle\Import\SampleImporter;
use Accard\Bundle\ResourceBundle\Import\ImporterInterface;
use Accard\Bundle\CoreBundle\Provider\ImportPatientProvider;
use Accard\Bundle\ResourceBundle\Import\SourceAdapterInterface;
use Accard\Bundle\ResourceBundle\Import\CriteriaInterface;

/**
 *  RIDIC \ Import \ RIDIC Importer
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class RIDICImporter extends SampleImporter
{
    /**
     * Patient provider.
     *
     * @var ImportPatientProvider
     */
    private $provider;

    /**
     * RIDIC source.
     *
     * @var SourceAdapterInterface
     */
    private $ridicSource;

    /**
     * Local source.
     *
     * @var SourceAdapterInterface
     */
    private $localSource;

    /**
     * Constructor.
     *
     * @var ImportPatientProvider
     * @var SourceAdapterInterface
     */
    public function __construct(ImportPatientProvider $provider,
    							SourceAdapterInterface $ridicSource,
                                SourceAdapterInterface $localSource)
    {
        $this->provider = $provider;
        $this->ridicSource = $ridicSource;
        $this->localSource = $localSource;
    }

    /**
     * {@inheritdoc}
     */
    public function run(OptionsResolverInterface $resolver)
    {
        $records = array();
        $localRecords = $this->localSource->execute();
        $results = $this->ridicSource->execute();


        foreach($results as $key => $result) {
            $result = array_change_key_case($result, CASE_LOWER);
            $mrn = $result['patient'];

            try {
                $result['previous_record'] = $this->provider->getPatientByMRN($mrn);
            } catch (PatientNotFoundException $e) {
                unset($result, $results[$key]);
                continue;
            }

            $record['identifier'] = $result['course_serv'];
            $result['import_description'] = sprintf('%s genetic results on the %s.', $result['cpd_id'], $result['patient']);

            $record = $resolver->resolve($result);

            if($record['patient'] && $record['genetic_test_version_id'] == '2' && !in_array($record['pk_id'], $localRecords)) {
                $records[] = $record;
            }

            unset($results[$key]);
        }

        unset($cachedMrns, $localRecords);

        return $records;
    }

    /**
     * {@inheritdoc}
     */
    public function configureResolver(OptionsResolverInterface $resolver)
    {
        parent::configureResolver($resolver);

        $mutations = array('substitution', 'deletion', 'missense', 'frameshift', 'deletion/insertion', 'insertion', 'duplication');

        $resolver->setRequired(array(

        ));

        $resolver->setOptional(array(

        ));

        $resolver->setAllowedTypes(array(

        ));

        $resolver->setAllowedValues(array(

        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getCriteria(array $history = null)
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
        return 'ridic_doses';
    }
}