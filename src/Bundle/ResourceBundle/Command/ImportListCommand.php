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

/**
 * List importers command.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ImportListCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName("accard:import:list")
            ->setDescription("List all registered importers.")
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

        $output->writeln('<comment>Listing all registered importers:</comment>');

        foreach ($registry->getImporters() as $importer) {
            $output->write(sprintf('  <info>%s</info>', $importer->getName()));
            $output->writeln('');
        }
    }
}
