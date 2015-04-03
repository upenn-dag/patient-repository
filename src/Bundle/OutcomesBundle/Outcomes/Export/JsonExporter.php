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

use Accard\Bundle\OutcomesBundle\Outcomes\TransDataset;
use Symfony\Component\HttpFoundation\Response;

/**
 * Outcomes JSON exporter.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class JsonExporter implements ExporterInterface
{
    /**
     * {@inheritdoc}
     */
    public function export(TransDataset $dataset, array $options = null)
    {
        throw new \BadMethodCallException("JSON outcomes exporter not yet implemented.");
    }

    /**
     * {@inheritdoc}
     */
    public function formatResponse(Response $response)
    {
        $response->headers->set("Content-Type", "application/json");
    }
}
