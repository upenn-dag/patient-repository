<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ResourceBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Accard\Component\Resource\Model\ImportTargetInterface;

/**
 * Accept records command.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ImportAcceptCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName("accard:import:accept")
            ->addArgument('subject', InputArgument::REQUIRED, 'Import subject.')
            ->addArgument('ids', InputArgument::IS_ARRAY, 'ID\'s to accept.')
            ->setDescription("Accepts import records.")
            ->setHelp('Write help')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $records = array();
        $ids = $input->getArgument('ids');
        $unchanged = array();
        $resolver = $this->getContainer()->get('accard.import.record_resolver');
        $manager = $this->getContainer()
            ->get('accard.import.resource_factory')
            ->resolveSubject($input->getArgument('subject'))
            ->getManager()
        ;

        foreach ($ids as $key => $id) {
            $record = $resolver->createRecordForImport($input->getArgument('subject'), $id);
            $target = $record->getImportTarget();

            if ($record && ImportTargetInterface::ACTIVE === $target->getStatus()) {
                $target->setStatus(ImportTargetInterface::ACCEPTED);
                $manager->persist($record);
                $manager->persist($target);
            } else {
                $unchanged[] = $ids[$key];
                unset($ids[$key]);
            }
        }

        $manager->flush();
        $output->writeln(sprintf(
            '<comment>Accepted "%s" records with the following ids</comment>: %s',
            $input->getArgument('subject'),
            implode(', ', $ids)
        ));
        $output->writeln(sprintf(
            '<error>Ignored the following records</error>: %s',
            implode(', ', $unchanged)
        ));
    }
}
