<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\OutcomesBundle\Outcomes\Export;

use Accard\Bundle\OutcomesBundle\Exception\NoDataFoundException;
use Accard\Bundle\OutcomesBundle\Outcomes\TransDataset;
use Symfony\Component\HttpFoundation\Response;

/**
 * Outcomes CSV exporter.
 *
 * @todo Allow options to be set.
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class CsvExporter implements ExporterInterface
{
    /**
     * {@inheritdoc}
     */
    public function export(TransDataset $dataset, array $options = null)
    {
        if (!count($dataset)) {
            return NoDataFoundException();
        }

        $output = fopen("php://memory", "w");
        $headerRowDone = false;

        foreach ($dataset as $datum) {
            if (!$headerRowDone) {
                fputcsv($output, $datum->keys());
                $headerRowDone = true;
            }

            fputcsv($output, $datum->all());
        }

        fseek($output, 0);
        $data = stream_get_contents($output);
        fclose($output);

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function formatResponse(Response $response)
    {
        $response->headers->set("Content-Type", "application/csv");
    }
}
