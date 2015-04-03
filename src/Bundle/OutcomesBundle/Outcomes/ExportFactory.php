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

use Accard\Bundle\OutcomesBundle\Exception\ExportFormatNotAllowedException;
use Accard\Bundle\OutcomesBundle\Exception\ExportFormatNotFoundException;

/**
 * Export factory.
 *
 * This is currently implemented quite statically, I'd like to expand this to
 * accomodate custom export formats in a more coherent fashion.
 *
 * @todo Refactor for custom export types.
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ExportFactory
{
    /**
     * Exporters.
     *
     * @var array
     */
    private $exporters = array();


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->exporters["csv"] = new Export\CsvExporter();
        $this->exporters["xml"] = new Export\XmlExporter();
        $this->exporters["json"] = new Export\JsonExporter();
    }

    /**
     * Get an exporter.
     *
     * @param string $exportFormat
     * @return Export\ExporterInterface
     */
    public function getExporter($exportFormat)
    {
        if (!$this->hasExporter($exportFormat)) {
            throw new ExportFormatNotFoundException($exportFormat);
        }

        return $this->exporters[$exportFormat];
    }

    /**
     * Test for presence of an exporter.
     *
     * @param string $exportFormat
     * @return boolean
     */
    public function hasExporter($exportFormat)
    {
        return isset($this->exporters[$exportFormat]);
    }

    /**
     * Export data, returning the data.
     *
     * @param TransDataset $dataset
     * @param string $exportFormat
     * @param array|null $options
     * @return string
     */
    public function export(TransDataset $dataset, $exportFormat, array $options = null)
    {
        $this->assertFormatAllowed($exportFormat);

        return $this->getExporter($exportFormat)->export($dataset, $options);
    }

    /**
     * Test if export format is allowed.
     *
     * @param string $exportFormat
     * @return boolean
     */
    public function exportFormatAllowed($exportFormat)
    {
        return in_array($exportFormat, array_keys($this->exporters));
    }

    /**
     * Assert that format is allowed.
     *
     * @param string $exportFormat
     * @throws ExportFormatNotAllowedException If format is not allowed.
     */
    private function assertFormatAllowed($exportFormat)
    {
        if (!$this->exportFormatAllowed($exportFormat)) {
            throw new ExportFormatNotAllowedException($exportFormat);
        }
    }
}
