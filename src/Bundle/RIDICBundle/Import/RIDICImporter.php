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
            $mrn = $result['hup_mrn'];

            try {
                $result['previous_record'] = $this->provider->getPatientByMRN($mrn);
            } catch (PatientNotFoundException $e) {
                unset($result, $results[$key]);
                continue;
            }

            $record['identifier'] = $result['course_serv'];
            $result['import_description'] = sprintf('%s ridic dose on the %s.', $result['course_serv'], $result['patient']);

            $record = $resolver->resolve($result);

            if($record['patient'] && !in_array($record['course_serv'], $localRecords)) {
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
            //from TREATED_COURSES table
            'first_treatment',
            'last_treatment',
            'course_serv',
            'hup_mrn',
            //from v_COURSE_DOSE
            'ref_point_serv',
            'ref_point_id',
            'rx_total_dose',
            'rx_daily_dose',
            'rx_session_dose',
            'rx_fraction',
            'treated_total_dose',
            'treated_fractions',
            //from v_COURSE_PRIM_CaDx
            'icd9_code',
            'dx_desc',
        ));

        $resolver->setOptional(array(
            //from v_COURSE_PRIM_CaDx
            'dx_comments',
            'stage',
            'stage_basis',
            't',
            'n',
            'm',
            'g',
            'psa',
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