<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CPDBundle\Import;

use DateTime;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Accard\Bundle\ResourceBundle\Import\ImporterInterface;
use Accard\Bundle\CoreBundle\Provider\ImportPatientProvider;
use Accard\Component\Prototype\Provider\PrototypeProviderInterface;
use Accard\Bundle\ResourceBundle\Import\SourceAdapterInterface;
use Accard\Bundle\SampleBundle\Import\SampleImporter;

/**
 * Genetic results importer.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class GeneticResultsImporter extends SampleImporter
{
    /**
     * Patient provider.
     *
     * @var ImportPatientProvider
     */
    private $provider;

    /**
     * Local CPD source.
     * 
     * @var SourceInterface
     */
    private $cpdSource;

    /**
     * CPD source.
     * 
     * @var SourceInterface
     */
    private $sourceInterface;

    /**
     * Constructor.
     *
     * @param ImportPatientProvider $provider
     */
    public function __construct(ImportPatientProvider $provider,
                                SourceAdapterInterface $localSource,
                                SourceAdapterInterface $cpdSource)
    {
        $this->provider = $provider;
        $this->localSource = $localSource;
        $this->cpdSource = $cpdSource;
    }

    /**
     * {@inheritdoc}
     */
    public function run(OptionsResolverInterface $resolver)
    {
        $records = array();
        $localRecords = $this->localSource->execute();
        $results = $this->cpdSource->execute();
        $cachedMrns = array();

        foreach($results as $key => $result) {
            $result = array_change_key_case($result, CASE_LOWER);
            $mrn = $result['patient'];

            try {
                if (!isset($cachedMrns[$mrn])) {
                    $result['previous_record'] = $this->provider->getPatientByMRN($mrn);
                    $cachedMrns[$mrn] = $result['previous_record'];
                } else {
                    $result['previous_record'] = $cachedMrns[$mrn];
                }
            } catch (PatientNotFoundException $e) {
                unset($result, $results[$key]);
                continue;
            }

            $record['identifier'] = $result['pk_id'];
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
            'pk_id',
            'cpd_id',
            'gene',
            'gene_id',
            'variant_detected',
            'cdna_change',
            'mutation_type_cdna',
            'mutation_type_protein'
        ));

        $resolver->setOptional(array(
            'protein_change',
            'variant_categorization', 
            'variant_alias', 
            'genetic_test_version_id',
            'transcript_id',
            'position',
            'fdp',
            'frd',
            'fad',
            'faf',
            'genotype',
            'exon_id',
            'exon'
        ));

        $resolver->setAllowedTypes(array(
            'pk_id' => array('string'),
            'cpd_id' => array('string'),
            'gene' => array('string'),
            'gene_id' => array('string', 'null'),
            'variant_detected' => array('string'),
            'variant_categorization' => array('string', 'null'),
            'cdna_change' => array('string'),
            'protein_change' => array('string', 'null'),
            'mutation_type_cdna' => array('string'),
            'mutation_type_protein' => array('string'),
            'variant_alias' => array('string', 'null'),
            'transcript_id' => array('string', 'null'),
            'position' => array('string', 'null'),
            'fdp' => array('string', 'null'),
            'frd' => array('string', 'null'),
            'fad' => array('string', 'null'),
            'faf' => array('string', 'null'),
            'genotype' => array('string', 'null'),
        ));

        $resolver->setAllowedValues(array(
            'variant_detected' => array('Yes', 'No'),
            'variant_categorization' => array('Pathogenic', 'VUS', 'Probably DA', 'Likely Benign', 'Benign', null),
            'variant_alias' => array('ITD', null),
            'mutation_type_cdna' => $mutations,
            'mutation_type_protein' => $mutations,
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
        return 'cpd_genetic_results';
    }
}
