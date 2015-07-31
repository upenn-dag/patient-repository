<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\HMTBBundle\Import;

use PDO;
use DateTime;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Accard\Bundle\SampleBundle\Import\SampleImporter;
use DAG\Bundle\ResourceBundle\Import\ImporterInterface;
use Accard\Bundle\CoreBundle\Provider\ImportPatientProvider;
use DAG\Bundle\ResourceBundle\Import\SourceAdapterInterface;
use DAG\Bundle\ResourceBundle\Import\CriteriaInterface;

/**
 *  HMTB Specimens importer.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class SpecimensCollectionImporter extends SampleImporter
{
    /**
     * Patient provider.
     *
     * @var ImportPatientProvider
     */
    private $provider;

    /**
     * Local HMTB results source..
     *
     * @var SourceAdapterInterface
     */
    private $localSource;

    /**
     * HMTB results source.
     *
     * @var SourceAdapterInterface
     */
    private $hmtbSource;

    /**
     * HMTB criteria.
     *
     * @var Criteria Interface
     */
    private $criteria;

    /**
     * Constructor.
     *
     * @param ImportPatientProvider $provider
     * @param SourceAdapterInterface Interface $localSource
     * @param SourceAdapterInterface Interface $hmtbSource
     * @param CriteraInterface $criteria
     */
    public function __construct(
        ImportPatientProvider $provider,
        SourceAdapterInterface $localSource,
        SourceAdapterInterface $hmtbSource,
        CriteriaInterface $criteria
    ) {
        $this->provider = $provider;
        $this->localSource = $localSource;
        $this->hmtbSource = $hmtbSource;
        $this->criteria = $criteria;
    }

    /**
     * {@inheritdoc}
     */
    public function run(OptionsResolverInterface $resolver)
    {
        $records = array();

        if (!$this->criteria->passes()) {
            return $records;
        }

        $results = $this->hmtbSource->execute($this->criteria->retrieve());
        $localRecords = $this->localSource->execute();

        foreach ($results as $key => $result) {
            $result = array_change_key_case($result, CASE_LOWER);

            try {
                $result['previous_record'] = $this->provider->getPatientByMRN($result['patient']);
            } catch (PatientNotFoundException $e) {
            }

            $record['identifier'] = $result['hmtb_id'];
            $result['import_description'] = sprintf('%s specimen on the %s.', $result['hmtb_id'], $result['patient']);

            $record = $resolver->resolve($result);

            if (!is_null($record['patient']) && $record['restricted'] == 'No' && !in_array($record['identifier'], $localRecords)) {
                $records[] = $record;
            }

            unset($results[$key]);
        }

        return $records;
    }

    /**
     * {@inheritdoc}
     */
    public function configureResolver(OptionsResolverInterface $resolver)
    {
        parent::configureResolver($resolver);

        $resolver->setRequired(array(
            'hmtb_id',
            'sample_type',
            'patient',
            'diagnosis'
        ));

        $resolver->setOptional(array(
                                     '0',
                                     '1',
                                     '2',
                                     'subtype',
                                     'restricted',
                                     'total_sum_vials_remaining',
                                     'blasts',
                                     'ct_cycle',
                                     'ct_study_day',
                                     'ct_peak_through',
                                     'ct_time_post_drug',
                                     'ct_time_post_drug_unit',
                                     'ct_treatment_relation_time',
                                     'when_modified'));

        $resolver->setAllowedTypes(array(
            'hmtb_id' => array('string'),
            'restricted' => array('string'),
        ));

        $resolver->setAllowedValues(array(
            $sample_type = array('BM-MNC', 'PB-MNC', 'Phereis'),
            $restricted = array('No', 'YES'),
            $diagnosis = array('AML'),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getCriteria(array $history = null)
    {
        return $this->criteria->retrieve();
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
        return 'hmtb_specimens_collection';
    }
}
