<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\OutcomesBundle\Outcomes;

use Doctrine\Common\Collections\Criteria;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Accard\Bundle\OutcomesBundle\Exception\ManagerNotInitializedException;
use Accard\Bundle\OutcomesBundle\Exception\TargetNotFoundException;
use Accard\Bundle\OutcomesBundle\Exception\TargetPrototypeNotFoundException;
use Accard\Bundle\CoreBundle\State\StateInstance;
use DAG\Bundle\ResourceBundle\ExpressionLanguage\AccardLanguage;

/**
 * Outcomes manager.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Manager extends ContainerAware
{
    /**
     * State instance.
     *
     * @var StateInstance
     */
    private $state;

    /**
     * Filter registry.
     *
     * @var FilterRegistry
     */
    private $filterRegistry;

    /**
     * Base dataset factory builder.
     *
     * At the moment, we only need one of these ever. So we'll cache it.
     *
     * @var BaseDatasetFactoryBuilder
     */
    private $factoryBuilderCache;

    /**
     * Export factory.
     *
     * At the moment, we only need one of these. So cache it.
     *
     * @var ExportFactory
     */
    private $exportFactoryCache;

    /**
     * Dataset translator.
     *
     * At the moment, we only need one of these. So cache it.
     *
     * @var DatasetTranslator
     */
    private $datasetTranslatorCache;


    /**
     * Constructor.
     *
     * @param FilterRegistry $filterRegistry
     */
    public function __construct(FilterRegistry $filterRegistry)
    {
        $this->filterRegistry = $filterRegistry;
    }

    /**
     * Set state on which to operate.
     *
     * @param StateInstance $state
     */
    public function setState(StateInstance $state)
    {
        $this->state = $state;
    }

    /**
     * Create an active configuration.
     *
     * @param ConfigurationInterface $config
     * @return ActiveConfiguration
     */
    public function createActiveConfig(ConfigurationInterface $config)
    {
        $this->assertRequirementsMet();

        return new ActiveConfiguration($config, $this->state, $this->filterRegistry);
    }

    /**
     * Create an export factory instance.
     *
     * @return ExportFactory
     */
    public function createExportFactory()
    {
        $this->assertRequirementsMet();

        if (null === $this->exportFactoryCache) {
            $this->exportFactoryCache = new ExportFactory();
        }

        return $this->exportFactoryCache;
    }

    /**
     * Export a dataset.
     *
     * Exports a dataset via the export factory. This message is a proxy method
     * for exporting via more verbose methods.
     *
     * @param TransDataset $dataset
     * @param string $exportFactory
     * @return string
     */
    public function export(TransDataset $dataset, $exportFactory)
    {
        return $this->createExportFactory()->export($dataset, $exportFactory);
    }

    /**
     * Generate a consistent file path.
     *
     * @param string $filename
     * @return string
     */
    public function generateExportFilePath($filename)
    {
        return $this->getExportFolderPath().$filename;
    }

    /**
     * Generate the export folder path.
     *
     * @return string
     */
    public function getExportFolderPath()
    {
        return sys_get_temp_dir()."outcomes".DIRECTORY_SEPARATOR;
    }

    /**
     * Export a dataset, and format a response.
     *
     * @param TransDataset $dataset
     * @param string $exportFactory
     * @param string $filename
     * @param array|null $options
     * @return string
     */
    public function exportToFile(TransDataset $dataset, $exportFactory, $filename, array $options = null)
    {
        $exporter = $this->createExportFactory()->getExporter($exportFactory);

        // Make temp file.
        @mkdir($this->getExportFolderPath(), 0777, true);
        $tempfile = $this->generateExportFilePath($filename);
        touch($tempfile);
        $temp = fopen($tempfile, "w");
        fwrite($temp, $exporter->export($dataset, $options));
        fclose($temp);

        return $tempfile;
    }

    /**
     * Create a base dataset factory builder.
     *
     * @todo Remove dependency on the container, it's ugly.
     * @return BaseDatasetFactoryBuilder
     */
    public function createBaseDatasetFactoryBuilder()
    {
        $this->assertRequirementsMet();

        if (null == $this->factoryBuilderCache) {
            $this->factoryBuilderCache = new BaseDatasetFactoryBuilder($this->container);
        }

        return $this->factoryBuilderCache;
    }

    /**
     * Generate a base dataset factory for a given configuration.
     *
     * @param ConfigurationInterface $config
     * @return BaseDatasetFactory
     */
    public function createBaseDatasetFactory(ConfigurationInterface $config)
    {
        if ($config instanceof ActiveConfigurationInterface) {
            $config = $config->getOriginalConfig();
        }

        return $this->createBaseDatasetFactoryBuilder()->create($config->getTarget());
    }

    /**
     * Generate a base dataset for a given configuration.
     *
     * @param ConfigurationInterface $config
     * @return BaseDataset
     */
    public function createBaseDataset(ConfigurationInterface $config)
    {
        if (!$config instanceof ActiveConfigurationInterface) {
            $config = $this->createActiveConfig($config);
        }

        return $this->createBaseDatasetFactory($config)->create($config);
    }

    /**
     * Create a dataset translator.
     *
     * @return DatasetTranslator
     */
    public function createDatasetTranslator()
    {
        if (null === $this->datasetTranslatorCache) {
            $exprLanguage = $this->container->get('accard.expression_language');
            AccardLanguage::setExpressionLanguage($exprLanguage);
            $this->datasetTranslatorCache = new DatasetTranslator(AccardLanguage::getInstance());
        }

        return $this->datasetTranslatorCache;
    }

    /**
     * Translate a base dataset.
     *
     * Convenience method, acting as a proxy for creating a translated vs more
     * verbose methods.
     *
     * @param BaseDataset $dataset
     * @return TransDataset
     */
    public function translate(BaseDataset $dataset)
    {
        return $this->createDatasetTranslator()->translate($dataset);
    }

    /**
     * Ensure all requirements are met for running this manager.
     *
     * @throws ManagerNotInitializedException If prerequisites are not met.
     */
    private function assertRequirementsMet()
    {
        if (null === $this->container || null === $this->state) {
            throw new ManagerNotInitializedException();
        }
    }
}
