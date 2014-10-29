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

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Accard\Bundle\ResourceBundle\Event\ImportEvent;
use Accard\Bundle\ResourceBundle\Import\Events;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Import runner.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Runner
{
    protected $dispatcher;
    protected $factory;
    protected $registry;
    protected $option;
    protected $import;
    protected $patient;
    protected $diagnosis;

    public function __construct(EventDispatcherInterface $dispatcher,
                                ResourceResolvingFactory $factory,
                                Registry $registry)
    {
        $this->dispatcher = $dispatcher;
        $this->factory = $factory;
        $this->registry = $registry;

        $this->option = $this->factory->resolveResource('option', ResourceInterface::NONE);
        $this->import = $this->factory->resolveResource('import', ResourceInterface::NONE);
        $this->patient = $this->factory->resolveResource('patient', ResourceInterface::NONE);
        $this->diagnosis = $this->factory->resolveResource('diagnosis', ResourceInterface::NONE);
    }

    /**
     * Get event dispatcher.
     *
     * @return EventDispatcherInterface
     */
    public function getEventDispatcher()
    {
        return $this->dispatcher;
    }

    /**
     * Run importer.
     *
     * @param ImporterInterface|string $importer
     * @return array|ImportTargetInterface[]
     */
    public function run($importer)
    {
        if (!$importer instanceof ImporterInterface) {
            $importer = $this->registry->getImporter($importer);
        }

        $evd = $this->dispatcher;
        $subjectName = $importer->getSubject();

        $subject = $this->factory->resolveResource($subjectName, ResourceInterface::SUBJECT);
        $target = $this->factory->resolveResource('import_' . $subjectName, ResourceInterface::TARGET);
        $event = new ImportEvent($subject, $target);
        $resolver = new OptionsResolver();
        $this->configureDefaultResolver($resolver, $subject, $target);


        $evd->dispatch(Events::INITIALIZE, $event);
        $event->setImporter($importer);
        $event->setHistory($this->import->getRepository()->getAllFor($importer->getName()));
        $evd->dispatch(Events::PRE_IMPORT, $event);
        $importer->configureResolver($resolver);
        $event->setRecords($importer->run($resolver, $event->getImport()->getCriteria()));
        $evd->dispatch(Events::CONVERT, $event);
        $evd->dispatch(Events::POST_IMPORT, $event);
        $event->setImporter(null);
        $evd->dispatch(Events::FINISH, $event);

        return $event->getRecords();
    }

    /**
     * Add default resolver values.
     *
     * @param OptionsResolverInterface $resolver
     * @param ResourceInterface $subject
     * @param ResourceInterface $target
     */
    private function configureDefaultResolver(OptionsResolverInterface $resolver,
                                              ResourceInterface $subject,
                                              ResourceInterface $target)
    {
        $resolver->setDefaults(array(
            'previous_record' => false,
            'subject_resource' => $subject,
            'target_resource' => $target,
            'option_resource' => $this->option,
            'import_resource' => $this->import,
            'patient_resource' => $this->patient,
            'diagnosis_resource' => $this->diagnosis,
        ));

        $resolver->setRequired(array('identifier', 'previous_record', 'import_description'));

        $resolver->setAllowedTypes(array(
            'identifier' => array('array', 'string'),
            'subject_resource' => array('Accard\Bundle\ResourceBundle\Import\ResourceInterface'),
            'target_resource' => array('Accard\Bundle\ResourceBundle\Import\ResourceInterface'),
            'option_resource' => array('Accard\Bundle\ResourceBundle\Import\ResourceInterface'),
            'import_resource' => array('Accard\Bundle\ResourceBundle\Import\ResourceInterface'),
            'patient_resource' => array('Accard\Bundle\ResourceBundle\Import\ResourceInterface'),
            'diagnosis_resource' => array('Accard\Bundle\ResourceBundle\Import\ResourceInterface'),
            'import_description' => 'string',
        ));
    }
}
