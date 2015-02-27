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
use Accard\Bundle\ResourceBundle\Import\Events;
use Accard\Bundle\ResourceBundle\EventListener\PersistImporterRecordsListener;

/**
 * Import command.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ImportRunnerCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('accard:import:run')
            ->setDescription('Imports domain resources.')
            ->addArgument('importer', InputArgument::REQUIRED, 'Importer to run.')
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Run without persisting.')
            ->setHelp('Write help')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $registry = $container->get('accard.import.registry');
        $managerRegistry = $container->get('accard.import.manager_registry');
        $runner = $container->get('accard.import.runner');
        $importer = $registry->getImporter($input->getArgument('importer'));

        $dry = $input->getOption('dry-run');

        $manager = $managerRegistry->getManager($input->getArgument('importer'));

        $manager->setDryRunOption($dry);
        $runner->setManager($manager);

        if ($dry) {
            $output->writeln('<comment>Performing dry run.</comment>'); 
        }

        $records = $runner->run($importer);

        $output->writeln(sprintf(
            '<info>Successfully ran "%s" (%d records found).</info>',
            $importer->getName(),
            count($records)
        ));
    }
}
