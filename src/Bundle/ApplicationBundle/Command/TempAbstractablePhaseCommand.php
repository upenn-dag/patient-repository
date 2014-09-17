<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ApplicationBundle\Command;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Accard\Bundle\PatientBundle\Exception\PatientNotFoundException;
use Accard\Component\Core\Model\PatientPhaseInstance;

/**
 * Temporary abstractable phase command.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class TempAbstractablePhaseCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName("temp:abstractable:phase")
            ->addArgument('phase', InputArgument::REQUIRED, 'Phase to add abstraction.')
            ->setDescription("Adds phase to patients meeting criteria.")
            ->setHelp('Write help')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $now = new DateTime();
        $em = $this->getContainer()->get('accard.manager.patient_phase');
        $phaseLabel = $input->getArgument('phase');
        $phase = $this->getContainer()->get('accard.provider.patient_phase')->getPhase($phaseLabel);
        $patientProvider = $this->getContainer()->get('accard.provider.patient');

        foreach ($this->getMrns() as $mrn) {
            try {
                $patient = $patientProvider->getPatientByMRN($mrn);

                foreach ($patient->getPhases() as $patientPhase) {
                    if ($phase === $patientPhase->getPhase()) {
                        throw new PatientNotFoundException('MRN', $mrn);
                    }
                }

                $phaseInstance = new PatientPhaseInstance();
                $phaseInstance->setTarget($patient);
                $phaseInstance->setPhase($phase);
                $phaseInstance->setStartDate($now);

                $output->writeln('<info>Matched MRN</info>: '.$mrn);
                $em->persist($phaseInstance);
            } catch (PatientNotFoundException $e) {
                $output->writeln('<error>Failed MRN</error>:  '.$mrn);
                unset($patient, $phaseInstance);
            }
        }

        $em->flush();
    }

    private function getMrns()
    {
        return array(
            '048131858',
            '013805189',
            '056307804',
            '044338036',
            '009688599',
            '052393188',
            '057338360',
            '056080922',
            '000895227',
            '057494403',
            '054563499',
            '043705433',
            '045366689',
            '056933583',
            '058133794',
            '042600312',
            '057065450',
            '049115553',
            '012129219',
            '058539669',
            '017509431',
            '017511494',
            '017535204',
            '017439555',
            '057069759',
            '040695512',
            '017106741',
            '060469525',
            '048317820',
            '060535895',
            '043378033',
            '060172731',
            '059951996',
            '060694015',
            '059763482',
            '056287857',
            '060390432',
            '060708773',
            '054780069',
            '060012838',
            '060854445',
            '440250371',
            '040297210',
            '440406007',
            '014060784',
            '059951996',
            '013150099',
            '001618503',
            '054060645',
            '017777699',
            '003547817',
            '440684207',
            '440709111',
            '004616629',
            '057494403',
            '041368994',
            '001618503',
            '058178518',
            '008591539',
            '060248770',
            '001618503',
            '061272886',
            '017628306',
            '060940475',
            '013149927',
            '059045393',
            '056933583',
            '001406578',
            '440517555',
            '017796012',
            '060893823',
            '440597292',
            '044266609',
            '440011534',
            '017796715',
            '440424075',
            '053352712',
            '060860236',
            '060742111',
            '013302112',
            '060094174',
            '051267656',
            '060248770',
            '053820817',
            '059838102',
            '060790672',
            '052057791',
            '440973428',
            '042198192',
            '441002904',
            '440973428',
            '441035839',
            '440973428',
            '441296902',
            '042718882',
            '441054921',
            '007256589',
            '441357407',
            '017694548',
            '441317187',
            '044138113',
            '060094174',
            '440980332',
            '441371317',
            '012885539',
            '005587449',
            '052524139',
            '006961080',
            '000397448',
            '060172731',
            '442770574',
            '443029905',
            '050711803',
            '443224191',
            '047914395',
            '443056353',
            '443195912',
            '442354262',
            '441035839',
            '009359746',
            '442726600',
            '442247607',
            '040895831',
            '443570866',
            '010560597',
            '052100765',
            '440011534',
            '442300455',
            '442775128',
            '013108253',
            '442319141',
            '010642049',
            '442891792',
            '011776101',
            '441800174',
            '442259040',
            '442975009',
            '443031364',
            '047932215',
            '442395752',
            '444532246',
            '005865258',
            '015339641',
            '047017082',
            '444119150',
            '443712690',
            '040178097',
            '059075010',
            '443726435',
            '442561213',
            '014430276',
            '058119090',
            '053964698',
            '042918177',
            '443643333',
            '012009742',
            '443936604',
            '441728631',
            '054518808',
            '060428505',
            '044586196',
            '003133766',
            '442712451',
        );
    }
}
