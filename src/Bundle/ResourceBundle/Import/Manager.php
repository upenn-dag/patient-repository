<?php
namespace Accard\Bundle\ResourceBundle\Import;

/**
 * Import Manager
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Event\ImportEvent;
use Accard\Bundle\ResourceBundle\Import\ManagerInterface;
use Accard\Bundle\ResourceBundle\Import\InitializerInterface;
use Accard\Bundle\ResourceBundle\Import\ConverterInterface;
use Accard\Bundle\ResourceBundle\Import\PersisterInterface;

class Manager implements ManagerInterface
{
	/**
	 * Dry Run Option
	 * 
	 * @var boolean
	 */
	private $dryRunOption;

	/**
	 * Initializer
	 * 
	 * @var ImportInitializerInterface
	 */
	private $initializer;

	/**
	 * Converter
	 * 
	 * @var ImportConverterInterface
	 */
	private $converter;

	/**
	 * Persister
	 * 
	 * @var ImportPersisterInterface
	 */
	private $persister;

	/**
	 * Constructor
	 */
	public function __construct(InitializerInterface $initializer,
								ConverterInterface $converter,
								PersisterInterface $persister)
	{
		$this->initializer = $initializer;
		$this->converter = $converter;
		$this->persister = $persister;
	}

	/**
	 * Initialize
	 */
	public function initialize(ImportEvent $event)
	{
		$this->initializer->initialize($event);
	}

	/**
	 * Convert
	 */
	public function convert(ImportEvent $event)
	{
		$this->converter->convert($event);
	}

	/**
	 * Persist
	 */
	public function persist(ImportEvent $event)
	{
		if($this->dryRunOption) {
			return;
		}

		$this->persister->persist($event);
	}

	/**
	 * Set Dry Run Option
	 * 
	 * @var boolean
	 * @return this
	 */
	public function setDryRunOption($dryRunOption)
	{
		$this->dryRunOption = $dryRunOption;

		return $this;
	}

	/**
	 * Get Dry Run Option
	 * 
	 * @return boolean
	 */
	public function getDryRunOption()
	{
		return $this->dryRunOption;
	}

	/**
	 * Set Initializer
	 * 
	 * @param InitializerInterface
	 * @return this
	 */
	public function setInitializer(InitializerInterface $initalizer)
	{
		$this->initalizer = $initalizer;

		return $this;
	}

	/**
	 * Get Initializer
	 * 
	 * @return IntializerInterface
	 */
	public function getInitializer()
	{
		return $this->initalizer;
	}

	/**
	 * Set Converter
	 * 
	 * @param ImporterConverterInterface
	 * @return this
	 */
	public function setConverter(ConverterInterface $converter)
	{
		$this->converter = $converter;

		return $this;
	}

	/**
	 * Get Converter
	 * 
	 * @return ImportConvertInterface
	 */
	public function getConverter()
	{
		return $this->converter;
	}

	/**
	 * Set Persister
	 * 
	 * @param ImportPersisterInterface
	 * @return this
	 */
	public function setPersister(PersisterInterface $persister)
	{
		$this->persister = $persister;
		return $this;
	}

	/**
	 * Get Persister
	 * 
	 * @return ImportPersisterInterface
	 */
	public function getPersister()
	{
		return $this->persister;
	}

} 