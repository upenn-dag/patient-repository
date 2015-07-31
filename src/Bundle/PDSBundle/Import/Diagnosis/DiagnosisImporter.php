<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\PDSBundle\Import\Diagnosis;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Accard\Bundle\PatientBundle\Import\PatientImporter;
use Accard\Component\Patient\Exception\PatientNotFoundException;
use Accard\Bundle\CoreBundle\Provider\ImportPatientProvider;
use DAG\Bundle\ResourceBundle\Import\SourceAdapterInterface;
use DAG\Bundle\ResourceBundle\Import\CriteriaInterface;

/**
 * Diagnosis importer.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class DiagnosisImporter extends PatientImporter
{
    /**
     * Patient provider.
     *
     * @var ImportPatientProvider
     */
    private $provider;

    /**
     * PDS diagnosis source.
     *
     * @var SourceAdapterInterface
     */
    private $pdsSource;

    /**
     * PDS common criteria.
     *
     * @var CriteriaInterface
     */
    private $criteria;

    /**
     * Constructor.
     *
     * @param ImportPatientProvider $provider
     * @param SourceAdapterInterface $pdsSource
     */
    public function __construct(
        ImportPatientProvider $provider,
        SourceAdapterInterface $pdsSource,
        CriteriaInterface $criteria
    ) {
        $this->provider = $provider;
        $this->pdsSource = $pdsSource;
        $this->criteria = $criteria;
    }

    /**
     * {@inheritdoc}
     */
    public function run(OptionsResolverInterface $resolver)
    {
        $records = array();

        $results = $this->pdsSource->execute($this->getCriteria());

        foreach ($results as $key => $result) {
            $result = array_change_key_case($result, CASE_LOWER);

            try {
                if ($record = $this->provider->getPatientByMRN($result['mrn'])) {
                    $result['previous_record'] = $record;
                }
            } catch (PatientNotFoundException $e) {
            }

            $result['identifier'] = $result['mrn'];
            $result['import_description'] = sprintf('%s diagnosis on %s.', $result['diagnosis'], $result['diagnosis_date']);

            unset($result['diagnosis'], $result['diagnosis_date']);
            $records[] = $resolver->resolve($result);
            unset($results[$key]);
        }

        return $records;
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
        return $this->criteria->retrieveDefault();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'pds_diagnosis';
    }
}
